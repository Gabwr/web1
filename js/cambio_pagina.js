document.addEventListener("DOMContentLoaded", function () {
  cargarPagina("inicio.php");
  document.querySelectorAll('a[href]').forEach((link) => {
    link.addEventListener("click", function (event) {
      event.preventDefault();
      document.getElementById("contenido").innerHTML = "";
      cargarPagina(this.getAttribute("href"));
    });
  });
});

function cargarPagina(url) {
  fetch(url)
    .then((response) => {
      if (!response.ok) {
        throw new Error("Error en la respuesta del servidor");
      }
      return response.text();
    })
    .then((php) => {
      const contenido = document.getElementById("contenido");
      contenido.innerHTML = php;
      contenido.querySelectorAll("script").forEach((script) => {
        const nuevoScript = document.createElement("script");
        if (script.src) {
          nuevoScript.src = script.src;
          nuevoScript.async = true;
        } else {
          nuevoScript.textContent = script.textContent;
        }
        document.body.appendChild(nuevoScript);
      });
    })
    .catch((error) => {
      console.error("Error al cargar el contenido:", error);
      document.getElementById("contenido").innerHTML =
        "<p>Error al cargar el contenido.</p>";
    });
}
