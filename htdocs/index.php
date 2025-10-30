<?php
// index.php

$data = [
    "cpu" => sys_getloadavg()[0],
    "memory" => memory_get_usage(true) / 1024 / 1024,
    "disk" => disk_free_space("/") / disk_total_space("/") * 100,
    "uptime" => shell_exec("uptime -p")
];
?>

<!DOCTYPE html>
<html>
<head>
  <title>Server Monitor Dashboard</title>
  <link rel="stylesheet" href="css/style.css">
  <script src="js/dashboard.js"></script>
</head>
<body>
  <div class="dashboard">
    <h1>Server Monitor</h1>

    <div class="card">
      <h2>CPU Load</h2>
      <p id="cpu"><?php echo round($data['cpu'], 2); ?>%</p>
    </div>

    <div class="card">
      <h2>Memory Usage</h2>
      <p id="memory"><?php echo round($data['memory'], 2); ?> MB</p>
    </div>

    <div class="card">
      <h2>Disk Free</h2>
      <p id="disk"><?php echo round($data['disk'], 2); ?>%</p>
    </div>

    <div class="card">
      <h2>Uptime</h2>
      <p id="uptime"><?php echo $data['uptime']; ?></p>
    </div>
  </div>
</body>
</html>
