$(document).ready(function() {
  let originalValues = {};

  $(document).on("click", ".editar-usuario", function() {
      let id = $(this).data("id");
      let nombre = $(this).data("nombre");
      let apellido = $(this).data("apellido");
      let usuario = $(this).data("usuario");
      let perfil = $(this).data("perfil");

      originalValues = {
        id: id,
        nombre: nombre,
        apellido: apellido,
        usuario: usuario,
        perfil: perfil
      };

      $("#edit-idUsuario").val(id);
      $("#edit-nombre").val(nombre);
      $("#edit-apellido").val(apellido);
      $("#edit-usuario").val(usuario);
      $("#edit-perfil").val(perfil);

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
        mensaje("No ha realizado cambios");
        setTimeout(function() {
            var modal = bootstrap.Modal.getInstance(document.getElementById("infomodal"));
            modal.hide();
            }, 1000);
        return;  
    }
    let soloLetras = /^[A-Za-zÁÉÍÓÚáéíóúñÑ\s]+$/;
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


//creador de usuario

    $(document).on("keyup", "#apellido #nombre", function() {
        let userio = "";
        let nombro = document.getElementById("nombre").value.trim();
        let apllio = document.getElementById("apellido").value.trim();
        if(nombro !== "") {
        userio = nombro[0] + apllio;
        document.getElementById("usuario").value = userio;
        }else{
            document.getElementById("usuario").value = "";
        }
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
        nombre: true,
        perfil: true,
        conexion: true,
        estado: true
    };

    $("#filtronom").click(function () {
        ordenarTabla(1, estadosOrden.nombre);
        estadosOrden.nombre = !estadosOrden.nombre;
    });

    $("#filtroperf").click(function () {
        ordenarTabla(2, estadosOrden.perfil);
        estadosOrden.perfil = !estadosOrden.perfil;
    });

    $("#filtrocon").click(function () {
        ordenarTabla(3, estadosOrden.conexion);
        estadosOrden.conexion = !estadosOrden.conexion;
    });

    $("#filtroest").click(function () {
        ordenarTabla(4, estadosOrden.estado);
        estadosOrden.estado = !estadosOrden.estado;
    });

    $("#filtroin").on("keyup", function () {
        let criterio = $("#filtrosel").val();
        let filtro = $(this).val().toLowerCase();

        $("#tabla-body tr").filter(function () {
            let textoFila = "";
            if (criterio === "perfil") {
                textoFila = $(this).children("td").eq(2).text().toLowerCase();
            } else if (criterio === "nombre") {
                textoFila = $(this).children("td").eq(1).text().toLowerCase();
            } else if (criterio === "tiempo") {
                textoFila = $(this).children("td").eq(3).text().toLowerCase();
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