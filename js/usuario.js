document.addEventListener("DOMContentLoaded", function() {
  document.getElementById("Agregar").addEventListener("click", function() {
      var modal = new bootstrap.Modal(document.getElementById('miDialogo'));
      modal.show();
  });
});