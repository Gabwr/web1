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

    $("#filtroFH").click(function () {
        ordenarTabla(1, estadosOrden.fecha_hora);
        estadosOrden.fecha_hora = !estadosOrden.fecha_hora;
    });

    $("#filtroUsuario").click(function () {
        ordenarTabla(2, estadosOrden.usuario);
        estadosOrden.usuario = !estadosOrden.usuario;
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