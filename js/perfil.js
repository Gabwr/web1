$(document).ready(function() {
    $(document).on("click", ".editar-perfil", function() {
        let perfil = $(this).data("perfil");
        originalValues = { perfil: perfil };

        $("#nombrepfedit").val(perfil);
        $.ajax({
            url: '../server/getpermisos.php',
            method: 'POST',
            data: { perfil: perfil },
            success: function(response) {
                try {
                    let permisos = JSON.parse(response);
                    $("#permisosContainer").html("");
                    $.each(permisos, function(permiso, estado) {
                        let checkboxHtml = `
                            <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="permisos[]" 
                        value="${permiso}" id="permiso_${permiso}" ${estado ? 'checked' : ''}>
                        <label class="form-check-label" for="permiso_${permiso}">${permiso}</label>
                            </div>`;
                        $("#permisosContainer").append(checkboxHtml);
                    });
                } catch (e) {
                 alert("Error al procesar los permisos");
                }
            },
            error: function(xhr, status, error) {
            console.error("AJAX fallo");
            alert("Error al obtener permisos desde el servidor");
            }
        });

        $("#editarmodal").modal("show");
    });

    $("#guardarCambios").click(function() {
        let nuevoNombre = $("#nombrepfedit").val().trim();
        if (nuevoNombre === "") {
            alert("El nombre del perfil no puede estar vacío.");
            return;
        }
    
        let permisosSeleccionados = [];
        document.querySelectorAll("input[name='permisos[]']:checked").forEach((checkbox) => {
            permisosSeleccionados.push(checkbox.value);
        });
    
        if (permisosSeleccionados.length === 0) {
            alert("Debe seleccionar al menos un permiso para el perfil");
            return;
        }
    
        $.ajax({
            url: '../server/actualizarperfil.php',
            method: 'POST',
            data: {
                perfil: originalValues.perfil, 
                nuevoPerfil: nuevoNombre,
                permisos: permisosSeleccionados
            },
            success: function(response) {
                console.log("Respuesta del servidor:", response);
                if (response === "success") {
                    alert("Perfil actualizado correctamente.");
                    location.reload();
                } else {
                    alert("Error al actualizar el perfil.");
                }
            },
            error: function(xhr, status, error) {
                console.error("AJAX request failed: " + error);
                alert("Error al actualizar el perfil.");
            }
        });
    });
        
});



//ingreso de perfil
var botonAgregar = document.getElementById("usuariodialog");
if (botonAgregar && !botonAgregar.dataset.eventoAgregado) {
    botonAgregar.addEventListener("click", function () {
        var modal = new bootstrap.Modal(document.getElementById("miDialogo"));
        modal.show();
        document.getElementById("nombrepf").value = "";
        let perfil = "Administrador";
        $.ajax({
            url: '../server/getpermisos.php',
            method: 'POST',
            data: { perfil: perfil },
            success: function(response) {
                try {
                    let permisos = JSON.parse(response);
                    $("#permisoscontainerinsert").html("");
                    $.each(permisos, function(permiso) {
                        let checkboxHtml = `
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="permisos[]" 
                                value="${permiso}" id="permisoi_${permiso}">
                                <label class="form-check-label" for="permisoi_${permiso}">${permiso}</label>
                            </div>`;
                        $("#permisoscontainerinsert").append(checkboxHtml);
                    });
                } catch (e) {
                    alert("Error al procesar los permisos: " + e.message);
                }
            },
            error: function(xhr, status, error) {
                console.error("AJAX request failed: " + error);
                alert("Error al obtener permisos desde el servidor.");
            }
        });
    });

    botonAgregar.dataset.eventoAgregado = "true";
}

var botonIngreso = document.getElementById("ingreso");
if (botonIngreso && !botonIngreso.dataset.eventoAgregado) {
    document.getElementById("ingreso").addEventListener("click", function(event) {
        event.preventDefault(); 
        
        let nombrePerfil = document.getElementById("nombrepf").value;
        let soloLetras = /^[A-Za-zÁÉÍÓÚáéíóúñÑ\s]+$/;

        if (nombrePerfil === "") {
            alert("Ingrese un nombre para el perfil");
            return;
        }

        if (!soloLetras.test(nombrePerfil)) {
            alert("El Nombre del perfil solo debe contener letras y espacios");
            return;
        }

        let permisosSeleccionados = [];
        document.querySelectorAll("input[name='permisos[]']:checked").forEach((checkbox) => {
            permisosSeleccionados.push(checkbox.value);
        });

        if (permisosSeleccionados.length === 0) {
            alert("Debe seleccionar al menos un permiso para el perfil");
            return;
        }

        $.ajax({
            url: '../server/insertarperfil.php',
            method: 'POST',
            data: {
                nombrePerfil: nombrePerfil, 
                permisos: permisosSeleccionados, 
            },
            success: function(response) {
                alert("Perfil ingresado correctamente!!"); 
                location.reload(); 
            },
            error: function() {
                alert("Error al ingresar el perfil.");
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
