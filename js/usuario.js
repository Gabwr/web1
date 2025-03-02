let botonAgregar = document.getElementById("usuariodialog");
botonAgregar.addEventListener("click", function () {
      var modal = new bootstrap.Modal(document.getElementById("miDialogo"));
      modal.show();
    });




document.getElementById("ingreso").addEventListener("click", function(event){
    let user = document.getElementById("usuario");
    if(user.value == ""){
      alert("El campo usuario no puede estar vacio");
      event.preventDefault();
    }
  });

