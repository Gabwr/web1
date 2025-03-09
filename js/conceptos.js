$(document).on("click", ".btnEditar", function () {
    let id = $(this).data("id");
    let nombre = $(this).data("nombre");
    let tipo = $(this).data("tipo");
    let qr_id = $(this).data("qr");

    $("#edit_idconcepto").val(id);
    $("#edit_nombre").val(nombre);
    $("#edit_tipo").val(tipo);
    $("#edit_qr_id").val(qr_id);

    $("#modalEditarConcepto").modal("show");
});

$("#formAgregarConcepto").submit(function (e) {
    e.preventDefault();
    $.ajax({
        url: "../server/guardarconcepto.php",
        type: "POST",
        data: $(this).serialize(),
        success: function (response) {
            alert("Concepto agregado correctamente.");
            location.reload();
        },
        error: function () {
            alert("Error al agregar concepto.");
        }
    });
});

$("#formEditarConcepto").submit(function (e) {
    e.preventDefault();
    $.ajax({
        url: "../server/editarConcepto.php",
        type: "POST",
        data: $(this).serialize(),
        success: function (response) {
            alert("Concepto actualizado correctamente.");
            location.reload();
        },
        error: function () {
            alert("Error al actualizar concepto.");
        }
    });
});