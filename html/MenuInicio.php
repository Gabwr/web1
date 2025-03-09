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
    <title>FIFA</title>
    <link href="../css/bootstrap.min.css" rel="stylesheet">
    <link href="../css/menubootstrap.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
    <link rel="stylesheet" href="../css/dialogo.css">
    <link rel="stylesheet" href="../css/estilomenu.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script> 
    <script src="../js/cambio_pagina.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
	<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="../js/sesion.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.18.5/xlsx.full.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/FileSaver.js/2.0.5/FileSaver.min.js"></script>
	<script type="module"  src="https://cdn.jsdelivr.net/npm/jspdf-autotable@5.0.2/dist/jspdf.plugin.autotable.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.5.31/jspdf.plugin.autotable.min.js"></script>
    <script src="../js/restringirmenu.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.js" integrity="sha384-w52cgKJL63XVo8/Wwyl+z8ly0lI51gzCtqADl8pHQTXUXkF08iRa7D+sjSmCyHp+" crossorigin="anonymous"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.js" integrity="sha384-P2rohseTZr3+/y/u+6xaOAE3CIkcmmC0e7ZjhdkTilUMHfNHCerfVR9KICPeFMOP" crossorigin="anonymous"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js" integrity="sha384-/RlQG9uf0M2vcTw3CX7fbqgbj/h8wKxw7C3zu9/GxcBPRKOEcESxaxufwRXqzq6n" crossorigin="anonymous"></script>
	<script src="https://cdn.datatables.net/2.2.2/js/dataTables.js" integrity="sha384-gGekiWQ/bm8p71RTsvhPShoIBxcf8BsVjRTi0WY8FvxuQa2nKS0PKHiSXV9nfW/A" crossorigin="anonymous"></script>
	<script src="https://cdn.datatables.net/buttons/3.2.2/js/dataTables.buttons.js" integrity="sha384-wCLG3FbyFPnMZM65D+pam9KW+2joK88dh4jfSMK0OuMQ2cBQHV0t55OqmQduaQ1S" crossorigin="anonymous"></script>
	<script src="https://cdn.datatables.net/buttons/3.2.2/js/buttons.html5.js" integrity="sha384-r5RumiuQhALaYWd8i8v0DxCjEXRayyj6nl1wP379+GexLAvE4yuLNoyPEvE6hzDu" crossorigin="anonymous"></script>
	<script src="https://cdn.datatables.net/buttons/3.2.2/js/buttons.print.js" integrity="sha384-EFgXDkkRvdjFZC4gKym8BJ0H81TlX+XVAfK0HuggI8Pvtd6UNdQiyFXFD3Ohu+uz" crossorigin="anonymous"></script>
	<script src="https://cdn.datatables.net/2.2.2/js/dataTables.bootstrap5.js"></script>
	<link rel="stylesheet" href="https://cdn.datatables.net/2.2.2/css/dataTables.bootstrap5.css">
	
</head>

<body>
    <p id="usuario" style="display:none;"><?php echo $_SESSION['usuario']['usuario']; ?></p>
    <p id="lestate" style="display:none;"><?php echo $_SESSION['usuario']['estado']; ?></p>
    <div id="estatico">
    <div id="menu" class="container-fluid py-2">
        <div class="row d-flex justify-content-between align-items-center">
            <div class="col-auto">
                <h1 class="navbar-brand">
      			<i class="bi bi-bar-chart-line-fill"></i>FIFA
   				</h1>
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
                    <li class="nav-item dropdown px-3"  id="desplegableus">
                        <a class="nav-link dropdown-toggle" id="dropdownuser" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="bi bi-people"></i> Gestión de Usuarios
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="dropdownuser">
                            <li><a class="dropdown-item" href="Usuarios.php" id="userperf"><i class="bi bi-people"></i> Usuarios</a></li>
                            <li><a class="dropdown-item" href="perfiles.php" id="perfperf"><i class="bi bi-person-badge"></i> Perfiles</a></li>
                        </ul>
                    </li>
                    <li class="nav-item dropdown px-3" id="desplegablesis">
                        <a class="nav-link dropdown-toggle" id="dropdownsis" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="bi bi-people"></i> Gestión del Sistema
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="dropdownsis">
                            <li  id="cncpperf">
                                <a class="nav-link" href="agregarConcepto.php"><i class="bi bi-bank"></i> Concepto<br> (Ingresos-Gastos)
                            </a>
                            </li>
                            <li id="qrperf">
                                <a class="nav-link" href="Usuarios.php"><i class="bi bi-upc-scan"></i> Código QR
                            </a>
                            </li>
                            <li  id="auditoria">
                                <a class="nav-link" href="auditoria.php">
                                    <i class="bi bi-journal-medical"></i> Auditoría
                                </a>
                            </li>
                    </ul>
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