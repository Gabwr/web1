<!doctype html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Dashboard</title>
	<link rel="stylesheet" href="../css/estilomenu.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="../css/menubootstrap.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
    <link rel="stylesheet" href="../css/dialogo.css">
</head>

<body>

<script src="../js/cambio_pagina.js"></script>

<div id="menu" class="container-fluid " style="height: 4rem">
    <div class="row align-items-center ">
        <div class="col-md-10 px-5">
            <h1><i class="bi bi-boxes"></i> LaConti</h1>
        </div>
        <div class="col-md-1">
            <p id="usuario_nombre">username</p>
        </div>
        <div class="col-md-1">
            <button class="btn btn-profile">
                <i class="bi bi-person-circle"></i>
            </button>
        </div>
    </div>
</div>

<nav class="navbar navbar-expand-lg" style="height: 3rem">
    <div class="container">
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#menuNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse justify-content-center" id="menuNav">
            <ul class="navbar-nav">
                <li class="nav-item px-3">
                    <a class="nav-link" href="inicio.php"><i class="bi bi-house-door"></i> Inicio</a>
                </li>
                <li class="nav-item px-3">
                    <a class="nav-link" href="#"><i class="bi bi-graph-up"></i> Reportes</a>
                </li>
                <li class="nav-item px-3">
                    <a class="nav-link" href="Usuarios.php"><i class="bi bi-people"></i> Usuarios</a>
                </li>
                <li class="nav-item px-3">
                    <a class="nav-link" href="#"><i class="bi bi-person-badge"></i> Perfiles</a>
                </li>
                <li class="nav-item px-3">
                    <a class="nav-link" href="#"><i class="bi bi-upc-scan"></i> Código QR</a>
                </li>
            </ul>
        </div>
    </div>
</nav>

<div id="contenido" class="W-100">
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
