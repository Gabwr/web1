<!doctype html>
<html lang="es">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Recuperar Contraseania</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
    <link rel="stylesheet" href="../css/contcamb.css">  
    <script src="../js/cambio_contra.js"></script>
   
</head>
<body>
<button id="return" class="btn btn-green mt-3">Regresar al menú inicial</button>
    <div class="container d-flex justify-content-center align-items-center">
        <div class="content my-5 mx-5">
            <div class="container">
                <div class="row">
                    <h1 class="text-center">Cambio de contraseña</h1>
                </div>
                <p>Ingrese sus datos para la recuperación</p>
                <div class="inputs d-flex align-items-center">
                    <label for="userrec" class="form-label me-2">Usuario:</label>
                    <input type="text" id="userrec" name="userrec" class="form-control border-dark" placeholder="Usuario">
                </div>
                <div class="inputs d-flex align-items-center">
                    <label for="cedrec" class="form-label me-2">Cedula:</label>
                    <input type="text" id="cedrec" name="cedrec" class="form-control border-dark" placeholder="cedula">
                </div>
                <div class="modal-footer d-flex justify-content-center align-items-center">
                    <button type="button" class="btn btn-white border border-dark" id="ingreso">Enviar</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="infomodal" tabindex="-1" aria-labelledby="infomodal" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg my-5">
        <div class="modal-content my-5">
			<div class="container my-5">
				<div class="row">
					<h1 class="text-center" id="mensaje"></h1>
				</div>
			</div>
        </div>
    </div>
</div>
</body>
</html>