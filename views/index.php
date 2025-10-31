<?php
require_once '../../../../wp-load.php';

pm_Context::init('server-monitor');

$request = new pm_Log_Request();
$request->setModuleId('server-monitor');

// Verificar permisos
if (!pm_Session::getClient()->isAdmin()) {
    die('Acceso denegado: Se requieren permisos de administrador');
}

// Obtener datos del sistema
function getSystemInfo() {
    $info = [];
    
    // Uso de CPU
    $load = sys_getloadavg();
    $info['cpu_load'] = [
        '1min' => $load[0],
        '5min' => $load[1],
        '15min' => $load[2]
    ];
    
    // Memoria
    $meminfo = file('/proc/meminfo');
    $mem = [];
    foreach ($meminfo as $line) {
        if (preg_match('/^([^:]+):\s+(\d+)/', $line, $matches)) {
            $mem[$matches[1]] = $matches[2] * 1024; // Convertir a bytes
        }
    }
    
    $info['memory'] = [
        'total' => $mem['MemTotal'] ?? 0,
        'free' => $mem['MemFree'] ?? 0,
        'used' => ($mem['MemTotal'] ?? 0) - ($mem['MemFree'] ?? 0),
        'percent' => ($mem['MemTotal'] ?? 1) > 0 ? 
            (($mem['MemTotal'] - $mem['MemFree']) / $mem['MemTotal']) * 100 : 0
    ];
    
    // Disco
    $disk = disk_free_space("/");
    $disk_total = disk_total_space("/");
    $info['disk'] = [
        'total' => $disk_total,
        'free' => $disk,
        'used' => $disk_total - $disk,
        'percent' => ($disk_total > 0) ? (($disk_total - $disk) / $disk_total) * 100 : 0
    ];
    
    // Uptime
    $uptime = file_get_contents('/proc/uptime');
    $info['uptime'] = floatval(explode(' ', $uptime)[0]);
    
    return $info;
}

$systemInfo = getSystemInfo();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Monitor del Servidor</title>
    <style>
        .dashboard {
            padding: 20px;
            font-family: Arial, sans-serif;
        }
        .card {
            background: #f8f9fa;
            border: 1px solid #dee2e6;
            border-radius: 8px;
            padding: 20px;
            margin: 10px 0;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        .metric {
            margin: 10px 0;
        }
        .progress-bar {
            background: #e9ecef;
            border-radius: 4px;
            height: 20px;
            margin: 5px 0;
        }
        .progress {
            background: #007bff;
            height: 100%;
            border-radius: 4px;
            transition: width 0.3s;
        }
        .progress.warning {
            background: #ffc107;
        }
        .progress.danger {
            background: #dc3545;
        }
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 15px;
            margin: 20px 0;
        }
        .stat-card {
            background: white;
            padding: 15px;
            border-radius: 8px;
            border-left: 4px solid #007bff;
        }
    </style>
</head>
<body>
    <div class="dashboard">
        <h1>🖥️ Monitor del Servidor</h1>
        
        <div class="stats-grid">
            <div class="stat-card">
                <h3>CPU Load</h3>
                <div class="metric">
                    <div>1 min: <strong><?php echo round($systemInfo['cpu_load']['1min'], 2); ?></strong></div>
                    <div>5 min: <strong><?php echo round($systemInfo['cpu_load']['5min'], 2); ?></strong></div>
                    <div>15 min: <strong><?php echo round($systemInfo['cpu_load']['15min'], 2); ?></strong></div>
                </div>
            </div>
            
            <div class="stat-card">
                <h3>Memoria</h3>
                <div class="metric">
                    <div>Usado: <strong><?php echo round($systemInfo['memory']['used'] / 1024 / 1024 / 1024, 2); ?> GB</strong></div>
                    <div>Libre: <strong><?php echo round($systemInfo['memory']['free'] / 1024 / 1024 / 1024, 2); ?> GB</strong></div>
                    <div>Total: <strong><?php echo round($systemInfo['memory']['total'] / 1024 / 1024 / 1024, 2); ?> GB</strong></div>
                </div>
                <div class="progress-bar">
                    <div class="progress <?php echo $systemInfo['memory']['percent'] > 80 ? 'danger' : ($systemInfo['memory']['percent'] > 60 ? 'warning' : ''); ?>" 
                         style="width: <?php echo $systemInfo['memory']['percent']; ?>%">
                    </div>
                </div>
                <div><?php echo round($systemInfo['memory']['percent'], 1); ?>%</div>
            </div>
            
            <div class="stat-card">
                <h3>Disco</h3>
                <div class="metric">
                    <div>Usado: <strong><?php echo round($systemInfo['disk']['used'] / 1024 / 1024 / 1024, 2); ?> GB</strong></div>
                    <div>Libre: <strong><?php echo round($systemInfo['disk']['free'] / 1024 / 1024 / 1024, 2); ?> GB</strong></div>
                    <div>Total: <strong><?php echo round($systemInfo['disk']['total'] / 1024 / 1024 / 1024, 2); ?> GB</strong></div>
                </div>
                <div class="progress-bar">
                    <div class="progress <?php echo $systemInfo['disk']['percent'] > 80 ? 'danger' : ($systemInfo['disk']['percent'] > 60 ? 'warning' : ''); ?>" 
                         style="width: <?php echo $systemInfo['disk']['percent']; ?>%">
                    </div>
                </div>
                <div><?php echo round($systemInfo['disk']['percent'], 1); ?>%</div>
            </div>
            
            <div class="stat-card">
                <h3>Uptime</h3>
                <div class="metric">
                    <?php
                    $uptime = $systemInfo['uptime'];
                    $days = floor($uptime / 86400);
                    $hours = floor(($uptime % 86400) / 3600);
                    $minutes = floor(($uptime % 3600) / 60);
                    ?>
                    <div><strong><?php echo $days; ?>d <?php echo $hours; ?>h <?php echo $minutes; ?>m</strong></div>
                </div>
            </div>
        </div>
        
        <div class="card">
            <button onclick="location.reload()">🔄 Actualizar</button>
            <span style="margin-left: 10px; color: #666;">Última actualización: <?php echo date('H:i:s'); ?></span>
        </div>
    </div>
    
    <script>
        // Auto-refresh cada 30 segundos
        setTimeout(function() {
            location.reload();
        }, 30000);
    </script>
</body>
</html>