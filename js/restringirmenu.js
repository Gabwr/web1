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
    if (perfil.lectura_ingresos == true && perfil.Insercion_ingresos == true && perfil.edicion_ingresos == true) {
        document.getElementById("ingperf").style.display = "block";
      comp++;
    }
    if (perfil.lectura_gastos == true && perfil.insercion_gastos == true && perfil.edicion_gastos == true) {
        document.getElementById("gastperf").style.display = "block";
        comp++;
    }
  
    if (perfil.lectura_usuarios == true && perfil.insercion_usuarios == true && perfil.edicion_usuarios == true) {
      document.getElementById("userperf").style.display = "block";
      comp++;
    }
  
    if (perfil.lectura_perfiles == true && perfil.insercion_perfiles == true && perfil.edicion_perfiles == true) {
      document.getElementById("perfperf").style.display = "block";
      comp++;
    }
  
    if (perfil.lectura_conceptos == true && perfil.insercion_conceptos == true && perfil.edicion_conceptos == true) {
      document.getElementById("cncpperf").style.display = "block";
      comp++;
    }
  
    if (perfil.permiso_qr == true ) {
      document.getElementById("qrperf").style.display = "block";
      comp++;
    }
    if(comp===6 ){
      document.getElementById("auditoria").style.display= "block";
    }
  }
});
