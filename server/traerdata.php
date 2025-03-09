<?php
include("../server/conexion.php");

$selectedMonth = isset($_GET['month']) ? $_GET['month'] : date('Y-m');

$queryIngresos = $conn->query("
    SELECT fecha, SUM(valor) as total 
    FROM ingreso 
    WHERE DATE_FORMAT(fecha, '%Y-%m') = '$selectedMonth'
    GROUP BY fecha
");
$ingresos = [];
while ($row = $queryIngresos->fetch_assoc()) {
    $ingresos[] = $row;
}

$queryGastos = $conn->query("
    SELECT fecha, SUM(valor) as total 
    FROM gasto 
    WHERE DATE_FORMAT(fecha, '%Y-%m') = '$selectedMonth'
    GROUP BY fecha
");
$gastos = [];
while ($row = $queryGastos->fetch_assoc()) {
    $gastos[] = $row;
}

$queryConceptos = $conn->query("
    SELECT c.nombre as concepto, SUM(g.valor) as total 
    FROM gasto g
    JOIN concepto c ON g.idconcepto = c.idconcepto
    WHERE DATE_FORMAT(g.fecha, '%Y-%m') = '$selectedMonth'
    GROUP BY c.nombre
");
$conceptos = [];
while ($row = $queryConceptos->fetch_assoc()) {
    $conceptos[] = $row;
}

$queryTotalIngresos = $conn->query("
    SELECT SUM(valor) as total 
    FROM ingreso 
    WHERE DATE_FORMAT(fecha, '%Y-%m') = '$selectedMonth'
");
$totalIngresos = $queryTotalIngresos->fetch_assoc()['total'];

$queryTotalGastos = $conn->query("
    SELECT SUM(valor) as total 
    FROM gasto 
    WHERE DATE_FORMAT(fecha, '%Y-%m') = '$selectedMonth'
");
$totalGastos = $queryTotalGastos->fetch_assoc()['total'];

$conn->close();

// Devolver los datos en formato JSON
header('Content-Type: application/json');
echo json_encode([
    'ingresos' => $ingresos,
    'gastos' => $gastos,
    'conceptos' => $conceptos,
    'totalIngresos' => $totalIngresos,
    'totalGastos' => $totalGastos
]);
?>