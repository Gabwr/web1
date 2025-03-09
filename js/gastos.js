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
            mensaje("Gasto Actualizado Correctamente!!!");
			setTimeout(function() {
                var modal = bootstrap.Modal.getInstance(document.getElementById("infomodal"));
                modal.hide();
                location.reload();}, 1000);
        },
        error: function() {
            mensaje("Error al actualizar el Gasto.");
			setTimeout(function() {
                var modal = bootstrap.Modal.getInstance(document.getElementById("infomodal"));
                modal.hide();}, 1000);
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
			mensaje("Gasto Registrado Correctamente!!");
            setTimeout(function() {
                var modal = bootstrap.Modal.getInstance(document.getElementById("infomodal"));
                modal.hide();
                location.reload();}, 1000);
        },
        error: function() {
            mensaje("Error al registrar el Gasto.");
			setTimeout(function() {
                var modal = bootstrap.Modal.getInstance(document.getElementById("infomodal"));
                modal.hide();}, 1000);
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
                  mensaje("Gasto "+res+" exitosamente.");
				  setTimeout(function() {
                var modal = bootstrap.Modal.getInstance(document.getElementById("infomodal"));
                modal.hide();
                location.reload();}, 1000);
              } else {
                  mensaje("Error al "+accion+" el gasto");
				  setTimeout(function() {
                var modal = bootstrap.Modal.getInstance(document.getElementById("infomodal"));
                modal.hide();}, 1000);
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
        destinatario: true,
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

    $("#filtroDestinatario").click(function () {
        ordenarTabla(3, estadosOrden.destinatario);
        estadosOrden.destinatario = !estadosOrden.destinatario;
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
        let filtro = $(this).val().toLowerCase();
		
        $("#tabla-body tr").filter(function () {
            let fila = $(this);
            textoFila = fila.text().toLowerCase();
            fila.toggle(textoFila.includes(filtro));
        });
    });
});
//Funcion para mostrar u ocultar los gastos anulados
$(document).ready(function(){
	$("#tabla-body tr").each(function () {
		let estado=$(this).find("td:last").find("button:last").data("estado");
        if (estado === "Inactivo") {
            $(this).hide();
        }
    });
	
	$("#mostrarOcultar").change(function(){
		if(this.checked)
			{
				$("#msj_mO").text("Ocultar gastos anulados");
			}
		else
			{
				$("#msj_mO").text("Mostrar gastos anulados");
			}
		$("table tr").each(function () {
		let estado=$(this).find("td:last").find("button:last").data("estado");
        if (estado === "Inactivo") {
            $(this).toggle();
        }
		});
		let filtro=$("#filtrosel").val();
		if(filtro!="")
			{
				validarFtiempo();
			}
	});
	
	
	function validarfiltroM()
	{
		let mes=$("#filtroT").val();
		$("#tabla-body tr").filter(function () {
            let fila = $(this);
            textoFila = fila.text().toLowerCase();
            if(!textoFila.includes(mes))
				{
					$(this).hide();
				}
        });
	}
	function validarfiltroA()
	{
		let anio=$("#filtroT").val();
		$("#tabla-body tr").filter(function () {
            let fila = $(this);
            textoFila = fila.text().toLowerCase();
            if(!textoFila.includes(anio))
				{
					$(this).hide();
				}
        });
	}
	
});
//Control de los filtros
$(document).ready(function(){
	$("#filtroT").hide();
	
	function cambiarFiltro()
	{
		let opcion=$("#filtrosel").val();
		if(opcion=="")
			{
				$("#filtroT").hide();
			}
		else
			{
				//Elige el tipo de filtro
				if(opcion=="anio")
					{
						document.getElementById("filtroT").setAttribute("type","text");
					}
				else if(opcion=="mes")
					{
						document.getElementById("filtroT").setAttribute("type","month");
					}
				$("#filtroT").show();
			}
	}
	
	$("#filtrosel").change(cambiarFiltro);
	
	function validarOcultamiento()
	{
		let mostrarOcultos=$("#mostrarOcultar").prop("checked");
		if(mostrarOcultos==false)
			{
				$("#tabla-body tr").each(function () {
				let estado=$(this).find("td:last").find("button:last").data("estado");
        		if (estado === "Inactivo"){
            		$(this).hide();
        		}
    		});
			}
	}
	
	function filtrarporM()
	{
		let mes=$("#filtroT").val();
		$("#tabla-body tr").filter(function () {
            let fila = $(this);
            textoFila = fila.text().toLowerCase();
            fila.toggle(textoFila.includes(mes));
        });
	}
	function filtrarporA()
	{
		let anio=$("#filtroT").val();
		$("#tabla-body tr").filter(function () {
            let fila = $(this);
            textoFila = fila.text().toLowerCase();
            fila.toggle(textoFila.includes(anio));
        });
	}
	
	$("#filtroT").change(function(){
		let opc=$("#filtrosel").val();
		if(opc!="")
			{
				if(opc=="mes")
				{
				filtrarporM();
				validarOcultamiento();
				}
				else if(opc=="anio")
				{
					filtrarporA();
					validarOcultamiento();
				}
			}
		else
			{
				this.val("");
			}
	});
	
	
});

//Control de la alerta
function mensaje(msg) {
    document.getElementById("mensaje").innerHTML = msg;
    var modal = new bootstrap.Modal(document.getElementById("infomodal"));
    modal.show();
}
