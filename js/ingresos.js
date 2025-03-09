$(document).ready(function() {
  let originalValues = {};

  $(document).on("click", ".editar-ingreso", function() {
      let id = $(this).data("id");
      let fecha = $(this).data("fecha");
      let concepto = $(this).data("concepto");
      let fuente = $(this).data("fuente_beneficiario");
      let medio = $(this).data("medio_de_pago");
	  let valor = $(this).data("valor");
	  let descripcion = $(this).data("descripcion");

      // Guardamos los valores originales para compararlos luego
      originalValues = {
          id: id,
          fecha: fecha,
		  concepto: concepto,
		  fuente: fuente,
		  medio: medio,
		  valor: valor,
		  descripcion: descripcion
      };

      // Asignamos los valores a los campos del formulario
      $("#edit-concepto").val(concepto);
      $("#edit-fuente").val(fuente);
      $("#edit-metodo").val(medio);
      $("#edit-valor").val(valor);
      $("#edit-descripcion").val(descripcion);

      // Mostramos el modal de edición
      $("#editarmodal").modal("show");
  });

  $("#guardarCambios").click(function() {
	let id=originalValues.id;
    let concepto = $("#edit-concepto").val();
    let fuente = $("#edit-fuente").val().trim();
    let medio = $("#edit-metodo").val();
    let valor = $("#edit-valor").val();
	let descripcion = $("#edit-descripcion").val();

    if (concepto === originalValues.concepto && fuente === originalValues.fuente && medio === 
      originalValues.medio && valor === originalValues.valor && descripcion === originalValues.descripcion) {
        alert("No se han realizado cambios.");
        return;  
    }
	  
	 //Validaciones pendientes 
	

    let formato = /^[A-Za-z0-9ÁÉÍÓÚáéíóúñÑ\s\.]+$/;
if (concepto === "" || fuente === "" || medio === "" || valor === 0 || descripcion === "") {
        alert("Todos los campos son obligatorios");
        return;
    }
    if (!formato.test(fuente)) {
        alert("Ingrese solo letras, números y espacios");
        return;
    }
	   if (valor<1) {
        alert("El valor del ingreso debe ser mayor a $1.00");
        return;
    }

    $.ajax({
        url: '../server/actualizar_Ingreso.php',
        method: 'POST',
        data: {
           id: id,
		  concepto: concepto,
		  fuente: fuente,
		  medio: medio,
		  valor: valor,
		  descripcion: descripcion
        },
        success: function(response) {
            mensaje("Ingreso Actualizado Correctamente!!!");
            setTimeout(function() {
                var modal = bootstrap.Modal.getInstance(document.getElementById("infomodal"));
                modal.hide();
                location.reload();}, 1000);
        },
        error: function() {
            mensaje("Error al actualizar el ingreso.");
			setTimeout(function() {
                var modal = bootstrap.Modal.getInstance(document.getElementById("infomodal"));
                modal.hide();}, 1000);
        }
    });
  });
});

//ingreso de usuario
var botonAgregar = document.getElementById("ingresos_dialog");
if (botonAgregar && !botonAgregar.dataset.eventoAgregado) {
    botonAgregar.addEventListener("click", function () {
        var modal = new bootstrap.Modal(document.getElementById("ventana_Reg_Ingreso"));
        modal.show();
        document.getElementById("concepto").selectedIndex=0;
    	document.getElementById("fuente").value="";
    	document.getElementById("metodo").value="";
    	document.getElementById("valor").value=0;
		document.getElementById("descripcion").value="";
    });
    botonAgregar.dataset.eventoAgregado = "true";
}

