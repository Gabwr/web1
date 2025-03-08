<?php
session_start();
$usuario = isset($_POST["usuario"]) ? $_POST["usuario"] : null;
if (!isset($_SESSION['usuario'])) {
    header("Location: ../index.php");
    exit();
}
?>
<!doctype html>
<html>

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Documento sin título</title>
    <link href="../css/bootstrap.min.css" rel="stylesheet">
    <link href="../css/menubootstrap.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
    <link rel="stylesheet" href="../css/dialogo.css">
    <link rel="stylesheet" href="../css/estilomenu.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script> 
    <script src="../js/cambio_pagina.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="../js/sesion.js"></script>
</head>

<body>
    <p id="usuario" style="display:none;"><?php echo $_SESSION['usuario']['usuario']; ?></p>
    <p id="lestate" style="display:none;"><?php echo $_SESSION['usuario']['estado']; ?></p>
    <div id="menu" class="container-fluid py-2">
        <div class="row d-flex justify-content-between align-items-center">
            <div class="col-auto">
                <h1><i class="bi bi-boxes"></i> LaConti</h1>
            </div>

            <div class="col-auto d-flex align-items-center">
                <p id="usuario_nombre" class="me-3">
                    <?php echo $_SESSION['usuario']['nombre'] . " " . $_SESSION['usuario']['apellido']; ?>
                </p>
                <button class="btn btn-profile">
                    <i class="bi bi-person-circle"></i>
                </button>
                <button class="btn btn-profile" id="btn_salida" onClick="salir()"><i
                        class="bi bi-door-open-fill"></i></button>
            </div>
        </div>
    </div>


    <nav class="navbar navbar-expand-lg" style="height: 3rem">
        <div class="container">
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#menuNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse justify-content-center" id="menuNav">
                <ul class="navbar-nav" style="background-color: #f8f9fa;">
                    <li class="nav-item px-3">
                        <a class="nav-link" href="inicio.php"><i class="bi bi-house-door"></i> Inicio</a>
                    </li>
                    <li class="nav-item px-3">
                        <a class="nav-link" href="dashboard.php"> <i class="bi bi-graph-up"></i> Dashboard</a>
                    </li>

                    <li class="nav-item px-3" id="ingperf">
                        <a class="nav-link" href="ingresos.php"><i class="bi bi-currency-dollar"></i> Ingresos</a>
                    </li>
                    <li class="nav-item px-3" id="gastperf">
                        <a class="nav-link" href="Gastos.php"><i class="bi bi-bag"></i> Gastos</a>
                    </li>
                    <li class="nav-item px-3" id="userperf">
                        <a class="nav-link" href="Usuarios.php"><i class="bi bi-people"></i> Usuarios</a>
                    </li>
                    <li class="nav-item px-3" id="perfperf">
                        <a class="nav-link" href="perfiles.php"><i class="bi bi-person-badge"></i> Perfiles</a>
                    </li>
                    <li class="nav-item px-3" id="cncpperf">
                        <a class="nav-link" href="agregarConcepto.php"><i class="bi bi-bank"></i> Concepto Financiero</a>
                    </li>
                    <li class="nav-item px-3" id="qrperf">
                        <a class="nav-link" href="Usuarios.php"><i class="bi bi-upc-scan"></i> Código QR</a>
                    </li>

                </ul>
            </div>
        </div>
    </nav>
    <div id="contenido">

    </div>

    <footer class="fixed-bottom bg-light py-2 text-center">
        <p class="mb-0">&copy; <?= date('Y'); ?> Todos los derechos reservados.</p>
    </footer>

</body>

</html>