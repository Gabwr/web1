// JavaScript Document

function envio()
{
	const formulario = document.forms["myForm"];
	formulario.submit();
}

function validarUser(){
	const user = document.getElementById("usuario");
	let username = user.value;
	const alerta= document.getElementById("alertUser");
	const patronUser=/^[a-z]+$/g;
	if(patronUser.test(username)){
		alert("Usuario validado");
		alerta.innerHTML="";
		user.setAttribute("class","");
	}
	else{
		user.setAttribute("class","invalid");
		alerta.setAttribute("class","msjinvalido");
		alerta.innerHTML="Nombre de usuario invalido. Ingrese de nuevo";
	}
}

function validarClave(){
	const userkey=document.getElementById("clave");
	let key=userkey.value;
	const alerta= document.getElementById("alertPassword");
	const patronKey=/^[a-zA-Z0-9]{8}$/g;
	if(patronKey.test(key)){
		alert("Clave validada");
		alerta.innerHTML="";
		userkey.setAttribute("class","");
	}
	else{
		userkey.setAttribute("class","invalid");
		alerta.setAttribute("class","msjinvalido");
		alerta.innerHTML="Formato de clave invalida. Ingrese de nuevo";
	}
}