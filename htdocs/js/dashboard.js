setInterval(() => {
  fetch("api.php")
    .then(res => res.json())
    .then(data => {
      document.getElementById("cpu").textContent = data.cpu.toFixed(2) + "%";
      document.getElementById("memory").textContent = data.memory.toFixed(2) + " MB";
      document.getElementById("disk").textContent = data.disk.toFixed(2) + "%";
      document.getElementById("uptime").textContent = data.uptime;
    });
}, 5000);
