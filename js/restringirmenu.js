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

  let menu = window.getComputedStyle(document.getElementById("estatico")).height;
  let menuHeight = parseFloat(menu)+10; 
  document.getElementById("contenidomenu").style.marginTop = menuHeight + "px"; 

  
  let bsCollapse = document.querySelector(".navbar-collapse");

  document.querySelectorAll(".navbar-nav .nav-link:not(.dropdown-toggle)").forEach(function (link) {
      link.addEventListener("click", function () {
          if (window.innerWidth < 1000) { 
              let bsCollapseInstance = new bootstrap.Collapse(bsCollapse, {
                  toggle: false
              });
              bsCollapseInstance.hide();
          }
      });
  });
  
  document.querySelectorAll(".dropdown-menu .dropdown-item").forEach(function (item) {
    item.addEventListener("click", function () {
        if (window.innerWidth < 1000) { 
            let bsCollapseInstance = new bootstrap.Collapse(bsCollapse, {
                toggle: false
            });
            bsCollapseInstance.hide();
        }
    });
});

const menuItems = document.querySelectorAll('.newhov');

menuItems.forEach(item => {
    item.addEventListener('click', function () {
        menuItems.forEach(i => i.classList.remove('active'));
        this.classList.add('active');
    });
});

const menuItems1 = document.querySelectorAll('.navbar-nav');

menuItems1.forEach(item => {
    item.addEventListener('click', function () {
        menuItems1.forEach(i => i.classList.remove('active'));
        this.classList.add('active');
    });
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

    if (perfil.lectura_ingresos == true || perfil.Insercion_ingresos == true || perfil.edicion_ingresos == true) {
        document.getElementById("ingperf").style.display = "block";
        comp++;
    }
    
    if (perfil.lectura_gastos == true  || perfil.insercion_gastos == true  || perfil.edicion_gastos== true ) {
        document.getElementById("gastperf").style.display = "block";
        comp++;
    }
  
    if (perfil.lectura_usuarios== true || perfil.insercion_usuarios == true|| perfil.edicion_usuarios == true) {
      document.getElementById("userperf").style.display = "block";
      comp++;
      compu++;
    }

    if (perfil.lectura_perfiles== true || perfil.insercion_perfiles== true ||perfil.edicion_perfiles== true) {
      document.getElementById("perfperf").style.display = "block";
      comp++;
      compu++;
    }

    if(compu>0 ){
      document.getElementById("desplegableus").style.display= "block";
    }

    if (perfil.lectura_conceptos == true|| perfil.insercion_conceptos== true || perfil.edicion_conceptos== true) {
      document.getElementById("cncpperf").style.display = "block";
      comp++;
      compsis++;
    }
  
    if (perfil.permiso_qr== true) {
      document.getElementById("qrperf").style.display = "block";
      comp++;
      compsis++;
    }

    if(compsis>0 ){
      document.getElementById("desplegablesis").style.display= "block";
    }
    if(comp==6 ){
      document.getElementById("auditoria").style.display= "block";
    }
  }
});