var botonIngreso = document.getElementById("ingreso");
if (botonIngreso && !botonIngreso.dataset.eventoAgregado) {
  document.getElementById("ingreso").addEventListener("click", function(event) {
    event.preventDefault(); 

    let fecha = new Date();
    let concepto = document.getElementById("concepto").value;
    let fuente = document.getElementById("fuente").value;
    let medio = document.getElementById("metodo").value;
    let valor =document.getElementById("valor").value;
	let descripcion = document.getElementById("descripcion").value;

    let formato = /^[A-Za-z0-9ÁÉÍÓÚáéíóúñÑ\s\.]+$/;

    if (concepto === "" || fuente === "" || medio === "" || valor === 0 || descripcion === "") {
        alert("Todos los campos son obligatorios");
        return;
    }
    if (!formato.test(fuente)) {
        alert("Ingrese solo letras, números y espacios");
        return;
    }
	  if (valor<1) {
        alert("El valor del ingreso debe ser mayor a $1.00");
        return;
    }

    $.ajax({
        url: '../server/registrar_Ingreso.php',
        method: 'POST',
        data: {
            fecha: fecha,
		  concepto: concepto,
		  fuente: fuente,
		  medio: medio,
		  valor: valor,
		  descripcion: descripcion
        },
        success: function(response) {
            mensaje("Ingreso Registrado Correctamente!!"); 
            setTimeout(function() {
                var modal = bootstrap.Modal.getInstance(document.getElementById("infomodal"));
                modal.hide();
                location.reload();}, 1000);
        },
        error: function() {
            mensaje("Error al registrar el ingreso.");
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
  $(document).on("click", ".cambiar-estado", function() {
      let idIngreso = $(this).data("id");
      let estadoActual = $(this).data("estado");
      let nuevoEstado = estadoActual === "Activo" ? "Inactivo" : "Activo";
	  let accion= nuevoEstado === "Activo"? "reactivar":"eliminar";
	  let res= nuevoEstado === "Activo"? "reactivado":"eliminado";
      $.ajax({
          url: '../server/eliminarIngreso.php',
          method: 'POST',
          data: {
              id: idIngreso,
              estado: nuevoEstado
          },
          success: function(response) {
              if (response === "success") {
                  mensaje("Ingreso "+res+" exitosamente.");
				  setTimeout(function() {
                var modal = bootstrap.Modal.getInstance(document.getElementById("infomodal"));
                modal.hide();
                location.reload();}, 1000);
              } else {
                  mensaje("Error al "+accion+" el ingreso");
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
        let filtro = $(this).val().toLowerCase();

        $("#tabla-body tr").filter(function () {
            let fila = $(this);
            textoFila = fila.text().toLowerCase();
            fila.toggle(textoFila.includes(filtro));
        });
    });
});
//Mostrar u ocultar ingresos anulados
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
				$("#msj_mO").text("Ocultar Ingresos anulados");
			}
		else
			{
				$("#msj_mO").text("Mostrar Ingresos anulados");
			}
		$("table tr").each(function () {
		let estado=$(this).find("td:last").find("button:last").data("estado");
        if (estado === "Inactivo") {
            $(this).toggle();
        }
		});
	});
});

//Control de la alerta
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
    if (perfil.lectura_ingresos == true && perfil.Insercion_ingresos == true && perfil.edicion_ingresos == true) {
        document.getElementById("ingperf").style.display = "block";
        comp++;
    }

    if (perfil.lectura_gastos == true && perfil.insercion_gastos == true && perfil.edicion_gastos == true) {
        document.getElementById("gastperf").style.display = "block";
        comp++;
    }
  
    if (perfil.lectura_usuarios == true && perfil.insercion_usuarios == true && perfil.edicion_usuarios == true) {
      document.getElementById("userperf").style.display = "block";
      comp++;
      compu++;
    }
  
    if (perfil.lectura_perfiles == true && perfil.insercion_perfiles == true && perfil.edicion_perfiles == true) {
      document.getElementById("perfperf").style.display = "block";
      comp++;
      compu++;
    }
    if(compu===2 ){
      document.getElementById("desplegableus").style.display= "block";
    }

    if (perfil.lectura_conceptos == true && perfil.insercion_conceptos == true && perfil.edicion_conceptos == true) {
      document.getElementById("cncpperf").style.display = "block";
      comp++;
      compsis++;
    }
  
    if (perfil.permiso_qr == true ) {
      document.getElementById("qrperf").style.display = "block";
      comp++;
      compsis++;
    }
    if(compu===2 ){
      document.getElementById("desplegablesis").style.display= "block";
    }
    if(comp===6 ){
      document.getElementById("auditoria").style.display= "block";
    }
  }

