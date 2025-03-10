<?php
include("../server/conexion.php");

$selectedMonth = isset($_GET['month']) ? $_GET['month'] : date('Y-m');

$queryIngresos = $conn->query("
    SELECT fecha, SUM(valor) as total 
    FROM ingreso 
    WHERE DATE_FORMAT(fecha, '%Y-%m') = '$selectedMonth' and estado='Activo'
    GROUP BY fecha
");
$ingresos = [];
while ($row = $queryIngresos->fetch_assoc()) {
    $ingresos[] = $row;
}

$queryGastos = $conn->query("
    SELECT fecha, SUM(valor) as total 
    FROM gasto 
    WHERE DATE_FORMAT(fecha, '%Y-%m') = '$selectedMonth' and estado='Activo'
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
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <title>Dashboard</title>
    <link rel="stylesheet" href="../css/chart.css">
    <script src="https://cdn.jsdelivr.net/npm/echarts/dist/echarts.min.js"></script>
</head>

<body>
    <div class="container" style="overflow-y: scroll; max-height: 68vh; scrollbar-width: none;">
        <h4>Dashboard </h4>
        <div class="month-selector">
            <label for="month">Selecciona el mes:</label>
            <input type="month" id="month" value="<?php echo $selectedMonth; ?>" onchange="actualizarCharts()">
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="chart-container">
                    <div id="ingresosVsGastosChart" style="height: 400px; "></div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="chart-container">
                    <div id="gastosPorConceptoChart" style="height: 400px;"></div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="chart-container">
                    <div id="totalIngresosGastosChart" style="height: 400px;"></div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="chart-container">
                    <div id="evolucionIngresosChart" style="height: 400px;"></div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="chart-container">
                    <div id="evolucionGastosChart" style="height: 400px;"></div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="chart-container">
                    <div id="distribucionGastosChart" style="height: 400px;"></div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="chart-container">
                    <div id="balanceMensualChart" style="height: 400px;"></div>
                </div>
            </div>
        </div>
    </div>

    <script src="../js/recuperarmonth.js"></script>

    <script src="../js/graficos.js"></script>
</body>
