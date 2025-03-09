document.addEventListener("DOMContentLoaded" , function () {
    cargarPagina("inicio.php");
    let user="";
    let estate="";
    if(sessionStorage.getItem("usuario")==null){
      user=document.getElementById("usuario").innerHTML;
      sessionStorage.setItem("usuario",user);
    }else{
      user = sessionStorage.getItem("usuario");
    }
    if(sessionStorage.getItem("estado")==null){
      estate = document.getElementById("lestate").innerHTML;
      sessionStorage.setItem("estado",estate);
    }
    $.ajax({
      url: "../server/getpermisosperfil.php",
      method: "POST",
      data: { usuario: user},
      success: function (response) {
          try {
              sessionStorage.setItem("perfil", response); 
              setTimeout(restringir, 50);
          } catch (e) {
              console.log("Error al procesar los permisos");
          }
      },
      error: function () {
          alert("Error al obtener permisos desde el servidor");
      }
  });
  
function restringir() {
    let perfil = sessionStorage.getItem("perfil"); 
    let leestate = sessionStorage.getItem("estado")
  
    if (!leestate) {
      console.warn("No se encontró usuario en sessionStorage");
      return;
    }
      //usuario inactivo
    if(leestate=="Inactivo"){
      sessionStorage.clear();
      window.location.href = "inactivo.php";
    }
  
    if (!perfil) {
        console.warn("No se encontró perfil en sessionStorage");
        return;
    }
  
    perfil = JSON.parse(perfil);
    let comp =0;
    let compu =0;
    let compsis =0;
console.log(perfil.lectura_ingresos,perfil.edicion_ingresos,perfil.Insercion_ingresos)
    if (perfil.lectura_ingresos == true || perfil.Insercion_ingresos == true || perfil.edicion_ingresos == true) {
        document.getElementById("ingperf").style.display = "block";
        comp++;
    }

    if (perfil.lectura_gastos  || perfil.insercion_gastos  || perfil.edicion_gastos ) {
        document.getElementById("gastperf").style.display = "block";
        comp++;
    }
  
    if (perfil.lectura_usuarios || perfil.insercion_usuarios || perfil.edicion_usuarios) {
      document.getElementById("userperf").style.display = "block";
      comp++;
      compu++;
    }
  
    if (perfil.lectura_perfiles || perfil.insercion_perfiles ||perfil.edicion_perfiles) {
      document.getElementById("perfperf").style.display = "block";
      comp++;
      compu++;
    }
    if(compu===2 ){
      document.getElementById("desplegableus").style.display= "block";
    }

    if (perfil.lectura_conceptos || perfil.insercion_conceptos || perfil.edicion_conceptos) {
      document.getElementById("cncpperf").style.display = "block";
      comp++;
      compsis++;
    }
  
    if (perfil.permiso_qr) {
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
});
