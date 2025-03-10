document.addEventListener("DOMContentLoaded", function () {
    document.getElementById("return").addEventListener("click", function () {
        window.location.href = "../index.php";
    });
    let findeduser=0;
    var botonAgregar = document.getElementById("ingreso");
    if (botonAgregar && botonAgregar.dataset.eventoAgregado !== "true") {
        botonAgregar.addEventListener("click", function () {
            
            user = $("#userrec").val().trim();
            ced = $("#cedrec").val().trim();
    if (user === "" || ced=== "" ) {
        mensaje("Todos los campos son obligatorios");
        timeout();
        return;
        }

    if (ced.length != 10) {
        mensaje("La cedula debe tener 10 digitos");
        timeout();
        return;
    }
    if (isNaN(ced)) {
        mensaje("La cedula debe ser numerica");
        timeout();
        }
       
        $.ajax({
            url: "../server/getusercont.php",
            method: "POST",
            data: { usuario: user, cedula: ced },
            success: function (response) {
                    findeduser = response; 
                    console.log(findeduser)
                    var modal = new bootstrap.Modal(document.getElementById("modal"));
                    $("#cont1").val("");
                    $("#cont1").val("");
                    modal.show();
                
            },
            error: function () {
                mensaje("Error al procesar la búsqueda");
            }
        });
        console.log(findeduser)
        });
        botonAgregar.dataset.eventoAgregado = "true";
    }

    var botonAgregar = document.getElementById("restart");
    if (botonAgregar && botonAgregar.dataset.eventoAgregado !== "true") {
        botonAgregar.addEventListener("click", function () {
            cont1 = $("#cont1").val().trim();
            cont2 = $("#cont2").val().trim();
            
            if(cont1 === "" && cont2 ===""){
                mensaje("Debe llenar los campos para continuar");
            timeout();
            return;
            }
            if(cont1 !== cont2){
                mensaje("Sus contraseñas no son iguales");
            timeout();
            return;
            }
            
            $.ajax({
                url: "../server/cambiopass.php",
                method: "POST",
                data: { contrasenianueva:cont1,
                        id:findeduser
                },
                success: function (response) {
                    try {
                    findeduser= response;
                    mensaje("Contraseña actualizada");
                    timeout();
                    setTimeout(function() {
                        window.location.href = "../index.php";
                        }, 2000);
                    } catch (e) {
                        mensaje("Hubo un error en el proceso");
                        timeout();
                    }
                },
                error: function () {
                    mensaje("No se pudo realizar el cambio");
                    timeout();
                }
            });
            
        });
        botonAgregar.dataset.eventoAgregado = "true";
    }

    function mensaje(msg) {
        document.getElementById("mensaje").innerHTML = msg;
        var modal = new bootstrap.Modal(document.getElementById("infomodalmsg"));
        modal.show();
    }

    function timeout(){
        setTimeout(function() {
            var modal = bootstrap.Modal.getInstance(document.getElementById("infomodalmsg"));
            modal.hide();
            }, 1000);
    }
});


var claveVisible1=false;
const botonOjo1=document.getElementById("btnOjo1");
function cambiarVisibilidad1()
{
	let ojo=document.getElementById("ojo1");
	let clave=document.getElementById("cont1");
	if(claveVisible1)
		{
			ojo.setAttribute("class","input-group-text bi bi-eye-slash-fill");
			clave.setAttribute("type","text");
			claveVisible1=false;
		}
	else
		{
			ojo.setAttribute("class","input-group-text bi bi-eye-fill");
			clave.setAttribute("type","password");
			claveVisible1=true;
		}
}
var claveVisible2=false;

const botonOjo2=document.getElementById("btnOjo2");
function cambiarVisibilidad2()
{
	let ojo=document.getElementById("ojo2");
	let clave=document.getElementById("cont2");
	if(claveVisible2)
		{
			ojo.setAttribute("class","input-group-text bi bi-eye-slash-fill");
			clave.setAttribute("type","text");
			claveVisible2=false;
		}
	else
		{
			ojo.setAttribute("class","input-group-text bi bi-eye-fill");
			clave.setAttribute("type","password");
			claveVisible2=true;
		}
}

botonOjo1.addEventListener("click",cambiarVisibilidad1);
botonOjo2.addEventListener("click",cambiarVisibilidad2);

