function usuarios() {

    botonAgregar.addEventListener("click", function () {
      var modal = new bootstrap.Modal(document.getElementById("miDialogo"));
      modal.show();
    });
}

let user = document.getElementById("usuario");

document.getElementById("ingreso").addEventListener("click", function(event){
    if(user.value == ""){
      alert("El campo usuario no puede estar vacio");
      event.preventDefault();
    }
  });

