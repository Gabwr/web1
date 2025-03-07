$(document).ready(function() {
  let originalValues = {};

  $(document).on("click", ".editar-usuario", function() {
      let id = $(this).data("id");
      let nombre = $(this).data("nombre");
      let apellido = $(this).data("apellido");
      let usuario = $(this).data("usuario");
      let perfil = $(this).data("perfil");
      let ced = $(this).data("cedula");

      originalValues = {
        id: id,
        nombre: nombre,
        apellido: apellido,
        usuario: usuario,
        perfil: perfil,
        cedula: ced
      };

      $("#edit-idUsuario").val(id);
      $("#edit-nombre").val(nombre);
      $("#edit-apellido").val(apellido);
      $("#edit-usuario").val(usuario);
      $("#edit-perfil").val(perfil);
      $("#edit-cedula").val(ced);
      $("#editarmodal").modal("show");
  });

  $("#guardarCambios").click(function() {
    let id = $("#edit-idUsuario").val();
    let user = $("#edit-usuario").val();
    let nomb = $("#edit-nombre").val().trim();
    let apll = $("#edit-apellido").val().trim();
    let perfil = $("#edit-perfil").val();
    let ced = $("#edit-cedula").val().trim();

    if (user === originalValues.usuario && nomb === originalValues.nombre && apll === 
      originalValues.apellido && perfil === originalValues.perfil && ced === originalValues.cedula) {
        mensaje("No ha realizado cambios");
        setTimeout(function() {
            var modal = bootstrap.Modal.getInstance(document.getElementById("infomodal"));
            modal.hide();
            }, 1000);
        return;  
    }
    let soloLetras = /^[A-Za-zÁÉÍÓÚáéíóúñÑ]+$/;
    if (user === "" || nomb === "" || apll === "" || perfil === "seleccione") {
        mensaje("Todos los campos son obligatorios");
        setTimeout(function() {
            var modal = bootstrap.Modal.getInstance(document.getElementById("infomodal"));
            modal.hide();
            }, 1000);
        return;
    }
    if (!soloLetras.test(nomb)) {
        mensaje("El Nombre solo debe contener letras y espacios");
        setTimeout(function() {
            var modal = bootstrap.Modal.getInstance(document.getElementById("infomodal"));
            modal.hide();
            }, 1000);
        return;
    }
    if (!soloLetras.test(apll)) {
        mensaje("El Apellido solo debe contener letras y espacios");
        setTimeout(function() {
            var modal = bootstrap.Modal.getInstance(document.getElementById("infomodal"));
            modal.hide();
            }, 1000);
        return;
    }

    if (ced.length != 10) {
        mensaje("La cedula debe tener 10 digitos");
        setTimeout(function() {
            var modal = bootstrap.Modal.getInstance(document.getElementById("infomodal"));
            modal.hide();
            }, 1000);
        return;
    }
    if (isNaN(ced)) {
        mensaje("La cedula debe ser numerica");
        setTimeout(function() {
            var modal = bootstrap.Modal.getInstance(document.getElementById("infomodal"));
            modal.hide();
            }, 1000);
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
            perfil: perfil,
            cedula:ced
        },
        success: function(response) {
            mensaje("Usuario Actualizado Correctamente!!!");
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

//ingreso de usuario
var botonAgregar = document.getElementById("usuariodialog");
if (botonAgregar && !botonAgregar.dataset.eventoAgregado) {
    botonAgregar.addEventListener("click", function () {
        var modal = new bootstrap.Modal(document.getElementById("miDialogo"));
        modal.show();
         document.getElementById("usuario").value = "";
        document.getElementById("nombre").value = "";
        document.getElementById("apellido").value = "";
        document.getElementById("cedula").value = "";
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
    let ced = document.getElementById("cedula").value.trim();
    let pass = user+nomb+apll;
    let perfil = document.getElementById("perfil").value;

    let soloLetras = /^[A-Za-zÁÉÍÓÚáéíóúñÑ]+$/;

    if (user === "" || pass === "" || nomb === "" || apll === "" || ced === "" ||perfil === "seleccione") {
        mensaje("Todos los campos son obligatorios");
        setTimeout(function() {
            var modal = bootstrap.Modal.getInstance(document.getElementById("infomodal"));
            modal.hide();
            }, 1000);
        return;
    }
    if (!soloLetras.test(nomb)) {
        mensaje("El Nombre solo debe contener letras y espacios");
        setTimeout(function() {
            var modal = bootstrap.Modal.getInstance(document.getElementById("infomodal"));
            modal.hide();
            }, 1000);
        return;
    }
    if (!soloLetras.test(apll)) {
        mensaje("El Apellido solo debe contener letras y espacios");
        setTimeout(function() {
            var modal = bootstrap.Modal.getInstance(document.getElementById("infomodal"));
            modal.hide();
            }, 1000);
        return;
    }

    if (ced.length != 10) {
        mensaje("La cedula debe tener 10 digitos");
        setTimeout(function() {
            var modal = bootstrap.Modal.getInstance(document.getElementById("infomodal"));
            modal.hide();
            }, 1000);
        return;
    }
    if (isNaN(ced)) {
        mensaje("La cedula debe ser numerica");
        setTimeout(function() {
            var modal = bootstrap.Modal.getInstance(document.getElementById("infomodal"));
            modal.hide();
            }, 1000);
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
            perfil: perfil,
            cedula:ced
        },
        success: function(response) {
            mensaje("Usuario ingresado correctamente!!!");
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
        cedula: true,
        nombre: true,
        perfil: true,
        conexion: true,
        estado: true
    };

    $("#filtronom").click(function () {
        ordenarTabla(1, estadosOrden.cedula);
        estadosOrden.cedula = !estadosOrden.cedula;
    });

    $("#filtronom").click(function () {
        ordenarTabla(2, estadosOrden.nombre);
        estadosOrden.nombre = !estadosOrden.nombre;
    });

    $("#filtroperf").click(function () {
        ordenarTabla(3, estadosOrden.perfil);
        estadosOrden.perfil = !estadosOrden.perfil;
    });

    $("#filtrocon").click(function () {
        ordenarTabla(4, estadosOrden.conexion);
        estadosOrden.conexion = !estadosOrden.conexion;
    });

    $("#filtroest").click(function () {
        ordenarTabla(5, estadosOrden.estado);
        estadosOrden.estado = !estadosOrden.estado;
    });

    $("#filtroin").on("keyup", function () {
        let filtro = $(this).val().toLowerCase();

        $("#tabla-body tr").filter(function () {
            let fila = $(this);
            textoFila = fila.text().toLowerCase();
            fila.toggle(textoFila.includes(filtro));
        });
    });
});


function mensaje(msg) {
    document.getElementById("mensaje").innerHTML = msg;
    var modal = new bootstrap.Modal(document.getElementById("infomodal"));
    modal.show();
}