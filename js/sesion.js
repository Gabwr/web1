function cerrarSesion()
{
	sessionStorage.clear();
	window.location.assign("../server/logout.php");
}

function monitorearInactividad() {
  let contador;
  const TIEMPO_LIMITE = 180000; //3 minutos o 180000 milisegundos
  const reiniciarConteo = function(){
    clearTimeout(contador);//Quita el conteo
    contador = setTimeout(function(){
      alert("Ha estado mucho tiempo Inactivo. Su sesión se ha cerrrado.");
	  cerrarSesion();
    }, TIEMPO_LIMITE);
  };

  window.onload = reiniciarConteo;//Empieza a lo que se carga
	//Con cada acción sobre la página, se reinicia el conteo
  document.onmousemove = reiniciarConteo;
  document.onmousedown = reiniciarConteo;
  document.onkeypress = reiniciarConteo;
  document.onscroll = reiniciarConteo;
}

monitorearInactividad();
