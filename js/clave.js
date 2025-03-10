// JavaScript Document
var claveVisible=false;
const botonOjo=document.getElementById("btnOjo");
function cambiarVisibilidad()
{
	let ojo=document.getElementById("ojo");
	let clave=document.getElementById("clave");
	if(claveVisible)
		{
			ojo.setAttribute("class","input-group-text bi bi-eye-slash-fill");
			clave.setAttribute("type","text");
			claveVisible=false;
		}
	else
		{
			ojo.setAttribute("class","input-group-text bi bi-eye-fill");
			clave.setAttribute("type","password");
			claveVisible=true;
		}
}
botonOjo.addEventListener("click",cambiarVisibilidad);
