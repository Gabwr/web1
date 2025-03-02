document.addEventListener("DOMContentLoaded", function () {
    cargarPagina("inicio.php");

    document.querySelectorAll('a[href]').forEach((link) => {
      link.addEventListener("click", function (event) {
        event.preventDefault();
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

        document.getElementById("contenido").innerHTML = php;
      if (url == "Usuarios.php") {
        let botonAgregar = document.getElementById("Agregar");
        if (botonAgregar) {
          botonAgregar.addEventListener("click", function () {
            var modal = new bootstrap.Modal(document.getElementById("miDialogo"));
            modal.show();
          });
        }
      }
      })
      .catch((error) => {
        console.error("Error al cargar el contenido:", error);
        document.getElementById("contenido").innerHTML =
          "<p>Error al cargar el contenido.</p>";
      });
  }