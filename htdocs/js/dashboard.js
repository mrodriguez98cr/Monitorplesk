// Actualiza los datos cada 5 segundos
setInterval(() => {
  fetch("api.php")
    .then(res => res.json())
    .then(data => {
      document.getElementById("cpu").textContent = data.cpu + "%";
      document.getElementById("memory").textContent = data.memory + " MB";
      document.getElementById("disk").textContent = data.disk + "%";
    });
}, 5000);

// Cargar inmediatamente al abrir
fetch("api.php")
  .then(res => res.json())
  .then(data => {
    document.getElementById("cpu").textContent = data.cpu + "%";
    document.getElementById("memory").textContent = data.memory + " MB";
    document.getElementById("disk").textContent = data.disk + "%";
  });
