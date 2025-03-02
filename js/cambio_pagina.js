document.addEventListener("DOMContentLoaded", function () {
  cargarPagina("inicio.php");

  document.body.addEventListener("click", function (event) {
      const link = event.target.closest("a");
      if (link && link.getAttribute("href") && !link.getAttribute("target")) {
          event.preventDefault();
          cargarPagina(link.getAttribute("href"));
      }
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
          const contenidoDiv = document.getElementById("contenido");
          contenidoDiv.innerHTML = php;

          eliminarScriptsPrevios(); 
          ejecutarScripts(contenidoDiv);
      })
      .catch((error) => {
          console.error("Error al cargar el contenido:", error);
          document.getElementById("contenido").innerHTML =
              "<p>Error al cargar el contenido.</p>";
      });
}

function eliminarScriptsPrevios() {
  document.querySelectorAll("script[data-dynamic]").forEach(script => script.remove());
}

function ejecutarScripts(elemento) {
  const scripts = elemento.querySelectorAll("script");

  scripts.forEach((oldScript) => {
    const newScript = document.createElement("script");
    newScript.setAttribute("data-dynamic", "true");
    

      if (oldScript.src) {
          const relativeSrc = obtenerRutaRelativa(oldScript.src);
          newScript.src = relativeSrc;
          newScript.onload = () => console.log("Script cargado correctamente:", newScript.src);
          if (!document.querySelector(`script[src="${relativeSrc}"]`)) {
              document.body.appendChild(newScript);
          }
      } else {
        newScript.onload = () => console.log("Script cargado correctamente:", newScript.src);
          newScript.textContent = oldScript.textContent;
          document.body.appendChild(newScript);
      }

      oldScript.remove();
  });
}


function obtenerRutaRelativa(url) {
  const urlObj = new URL(url, window.location.origin);
  return urlObj.pathname;
}
