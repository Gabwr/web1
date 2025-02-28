document.addEventListener("DOMContentLoaded", function() {
  document.querySelector("button[onclick='mostrarDialogo()']").addEventListener("click", function() {
      var modal = new bootstrap.Modal(document.getElementById('miDialogo'));
      modal.show();
  });
});