document.addEventListener("DOMContentLoaded", function () {
  const linkInicio = document.querySelector('a[href="inicio.php"]');

  if (linkInicio) {
    linkInicio.addEventListener("click", function (event) {
      event.preventDefault(); 
      fetch(this.getAttribute("href"))
        .then((response) => {
          if (!response.ok) {
            throw new Error("Error en la respuesta del servidor");
          }
          return response.text();
        })
        .then((php) => {
          document.getElementById("contenido").innerHTML = php; // Inserta el contenido cargado
        })
        .catch((error) => {
          console.error("Error al cargar el contenido:", error);
          document.getElementById("contenido").innerHTML =
            "<p>Error al cargar el contenido.</p>";
        });
    });
  }
});