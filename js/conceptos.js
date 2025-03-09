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
restringir();
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


function restringir() {
    let perfil = sessionStorage.getItem("perfil"); 
  
    if (!perfil) {
        console.warn("No se encontró perfil en sessionStorage");
        return;
    }
  
    perfil = JSON.parse(perfil);

    if (perfil.insercion_conceptos == 1) {
        document.getElementById("agconcepto").style.display = "block";
    }
      if (perfil.lectura_conceptos == 1 ) {
        document.getElementById("tabla").style.display = "block";
        if(perfil.edicion_conceptos == 1 ) {
            let edicion = document.getElementsByClassName("btnEditar");
            for (let i = 0; i < edicion.length; i++) {
                edicion[i].style.display = "inline-block";
            }
          }
      }
      
      

      
}  