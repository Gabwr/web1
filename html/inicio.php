<?php
session_start();
require '../server/conexion.php';

$usuario = isset($_SESSION['usuario']) ? $_SESSION['usuario'] : 'Invitado';

$sql = "SELECT idUsuario FROM usuario WHERE usuario = ?";
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
<div id="contenido"> 
  <section class="d-flex justify-content-center py-5 px-5 overflow-auto w-100vw gap-5 border" style=" height: calc(100vh - 12rem);"> 
    <div class="flex-column align-items-center gap-5 w-100 d-flex">
        <div class="col-md-6">
            <div class="p-4 text-white rounded d-flex flex-column justify-content-center align-items-center" style="background-color: #69a84f; min-height: 150px;">
                <h4 class="text-center">Ingresos del Mes</h4>
                <div class="d-flex justify-content-center align-items-center gap-3">
                    <p class="fs-4 mb-0">$<?= $ingresos ? $ingresos : '0.00'; ?></p>
                    <i class="fa-solid fa-money-bill-trend-up fa-2x"></i>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="p-4 text-white rounded d-flex flex-column justify-content-center align-items-center" style="background-color: #e69137; min-height: 150px;">
                <h4 class="text-center">Gastos del Mes</h4>
                <div class="d-flex justify-content-center align-items-center gap-3">
                    <p class="fs-4 mb-0">$<?= $egresos ? $egresos : '0.00'; ?></p>
                    <i class="fa-solid fa-money-bill-transfer fa-2x"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="mt-4 w-100 overflow-auto">
        <div class="p-4 bg-light rounded overflow-auto" style="min-height: 200px;">
            <h4 class="text-center">Actividad Reciente</h4>
            <ul class="list-group list-group-flush">
                <?php
                $personasActividad = array_merge($personasIngresos, $personasEgresos);
                $personasActividad = array_unique($personasActividad);
                foreach ($personasActividad as $persona) {
                    echo "<li class='list-group-item d-flex align-items-center'><i class='fa-solid fa-user me-2'></i> " . htmlspecialchars($persona) . "</li>";
                }
                ?>
            </ul>
        </div>
    </div>
</section>

</section>
</div>

</body>

</html>