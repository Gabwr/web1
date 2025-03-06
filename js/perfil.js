$(document).ready(function() {
    $(document).on("click", ".editar-perfil", function() {
        let perfil = $(this).data("perfil");
        

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

        originalValues = { perfil: perfil ,permisos: [] };
    document.querySelectorAll("input[name='permisos[]']").forEach((checkbox) => {
            originalValues.permisos[checkbox.value] = checkbox.checked; 
        });
        
        $("#editarmodal").modal("show");
    });

    $("#guardarCambios").click(function() {
        let nuevoNombre = $("#nombrepfedit").val().trim();
        let permisosSeleccionados = [];
        
        document.querySelectorAll("input[name='permisos[]']:checked").forEach((checkbox) => {
            permisosSeleccionados.push(checkbox.value);
        });
        
        if (permisosSeleccionados.length === 0) {
            mensaje("Debe seleccionar al menos un permiso para el perfil");
            setTimeout(function() {
                var modal = bootstrap.Modal.getInstance(document.getElementById("infomodal"));
                modal.hide();
                }, 1000);
            return;
        }
        permisosSeleccionados = [];
        document.querySelectorAll("input[name='permisos[]']").forEach((checkbox) => {
            originalValues.permisos[checkbox.value] = checkbox.checked; // Guardamos el estado de cada checkbox
        });
        if(nuevoNombre === originalValues.perfil &&  arraysIguales(originalValues.permisos,permisosSeleccionados,0)){
        mensaje("No ha realizado cambios");
        setTimeout(function() {
            var modal = bootstrap.Modal.getInstance(document.getElementById("infomodal"));
            modal.hide();
            }, 1000);
        }

        if (nuevoNombre === "") {
            mensaje("El nombre del perfil no puede estar vacío.");
            setTimeout(function() {
                var modal = bootstrap.Modal.getInstance(document.getElementById("infomodal"));
                modal.hide();
                }, 1000);
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
                mensaje("Perfil Actualizado Correctamente!!!");
                setTimeout(function() {
                    var modal = bootstrap.Modal.getInstance(document.getElementById("infomodal"));
                    modal.hide();
                    location.reload();}, 1000);
                
            },
            error: function() {
                mensaje("Error en el envio de datos!!!");
                setTimeout(function() {
                    var modal = bootstrap.Modal.getInstance(document.getElementById("infomodal"));
                    modal.hide();}, 1000);
            }
        });
    });
        
});

function arraysIguales(arr1, arr2, i=0) {
    if (arr1.length === arr2.length){
         return false;
    }else if(arr1.length===i){
        return true;
    }if (arr1[i] !== arr2[i]){
        return false;
    }
    return arraysIguales(arr1, arr2, i++);
}


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
                mensaje("Perfil generado correctamente!!!");
                setTimeout(function() {
                    var modal = bootstrap.Modal.getInstance(document.getElementById("infomodal"));
                    modal.hide();
                    location.reload();}, 1000);
            },
            error: function() {
                mensaje("Error en el envio de datos!!!");
                setTimeout(function() {
                    var modal = bootstrap.Modal.getInstance(document.getElementById("infomodal"));
                    modal.hide();}, 1000);
            }
        });
    });

    botonIngreso.dataset.eventoAgregado = "true";
}


//ativa y desactiva perfil
$(document).ready(function() {
  $(document).on("click", ".toggle-estado", function() {
      let perfil = $(this).data("perfil");
      let estadoActual = $(this).data("estado");
      let nuevoEstado = estadoActual === "Activo" ? "Inactivo" : "Activo";
      $.ajax({
          url: '../server/cambiarestadoperfil.php',
          method: 'POST',
          data: {
              perfil: perfil,
              estado: nuevoEstado
          },
          success: function(response) {
            mensaje("El cambio de estado ha sido realizado!!!");
            setTimeout(function() {
                var modal = bootstrap.Modal.getInstance(document.getElementById("infomodal"));
                modal.hide();
                location.reload();}, 1000);
        },
        error: function() {
            mensaje("Error en el envio de datos!!!");
            setTimeout(function() {
                var modal = bootstrap.Modal.getInstance(document.getElementById("infomodal"));
                modal.hide();}, 1000);
        }
      });
  });
});

//ordenamiento
$(document).ready(function () {
    function ordenarTabla(indice, ascendente) {
        let filas = $("#tabla-body tr").get();
        filas.sort(function (a, b) {
            let valorA = $(a).children("td").eq(indice).text().trim().toLowerCase();
            let valorB = $(b).children("td").eq(indice).text().trim().toLowerCase();
            
            if ($.isNumeric(valorA) && $.isNumeric(valorB)) {
                valorA = parseFloat(valorA);
                valorB = parseFloat(valorB);
            }

            return ascendente ? (valorA > valorB ? 1 : -1) : (valorA < valorB ? 1 : -1);
        });

        $.each(filas, function (index, row) {
            $("#tabla-body").append(row);
        });
    }
    
    let estadosOrden = {
        perfil: true,
        estado: true
    };

    $("#filtroperf").click(function () {
        ordenarTabla(0, estadosOrden.perfil);
        estadosOrden.perfil = !estadosOrden.perfil;
    });


    $("#filtroest").click(function () {
        ordenarTabla(1, estadosOrden.estado);
        estadosOrden.estado = !estadosOrden.estado;
    });

    $("#filtroin").on("keyup", function () {
        let criterio = $("#filtrosel").val();
        let filtro = $(this).val().toLowerCase();
        $("#tabla-body tr").filter(function () {
            let textoFila = "";
            if (criterio === "perfil") {
                textoFila = $(this).children("td").eq(0).text().trim().toLowerCase();
            } else if (criterio === "estado") {
                textoFila = $(this).children("td").eq(1).text().trim().toLowerCase();
            }
            $(this).toggle(textoFila.includes(filtro));
        });
    });
    
});

function mensaje(msg) {
    document.getElementById("mensaje").innerHTML = msg;
    var modal = new bootstrap.Modal(document.getElementById("infomodal"));
    modal.show();
}
