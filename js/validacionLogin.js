function validarUser() {
	const user = document.getElementById("usuario");
	let username = user.value;
	const alerta = document.getElementById("alertUser");
	const patronUser = /^[a-z]+$/g;

	if (username === "") {
		alerta.innerHTML = "";
		user.classList.remove("invalid");
	} else if (patronUser.test(username)) {
		alerta.innerHTML = "";
		user.classList.remove("invalid");
	} else {
		user.classList.add("invalid");
		alerta.innerHTML = "❌ Nombre de usuario inválido";
		alerta.classList.add("msjinvalido");
	}

	habilitarBoton();
}

function validarClave() {
	const userkey = document.getElementById("clave");
	let key = userkey.value;
	const alerta = document.getElementById("alertPassword");
	const patronKey = /^[a-zA-Z0-9]{8}$/g;

	if (key === "") {
		alerta.innerHTML = "";
		userkey.classList.remove("invalid");
	} else if (patronKey.test(key)) {
		alerta.innerHTML = "";
		userkey.classList.remove("invalid");
	} else {
		userkey.classList.add("invalid");
		alerta.innerHTML = "❌ Formato de clave inválido. Debe tener 8 caracteres (letras y números).";
		alerta.classList.add("msjinvalido");
	}

	habilitarBoton();
}

function habilitarBoton() {
	const usuarioValido = !document.getElementById("usuario").classList.contains("invalid");
	const claveValida = !document.getElementById("clave").classList.contains("invalid");

	document.getElementById("btnSubmit").disabled = !(usuarioValido && claveValida);
}

function validarFormulario() {
	const usuarioValido = !document.getElementById("usuario").classList.contains("invalid");
	const claveValida = !document.getElementById("clave").classList.contains("invalid");

	if (!usuarioValido || !claveValida) {
		alert("Por favor, corrija los errores antes de continuar.");
		return false;
	}

	return true;
}

function reestablecer() {
	const userkey = document.getElementById("clave");
	const user = document.getElementById("usuario");
	const alertaUsuario = document.getElementById("alertUser");
	const alertaClave = document.getElementById("alertPassword");
  
	user.classList.remove("invalid");
	userkey.classList.remove("invalid");
  
	alertaUsuario.innerHTML = "";
	alertaClave.innerHTML = "";
  
  }
