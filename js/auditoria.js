// Filtros
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
		fecha_hora: true,
        usuario: true,
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