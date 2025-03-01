<!doctype html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<title>Documento sin título</title>
	<link href="../css/bootstrap.min.css" rel="stylesheet">
	<link href="../css/menubootstrap.css" rel="stylesheet">
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
	<link rel="stylesheet" href="../css/dialogo.css">
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</head>

<body>
  <script src="../js/cambio_pagina.js"></script>

<div id="menu">
		<div class="row py-4" style="background-color: rgb(182, 215, 168);">
		<div class="col-md-10 d-flex justify-content-center align-items-center"><h1><img src="../img/contab-logo.png" style="height:90px"></h1></div>
		<div class="col-md-1 d-flex justify-content-center align-items-center"><p id="usuario_nombre">username</p></div>
		<div class="col-md-1 d-flex justify-content-center align-items-center">
			<button class="btn btn-sm btn-light ms-0 border border-dark" style="background-color: rgb(151, 214, 157);"><i class="bi bi-person fs-1"></i></button></div>	
		</div>

		<div class="row py-0">
			<nav class="navbar navbar-expand-lg navbar-light bg-white border border-dark py-0">
				<div class="container-fluid py-0">	
					<button class="navbar-toggler py-0" type="button" data-bs-toggle="collapse" data-bs-target="#menuNav">
						<span class="navbar-toggler-icon"></span>
					</button>
					<div class="collapse navbar-collapse py-0" id="menuNav">
						<ul class="navbar-nav d-flex justify-content-center align-items-center py-0">
							<li class="nav-item  px-4" >
								<a class="nav-link text-dark" href="inicio.php">Inicio</a>
							</li>
							<li class="nav-item  px-4" >
								<a class="nav-link text-dark" href="#">Reportes</a>
							</li>
							<li class="nav-item  px-4" >
								<a class="nav-link text-dark" href="#">Ingresos</a>
							</li>
							<li class="nav-item  px-4" >
								<a class="nav-link text-dark" href="#">Egresos</a>
							</li>
							<li class="nav-item  px-4" >
								<a class="nav-link text-dark" href="Usuarios.php">Usuarios</a>
							</li>
							<li class="nav-item  px-4" >
								<a class="nav-link text-dark" href="#">Perfiles</a>
							</li>
							<li class="nav-item  px-4" >
								<a class="nav-link text-dark" href="#">Codigo QR</a>
							</li>
						</ul>
					</div>

				</div>
			</nav>
		</div>

<div id="contenido">

</div>

    <footer class="fixed-bottom bg-light py-2 text-center">
    <p class="mb-0">&copy; <?= date('Y'); ?> Todos los derechos reservados.</p>
</footer>

</body>
</html>