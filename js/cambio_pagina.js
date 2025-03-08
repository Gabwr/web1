document.addEventListener("DOMContentLoaded", function () {
  cargarPagina("inicio.php");
  let user="";
  let estate="";
  if(sessionStorage.getItem("usuario")==null){
    user=document.getElementById("usuario").innerHTML;
    sessionStorage.setItem("usuario",user);
  }else{
    user = sessionStorage.getItem("usuario");
  }
  if(sessionStorage.getItem("estado")==null){
    estate = document.getElementById("lestate").innerHTML;
    sessionStorage.setItem("estado",estate);
  }
  $.ajax({
    url: "../server/getpermisosperfil.php",
    method: "POST",
    data: { usuario: user},
    success: function (response) {
        try {
            sessionStorage.setItem("perfil", response); 
            setTimeout(restringir, 50);
        } catch (e) {
            console.log("Error al procesar los permisos");
        }
    },
    error: function () {
        alert("Error al obtener permisos desde el servidor");
    }
});


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


function restringir() {
  let perfil = sessionStorage.getItem("perfil"); 
  let leestate = sessionStorage.getItem("estado")
  
  if (!leestate) {
    console.warn("No se encontró usuario en sessionStorage");
    return;
  }

  //usuario inactivo
  if(leestate=="Inactivo"){
    sessionStorage.clear();
    window.location.href = "inactivo.php";
  }

  if (!perfil) {
      console.warn("No se encontró perfil en sessionStorage");
      return;
  }

  perfil = JSON.parse(perfil);

  if (perfil.lectura_ingresos != true && perfil.Insercion_ingresos_ != true && perfil.edicion_ingresos != true) {
      document.getElementById("ingrperf").style.display = "none";

  }
  if (perfil.lectura_gastos != true && perfil.insercion_gastos != true && perfil.edicion_gastos != true) {
      document.getElementById("gastperf").style.display = "none";
  }

  if (perfil.lectura_usuarios != true && perfil.insercion_usuarios != true && perfil.edicion_usuarios != true) {
    document.getElementById("userperf").style.display = "none";
  }

  if (perfil.lectura_perfiles != true && perfil.insercion_perfiles != true && perfil.edicion_perfiles != true) {
    document.getElementById("perfperf").style.display = "none";
  }

  if (perfil.lectura_conceptos != true && perfil.insercion_conceptos != true && perfil.edicion_conceptos != true) {
    document.getElementById("cncpperf").style.display = "none";
  }

  if (perfil.permiso_qr != true ) {
    document.getElementById("qrperf").style.display = "none";
  }
}