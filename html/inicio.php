<?php
session_start();
require '../server/conexion.php';

$usuario = isset($_SESSION['usuario']) ? $_SESSION['usuario'] : 'Invitado';


$sql = "SELECT idUsuario FROM USUARIO WHERE usuario = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $usuario);
$stmt->execute();
$result = $stmt->get_result();  
$userData = $result->fetch_assoc();
$idUsuario = $userData['idUsuario'];


$sqlIngresos = "SELECT SUM(valor) AS totalIngresos 
                FROM INGRESO 
                WHERE MONTH(fecha) = MONTH(CURRENT_DATE) 
                AND YEAR(fecha) = YEAR(CURRENT_DATE)";
$stmtIngresos = $conn->prepare($sqlIngresos);
$stmtIngresos->execute();
$resultIngresos = $stmtIngresos->get_result();
$ingresos = $resultIngresos->fetch_assoc()['totalIngresos'];


$sqlEgresos = "SELECT SUM(valor) AS totalEgresos 
               FROM GASTO 
               WHERE MONTH(fecha) = MONTH(CURRENT_DATE) 
               AND YEAR(fecha) = YEAR(CURRENT_DATE)";
$stmtEgresos = $conn->prepare($sqlEgresos);
$stmtEgresos->execute();
$resultEgresos = $stmtEgresos->get_result();
$egresos = $resultEgresos->fetch_assoc()['totalEgresos'];


$sqlPersonasIngresos = "SELECT DISTINCT u.nombre 
                        FROM INGRESO i
                        JOIN USUARIO u ON i.idUsuario = u.idUsuario
                        WHERE i.fecha >= CURDATE() - INTERVAL 30 DAY";
$stmtPersonasIngresos = $conn->prepare($sqlPersonasIngresos);
$stmtPersonasIngresos->execute();
$personasIngresosResult = $stmtPersonasIngresos->get_result();
$personasIngresos = [];
while ($row = $personasIngresosResult->fetch_assoc()) {
  $personasIngresos[] = $row['nombre']; 
}



$sqlPersonasEgresos = "SELECT DISTINCT u.nombre 
                       FROM GASTO g
                       JOIN USUARIO u ON g.idUsuario = u.idUsuario
                       WHERE g.fecha >= CURDATE() - INTERVAL 30 DAY";
$stmtPersonasEgresos = $conn->prepare($sqlPersonasEgresos);
$stmtPersonasEgresos->execute();
$personasEgresosResult = $stmtPersonasEgresos->get_result();

$personasEgresos = [];
while ($row = $personasEgresosResult->fetch_assoc()) {
  $personasEgresos[] = $row['nombre']; 
}

?>
<!doctype html>
<html>

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>Inicio</title>
  <link href="../css/bootstrap.min.css" rel="stylesheet">
  <link href="../css/menubootstrap.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css"
    integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg=="
    crossorigin="anonymous" referrerpolicy="no-referrer" />
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
  <link rel="stylesheet" href="../css/dialogo.css">
  <link rel="stylesheet" href="../css/inicio.css">
</head>

<body>
  <header>
    <div class="row py-4 w-full" style="background-color: rgb(182, 215, 168);">
      <div class="col-md-10 d-flex justify-content-center align-items-center">
        <h1>ICONO</h1>
      </div>
      <div class="col-md-1 d-flex justify-content-center align-items-center">
        <p id="usuario_nombre"><?= $usuario; ?></p>
      </div>
      <div class="col-md-1 d-flex justify-content-center align-items-center">
        <button class="btn btn-sm btn-light ms-0 border border-dark" style="background-color: rgb(151, 214, 157);">
          <i class="bi bi-person fs-1"></i>
        </button>
      </div>
    </div>
  </header>

  <nav class="navbar navbar-expand-lg navbar-light bg-white border border-dark py-0">
    <div class="container-fluid py-0">
      <button class="navbar-toggler py-0" type="button" data-bs-toggle="collapse" data-bs-target="#menuNav">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse py-0" id="menuNav">
        <ul class="navbar-nav d-flex justify-content-center align-items-center py-0">
          <li class="nav-item  px-5"><a class="nav-link text-dark" href="inicio.php">Inicio</a></li>
          <li class="nav-item  px-5"><a class="nav-link text-dark" href="#">Reportes</a></li>
          <li class="nav-item  px-5"><a class="nav-link text-dark" href="#">Usuarios</a></li>
          <li class="nav-item  px-5"><a class="nav-link text-dark" href="#">Perfiles</a></li>
          <li class="nav-item  px-5"><a class="nav-link text-dark" href="#">Codigo QR</a></li>
        </ul>
      </div>
    </div>
  </nav>

  <section class="container py-4">
        <div class="row g-3">
            <div class="col-md-6">
                <div class="p-4 text-white rounded" style="background-color: #69a84f;">
                    <h4>Ingresos del Mes</h4>
                    <div class="d-flex justify-content-between align-items-center">
                        <p class="fs-4 mb-0">$<?= $ingresos ? $ingresos : '0.00'; ?></p>
                        <i class="fa-solid fa-money-bill-trend-up fa-2x"></i>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="p-4 text-white rounded" style="background-color: #e69137;">
                    <h4>Egresos del Mes</h4>
                    <div class="d-flex justify-content-between align-items-center">
                        <p class="fs-4 mb-0">$<?= $egresos ? $egresos : '0.00'; ?></p>
                        <i class="fa-solid fa-money-bill-transfer fa-2x"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="mt-4">
            <div class="p-4 bg-light rounded">
                <h4>Actividad Reciente</h4>
                <ul class="list-group list-group-flush">
                    <?php
                    $personasActividad = array_merge($personasIngresos, $personasEgresos);
                    $personasActividad = array_unique($personasActividad);
                    foreach ($personasActividad as $persona) {
                        echo "<li class='list-group-item'>" . htmlspecialchars($persona) . "</li>";
                    }
                    ?>
                </ul>
            </div>
        </div>
    </section>

  <footer>
    <p>&copy; <?= date('Y'); ?> Todos los derechos reservados.</p>
  </footer>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
  <script src="../js/usuario.js"></script>
</body>

</html>