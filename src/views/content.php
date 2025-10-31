<?php
// Este archivo se muestra en el panel principal de Plesk
pm_Context::init('server-monitor');

$systemInfo = getSystemInfo();
?>

<div style="padding: 15px;">
    <h3>Resumen del Sistema</h3>
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 10px; margin: 15px 0;">
        <div style="background: #f8f9fa; padding: 10px; border-radius: 5px;">
            <strong>CPU Load:</strong><br>
            <?php echo round($systemInfo['cpu_load']['1min'], 2); ?>
        </div>
        <div style="background: #f8f9fa; padding: 10px; border-radius: 5px;">
            <strong>Memoria:</strong><br>
            <?php echo round($systemInfo['memory']['percent'], 1); ?>%
        </div>
        <div style="background: #f8f9fa; padding: 10px; border-radius: 5px;">
            <strong>Disco:</strong><br>
            <?php echo round($systemInfo['disk']['percent'], 1); ?>%
        </div>
    </div>
    <a href="/modules/server-monitor/index.php" class="btn action">Ver Dashboard Completo</a>
</div>