$(document).ready(function() {
  let originalValues = {};

  $(document).on("click", ".editar-usuario", function() {
      let id = $(this).data("id");
      let nombre = $(this).data("nombre");
      let apellido = $(this).data("apellido");
      let usuario = $(this).data("usuario");
      let perfil = $(this).data("perfil");

      // Guardamos los valores originales para compararlos luego
      originalValues = {
          id: id,
          nombre: nombre,
          apellido: apellido,
          usuario: usuario,
          perfil: perfil
      };

      // Asignamos los valores a los campos del formulario
      $("#edit-idUsuario").val(id);
      $("#edit-nombre").val(nombre);
      $("#edit-apellido").val(apellido);
      $("#edit-usuario").val(usuario);
      $("#edit-perfil").val(perfil);

      // Mostramos el modal de edición
      $("#editarmodal").modal("show");
  });

  $("#guardarCambios").click(function() {
    let id = $("#edit-idUsuario").val();
    let user = $("#edit-usuario").val();
    let nomb = $("#edit-nombre").val().trim();
    let apll = $("#edit-apellido").val().trim();
    let perfil = $("#edit-perfil").val();

    if (user === originalValues.usuario && nomb === originalValues.nombre && apll === 
      originalValues.apellido && perfil === originalValues.perfil) {
        alert("No se han realizado cambios.");
        return;  
    }

    let soloLetras = /^[A-Za-zÁÉÍÓÚáéíóúñÑ\s]+$/;
    if (user === "" || nomb === "" || apll === "" || perfil === "seleccione") {
        alert("Todos los campos son obligatorios");
        return;
    }

    if (!soloLetras.test(nomb)) {
        alert("El Nombre solo debe contener letras y espacios");
        return;
    }

    if (!soloLetras.test(apll)) {
        alert("El Apellido solo debe contener letras y espacios");
        return;
    }

    $.ajax({
        url: '../server/editarUsuario.php',
        method: 'POST',
        data: {
            id: id,
            usuario: user,
            nombre: nomb,
            apellido: apll,
            perfil: perfil
        },
        success: function(response) {
            alert("Usuario Actualizado Correctamente!!!");
            location.reload();
        },
        error: function() {
            alert("Error al actualizar el usuario.");
        }
    });
  });
});

//ingreso de usuario
var botonAgregar = document.getElementById("usuariodialog");
if (botonAgregar && !botonAgregar.dataset.eventoAgregado) {
    botonAgregar.addEventListener("click", function () {
        var modal = new bootstrap.Modal(document.getElementById("miDialogo"));
        modal.show();
         document.getElementById("usuario").value = "";
        document.getElementById("nombre").value = "";
        document.getElementById("apellido").value = "";
        document.getElementById("perfil").selectedIndex = 0;
    });
    botonAgregar.dataset.eventoAgregado = "true";
}

var botonIngreso = document.getElementById("ingreso");
if (botonIngreso && !botonIngreso.dataset.eventoAgregado) {
  document.getElementById("ingreso").addEventListener("click", function(event) {
    event.preventDefault(); 

    let user = document.getElementById("usuario").value.trim();
    let nomb = document.getElementById("nombre").value.trim();
    let apll = document.getElementById("apellido").value.trim();
    let pass = user+nomb+apll;
    let perfil = document.getElementById("perfil").value;

    let soloLetras = /^[A-Za-zÁÉÍÓÚáéíóúñÑ\s]+$/;

    if (user === "" || pass === "" || nomb === "" || apll === "" || perfil === "seleccione") {
        alert("Todos los campos son obligatorios");
        return;
    }
    if (!soloLetras.test(nomb)) {
        alert("El Nombre solo debe contener letras y espacios");
        return;
    }
    if (!soloLetras.test(apll)) {
        alert("El Apellido solo debe contener letras y espacios");
        return;
    }

    $.ajax({
        url: '../server/insercionuser.php',
        method: 'POST',
        data: {
            usuario: user,
            contrasenia: pass,
            nombre: nomb,
            apellido: apll,
            perfil: perfil
        },
        success: function(response) {
            alert("Usuario Ingresado Correctamente!!"); 
            location.reload();
        },
        error: function() {

            alert("Error al ingresar el usuario.");
        }
    });
});

    botonIngreso.dataset.eventoAgregado = "true";
}

//ativa y desactiva usuario
$(document).ready(function() {
  $(document).on("click", ".toggle-estado", function() {
      let idUsuario = $(this).data("id");
      let estadoActual = $(this).data("estado");
      let nuevoEstado = estadoActual === "Activo" ? "Inactivo" : "Activo";
      $.ajax({
          url: '../server/cambiarestadousuario.php',
          method: 'POST',
          data: {
              id: idUsuario,
              estado: nuevoEstado
          },
          success: function(response) {
              if (response === "success") {
                  alert("Estado cambiado correctamente.");
                  location.reload();
              } else {
                  alert("Error al cambiar el estado.");
              }
          },
          error: function() {
              alert("Error en la solicitud AJAX.");
          }
      });
  });
});


//creador de usuario
$(document).ready(function() {
    $(document).on("keyup", "#apellido", function() {
        let userio = "";
        let nombro = document.getElementById("nombre").value.trim();
        let apllio = document.getElementById("apellido").value.trim();
        userio = nombro[0] + apllio;
        document.getElementById("usuario").value = userio;
    });
  });