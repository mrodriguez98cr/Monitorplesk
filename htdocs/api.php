<?php
header("Content-Type: application/json");

$data = [
    "cpu" => sys_getloadavg()[0],
    "memory" => memory_get_usage(true) / 1024 / 1024,
    "disk" => (disk_total_space("/") - disk_free_space("/")) / disk_total_space("/") * 100,
    "uptime" => trim(shell_exec("uptime -p"))
];

echo json_encode($data);
