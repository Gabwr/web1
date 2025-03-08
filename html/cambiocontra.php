<!doctype html>
<html lang="es">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Recuperar Contraseania</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
    <link rel="stylesheet" href="../css/contcamb.css">  
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="../js/cambio_contra.js" defer></script>
   
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
                    <input type="text" id="cedrec" name="cedrec" class="form-control border-dark" placeholder="0999999999">
                </div>
                <div class="modal-footer d-flex justify-content-center align-items-center">
                    <button type="button" class="btn btn-white border border-dark" id="ingreso">
                            Enviar</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modal" tabindex="-1" aria-labelledby="infomodalcont" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg my-5">
            <div class="modal-content my-5">
                <div class="container my-5">
                    <div class="row">
                        <div class="inputs d-flex align-items-center">
                        <label for="cont1" class="form-label me-2">Contraseña nueva:</label>
                            <div class="inputs"><input type="password" name="cont1" id="cont1" class="form-control" required>
                                <div class="input-group-append" id="btnOjo1"><i class=" input-group-text bi bi-eye-fill" style="height: 100%;" id="ojo1"></i>
                                  </div>
                                </div>
			  
			                </div>
                        </div>
                        <div class="inputs d-flex align-items-center">
                        
                        <label for="cont2" class="form-label me-2">Contraseña nueva:</label>
                            <div class="inputs"><input type="password" name="cont2" id="cont2" class="form-control" required>
                                <div class="input-group-append" id="btnOjo2"><i class=" input-group-text bi bi-eye-fill" style="height: 100%;" id="ojo2"></i>
                                  </div>
                                </div>
                        
                        </div>
                        <div class="modal-footer d-flex justify-content-center align-items-center">
                            <button type="button" class="btn btn-white border border-dark" id="restart">
                                    Enviar</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>



    <div class="modal fade" id="infomodalmsg" tabindex="-1" aria-labelledby="infomodalmsgLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body text-center">
                    <h1 id="mensaje"></h1>
                </div>
            </div>
        </div>
    </div>



</body>
</html>