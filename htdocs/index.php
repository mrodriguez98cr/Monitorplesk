<?php
// index.php - Dashboard
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>Server Monitor Lite</title>
  <link rel="stylesheet" href="css/style.css">
  <script src="js/dashboard.js"></script>
</head>
<body>
  <div class="dashboard">
    <h1>Server Monitor Lite</h1>

    <div class="card">
      <h2>CPU Load</h2>
      <p id="cpu">Cargando...</p>
    </div>

    <div class="card">
      <h2>Memory Usage</h2>
      <p id="memory">Cargando...</p>
    </div>

    <div class="card">
      <h2>Disk Usage</h2>
      <p id="disk">Cargando...</p>
    </div>
  </div>
</body>
</html>
