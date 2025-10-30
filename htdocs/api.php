<?php
header("Content-Type: application/json");

// CPU Load
$cpu = sys_getloadavg()[0];

// Memory Usage (total en MB)
$memory = memory_get_usage(true) / 1024 / 1024;

// Disk Usage (%)
$disk = (disk_total_space("/") - disk_free_space("/")) / disk_total_space("/") * 100;

echo json_encode([
    "cpu" => round($cpu, 2),
    "memory" => round($memory, 2),
    "disk" => round($disk, 2)
]);
