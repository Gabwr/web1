// JavaScript Document
$(document).ready(function() {
  let originalValues = {};

  $(document).on("click", ".editar-gasto", function() {
      let id = $(this).data("id");
      let fecha = $(this).data("fecha");
      let concepto = $(this).data("concepto");
      let destinatario = $(this).data("acreedor_cobrador");
      let medio = $(this).data("medio_de_pago");
	  let valor = $(this).data("valor");
	  let descripcion = $(this).data("descripcion");

      // Guardamos los valores originales para compararlos luego
      originalValues = {
          id: id,
          fecha: fecha,
		  concepto: concepto,
		  destinatario: destinatario,
		  medio: medio,
		  valor: valor,
		  descripcion: descripcion
      };

      // Asignamos los valores a los campos del formulario
      $("#edit-concepto").val(concepto);
      $("#edit-destinatario").val(destinatario);
      $("#edit-metodo").val(medio);
      $("#edit-valor").val(valor);
      $("#edit-descripcion").val(descripcion);

      // Mostramos el modal de edición
      $("#editarmodal").modal("show");
  });

  $("#guardarCambios").click(function() {
	let id=originalValues.id;
    let concepto = $("#edit-concepto").val();
    let destinatario = $("#edit-destinatario").val().trim();
    let medio = $("#edit-metodo").val();
    let valor = $("#edit-valor").val();
	let descripcion = $("#edit-descripcion").val();

    if (concepto === originalValues.concepto && destinatario === originalValues.destinatario && medio === originalValues.medio && valor === originalValues.valor && descripcion === originalValues.descripcion) {
        alert("No se han realizado cambios.");
        return;  
    }
	  
	 //Validaciones pendientes 
	

    let formato = /^[A-Za-z0-9ÁÉÍÓÚáéíóúñÑ\s\.]+$/;
if (concepto === "" || destinatario === "" || medio === "" || valor === 0 || descripcion === "") {
        alert("Todos los campos son obligatorios");
        return;
    }
    if (!formato.test(destinatario)) {
        alert("Ingrese solo letras, números y espacios");
        return;
    }
	   if (valor<1) {
        alert("El valor del ingreso debe ser mayor a $1.00");
        return;
    }

    $.ajax({
        url: '../server/actualizarGasto.php',
        method: 'POST',
        data: {
           id: id,
		  concepto: concepto,
		  destinatario: destinatario,
		  medio: medio,
		  valor: valor,
		  descripcion: descripcion
        },
        success: function(response) {
            alert("Gasto Actualizado Correctamente!!!");
            location.reload();
        },
        error: function() {
            alert("Error al actualizar el Gasto.");
        }
    });
  });
});

//ingreso de usuario
var botonAgregar = document.getElementById("gastos_dialog");
if (botonAgregar && !botonAgregar.dataset.eventoAgregado) {
    botonAgregar.addEventListener("click", function () {
        var modal = new bootstrap.Modal(document.getElementById("ventana_Reg_Gasto"));
        modal.show();
        document.getElementById("concepto").selectedIndex=0;
    	document.getElementById("destinatario").value="";
    	document.getElementById("metodo").value="";
    	document.getElementById("valor").value=0;
		document.getElementById("descripcion").value="";
    });
    botonAgregar.dataset.eventoAgregado = "true";
}

var botonReg = document.getElementById("registrar");
if (botonReg && !botonReg.dataset.eventoAgregado) {
  botonReg.addEventListener("click", function(event) {
    event.preventDefault(); 

    let concepto = document.getElementById("concepto").value;
    let dest = document.getElementById("destinatario").value;
    let medio = document.getElementById("metodo").value;
    let valor =document.getElementById("valor").value;
	let descripcion = document.getElementById("descripcion").value;

    let formato = /^[A-Za-z0-9ÁÉÍÓÚáéíóúñÑ\s\.]+$/;

    if (concepto === "" || dest === "" || medio === "" || valor === 0 || descripcion === "") {
        alert("Todos los campos son obligatorios");
        return;
    }
    if (!formato.test(dest)) {
        alert("Ingrese solo letras, números y espacios");
        return;
    }
	  if (valor<1) {
        alert("El valor del gasto debe ser mayor a $1.00");
        return;
    }

    $.ajax({
        url: '../server/registrar_Gasto.php',
        method: 'POST',
        data: {
		  concepto: concepto,
		  destinatario: dest,
		  medio: medio,
		  valor: valor,
		  descripcion: descripcion
        },
        success: function(response) {
            alert("Gasto Registrado Correctamente!!"); 
            location.reload();
        },
        error: function() {
            alert("Error al registrar el Gasto.");
        }
    });
});

    botonReg.dataset.eventoAgregado = "true";
}

//Anula(Elimina) yoReactiva un gasto
$(document).ready(function() {
  $(document).on("click", ".cambiar-estado", function() {
      let idGasto = $(this).data("id");
      let estadoActual = $(this).data("estado");
      let nuevoEstado = estadoActual === "Activo" ? "Inactivo" : "Activo";
	  let accion= nuevoEstado === "Activo"? "reactivar":"eliminar";
	  let res= nuevoEstado === "Activo"? "reactivado":"eliminado";
      $.ajax({
          url: '../server/anularGasto.php',
          method: 'POST',
          data: {
              id: idGasto,
              estado: nuevoEstado
          },
          success: function(response) {
              if (response === "success") {
                  alert("Gasto"+res+"exitosamente.");
                  location.reload();
              } else {
                  alert("Error al"+accion+" el gasto.");
              }
          },
          error: function() {
              alert("Error en la solicitud AJAX.");
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
		fecha: true,
        concepto: true,
        fuente: true,
        medio: true,
        valor: true
    };

    $("#filtroFecha").click(function () {
        ordenarTabla(1, estadosOrden.fecha);
        estadosOrden.fecha = !estadosOrden.fecha;
    });

    $("#filtroConcepto").click(function () {
        ordenarTabla(2, estadosOrden.concepto);
        estadosOrden.concepto = !estadosOrden.concepto;
    });

    $("#filtroFuente").click(function () {
        ordenarTabla(3, estadosOrden.fuente);
        estadosOrden.fuente = !estadosOrden.fuente;
    });

    $("#filtroMedio").click(function () {
        ordenarTabla(4, estadosOrden.medio);
        estadosOrden.medio = !estadosOrden.medio;
    });
	$("#filtroValor").click(function () {
        ordenarTabla(4, estadosOrden.valor);
        estadosOrden.valor = !estadosOrden.valor;
    });

    $("#filtroin").on("keyup", function () {
        let criterio = $("#filtrosel").val();
        let filtro = $(this).val().toLowerCase();

        $("#tabla-body tr").filter(function () {
            let textoFila = "";
            if (criterio === "concepto") {
                textoFila = $(this).children("td").eq(1).text().toLowerCase();
            } else if (criterio === "fuente") {
                textoFila = $(this).children("td").eq(2).text().toLowerCase();
            } else if (criterio === "medio") {
                textoFila = $(this).children("td").eq(3).text().toLowerCase();
            }

            $(this).toggle(textoFila.includes(filtro));
        });
    });
});
// JavaScri