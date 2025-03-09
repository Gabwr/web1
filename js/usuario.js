$(document).ready(function() {
  let originalValues = {};
  restringir();
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

  $("#guardarCambios").click(function () {
    let id = $("#edit-idUsuario").val();
    let user = $("#edit-usuario").val();
    let nomb = $("#edit-nombre").val().trim();
    let apll = $("#edit-apellido").val().trim();
    let perfil = $("#edit-perfil").val();
    let ced = $("#edit-cedula").val().trim();
    if (user === originalValues.usuario && nomb === originalValues.nombre && apll === 
      originalValues.apellido && perfil === originalValues.perfil && ced === originalValues.cedula) {
        mensaje("No ha realizado cambios");
        timeout();
        return;  
    }
    norep(user, ced,id,"edit", function(repetido) {
        if (repetido) {
            return; 
        }
    
    let soloLetras = /^[A-Za-zÁÉÍÓÚáéíóúñÑ]+$/;
    if (user === "" || nomb === "" || apll === "" || perfil === "seleccione") {
        mensaje("Todos los campos son obligatorios");
        timeout();
        return;
    }
    if (!soloLetras.test(nomb)) {
        mensaje("El Nombre solo debe contener letras y espacios");
        timeout();
        return;
    }
    if (!soloLetras.test(apll)) {
        mensaje("El Apellido solo debe contener letras y espacios");
        timeout();
        return;
    }

    if (ced.length != 10) {
        mensaje("La cedula debe tener 10 digitos");
        timeout();
        return;
    }
    if (isNaN(ced)) {
        mensaje("La cedula debe ser numerica");
        timeout();
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
            timeoutres();
            
        },
        error: function() {
            mensaje("Error en el envio de datos!!!");
            timeout();
        }
    });
    });
    });
});


//ingreso de usuario
var botonAgregar = document.getElementById("usuariodialog");
if (botonAgregar && !botonAgregar.dataset.eventoAgregado) {
    botonAgregar.addEventListener("click", function () {
        var modal = new bootstrap.Modal(document.getElementById("miDialogo"));
        modal.show();
        document.getElementById("userio").value = "";
        document.getElementById("nombre").value = "";
        document.getElementById("apellido").value = "";
        document.getElementById("cedula").value = "";
        document.getElementById("perfil").selectedIndex = 0;
    });
    botonAgregar.dataset.eventoAgregado = "true";
}

var botonIngreso = document.getElementById("ingreso");
if (botonIngreso && !botonIngreso.dataset.eventoAgregado) {
  $("#ingreso").click(function () {

    let userio = document.getElementById("userio").value.trim();
    let nomb = document.getElementById("nombre").value.trim();
    let apll = document.getElementById("apellido").value.trim();
    let ced = document.getElementById("cedula").value.trim();
    let pass = userio+nomb+apll;
    let perfil = document.getElementById("perfil").value;
    let soloLetras = /^[A-Za-zÁÉÍÓÚáéíóúñÑ]+$/;

    if (userio === "" || pass === "" || nomb === "" || apll === "" || ced === "" ||perfil === "seleccione") {
        mensaje("Todos los campos son obligatorios");
        timeout();
        return;
    }
    norep(userio, ced,id,"new", function(repetido) {
        if (repetido) {
            return; 
        }
    
    
    if (!soloLetras.test(nomb)) {
        mensaje("El Nombre solo debe contener letras y espacios");
        timeout();
        return;
    }
    if (!soloLetras.test(apll)) {
        mensaje("El Apellido solo debe contener letras y espacios");
        timeout();
        return;
    }

    if (ced.length != 10) {
        mensaje("La cedula debe tener 10 digitos");
        timeout();
        return;
    }
    if (isNaN(ced)) {
        mensaje("La cedula debe ser numerica");
        timeout();
        return;
    }

    $.ajax({
        url: '../server/insercionuser.php',
        method: 'POST',
        data: {
            usuario: userio,
            contrasenia: pass,
            nombre: nomb,
            apellido: apll,
            perfil: perfil,
            cedula:ced
        },
        success: function(response) {
            mensaje("Usuario ingresado correctamente!!!");
            timeout();
        },
        error: function() {
            mensaje("Error en el envio de datos!!!");
            timeout();
        }
    });
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
            timeoutres();
        },
        error: function() {
            mensaje("Error en el envio de datos!!!");
            timeout();
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


function restringir() {
    let perfil = sessionStorage.getItem("perfil"); 
  
    if (!perfil) {
        console.warn("No se encontró perfil en sessionStorage");
        return;
    }
  
    perfil = JSON.parse(perfil);

    if (perfil.insercion_usuarios == 1) {
        document.getElementById("usuariodialog").style.display = "block";
    }
      if (perfil.lectura_usuarios == 1 ) {
        document.getElementById("tablausuarios").style.display = "block";
        document.getElementById("lebusqueda").style.display ="flex";
        if(perfil.edicion_usuarios == 1 ) {
        let estados = document.getElementsByClassName("estate");
        let edicion = document.getElementsByClassName("editar-usuario");
        for (let i = 0; i < edicion.length; i++) {
            edicion[i].style.display = "inline-block";
        }

        for (let i = 0; i < estados.length; i++) {
            estados[i].style.display = "inline-block";
            }
      }
        
      }
}  


function timeout(){
    setTimeout(function() {
        var modal = bootstrap.Modal.getInstance(document.getElementById("infomodal"));
        modal.hide();
        }, 1000);
}

function timeoutres(){
    setTimeout(function() {
        var modal = bootstrap.Modal.getInstance(document.getElementById("infomodal"));
        modal.hide();
        location.reload();
        }, 1000);
}


function norep(user,ced,id ,es, callback) {

    let usuario =user;
    let cedula = ced;
    let idu =id;
    console.log(usuario,cedula,es);
    $.ajax({
        url: "../server/norepuser_cedula.php", 
        method: "POST",
        data: { user: usuario, 
                cedula: cedula,
                es: es,
                id:idu},
        success: function(response) {
            response = response.trim();
            let repetido = false;
            console.log(response)
            if (response == "Usuario repetido") {
                mensaje("El usuario ya está registrado.");
                timeout();
                console.log("1");
                repetido = true;
            } else if (response == "Cedula repetida") {
                mensaje("La cédula ya está registrada.");
                timeout();
                repetido = true;
                console.log("2");
            } else if (response == "No hay repeticion") {
                console.log("3");
                repetido = false;
            } else {
                console.log("4");
                repetido = false;
            }
            callback(repetido); 
        },
        error: function() {
            console.log("5");
            mensaje("Error al realizar la solicitud");
            timeout();
            callback(false); 
        }
    });
}
