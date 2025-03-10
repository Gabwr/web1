$(document).on("click", ".btnEditar", function () {
    let id = $(this).data("id");
    let url = $(this).data("url");
    let descripcion = $(this).data("descripcion");

    $("#edit_qr_id").val(id);
    $("#edit_qr_url").val(url);
    $("#edit_descripcion").val(descripcion); 

    $("#modalEditarQR").modal("show");
});

$("#formAgregarQR").submit(function (e) {
    e.preventDefault();
    $.ajax({
        url: "../server/guardar_qr.php",
        type: "POST",
        data: $(this).serialize(),
        success: function (response) {
            alert("QR agregado correctamente.");
            location.reload();
        },
        error: function () {
            alert("Error al agregar QR.");
        }
    });
});

$("#formEditarQR").submit(function (e) {
    e.preventDefault();
    $.ajax({
        url: "../server/editar_qr.php",
        type: "POST",
        data: $(this).serialize(),
        success: function (response) {
            alert("QR actualizado correctamente.");
            location.reload();
        },
        error: function () {
            alert("Error al actualizar QR.");
        }
    });
});