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
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <style>
        .title {
            text-align: left;
            font-size: 2.5rem;
            font-size:24px ;
            margin-bottom: 30px;
            margin-top: 20px;
            color: #333;
        }
        .chart-container {
            background: #fff;
            border-radius: 8px;
            padding: 20px;
            margin-bottom: 20px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }
        .month-selector {
            margin-bottom: 20px;
            text-align: center;
        }
        .month-selector label {
            font-weight: bold;
            margin-right: 10px;
        }
        .month-selector input {
            padding: 5px;
            border-radius: 4px;
            border: 1px solid #ccc;
        }
    </style>
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js"></script> 
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</head>
<body>
    <div class="container">
        <h1 class="title">Dashboard de Finanzas Familiares</h1>

        <div class="month-selector">
            <label for="month">Selecciona el mes:</label>
            <input type="month" id="month" value="<?php echo $selectedMonth; ?>" onchange="updateCharts()">
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="chart-container">
                    <canvas id="ingresosVsGastosChart"></canvas>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="chart-container">
                    <canvas id="gastosPorConceptoChart"></canvas>
                </div>
            </div>
            <div class="col-md-6">
                <div class="chart-container">
                    <canvas id="totalIngresosGastosChart"></canvas>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="chart-container">
                    <canvas id="evolucionIngresosChart"></canvas>
                </div>
            </div>
            <div class="col-md-6">
                <div class="chart-container">
                    <canvas id="evolucionGastosChart"></canvas>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="chart-container">
                    <canvas id="distribucionGastosChart"></canvas>
                </div>
            </div>
            <div class="col-md-6">
                <div class="chart-container">
                    <canvas id="balanceMensualChart"></canvas>
                </div>
            </div>
        </div>
    </div>

    <script>
        const ingresosData = <?php echo json_encode(array_column($ingresos, 'total')); ?>;
        const gastosData = <?php echo json_encode(array_column($gastos, 'total')); ?>;
        const fechas = <?php echo json_encode(array_column($ingresos, 'fecha')); ?>;
        const conceptos = <?php echo json_encode(array_column($conceptos, 'concepto')); ?>;
        const gastosPorConcepto = <?php echo json_encode(array_column($conceptos, 'total')); ?>;
        const totalIngresos = <?php echo $totalIngresos ?? 0; ?>;
        const totalGastos = <?php echo $totalGastos ?? 0; ?>;

        const minimalistaOptions = {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'top',
                    labels: {
                        font: {
                            size: 14,
                            family: 'Arial, sans-serif'
                        }
                    }
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    grid: {
                        color: '#e0e0e0'
                    },
                    ticks: {
                        font: {
                            size: 12
                        }
                    }
                },
                x: {
                    grid: {
                        display: false
                    },
                    ticks: {
                        font: {
                            size: 12
                        }
                    }
                }
            }
        };

        new Chart(document.getElementById('ingresosVsGastosChart'), {
            type: 'bar',
            data: {
                labels: fechas,
                datasets: [
                    { label: 'Ingresos', data: ingresosData, backgroundColor: '#4CAF50' },
                    { label: 'Gastos', data: gastosData, backgroundColor: '#F44336' }
                ]
            },
            options: minimalistaOptions
        });

        new Chart(document.getElementById('gastosPorConceptoChart'), {
            type: 'pie',
            data: {
                labels: conceptos,
                datasets: [{
                    data: gastosPorConcepto,
                    backgroundColor: ['#4CAF50', '#F44336', '#2196F3', '#FFC107', '#9C27B0', '#00BCD4']
                }]
            },
            options: minimalistaOptions
        });

        new Chart(document.getElementById('totalIngresosGastosChart'), {
            type: 'doughnut',
            data: {
                labels: ['Ingresos', 'Gastos'],
                datasets: [{
                    data: [totalIngresos, totalGastos],
                    backgroundColor: ['#4CAF50', '#F44336']
                }]
            },
            options: minimalistaOptions
        });

        new Chart(document.getElementById('evolucionIngresosChart'), {
            type: 'line',
            data: {
                labels: fechas,
                datasets: [{
                    label: 'Ingresos',
                    data: ingresosData,
                    borderColor: '#4CAF50',
                    backgroundColor: 'rgba(76, 175, 80, 0.2)',
                    fill: true,
                    tension: 0.4
                }]
            },
            options: minimalistaOptions
        });

        new Chart(document.getElementById('evolucionGastosChart'), {
            type: 'line',
            data: {
                labels: fechas,
                datasets: [{
                    label: 'Gastos',
                    data: gastosData,
                    borderColor: '#F44336',
                    backgroundColor: 'rgba(244, 67, 54, 0.2)',
                    fill: true,
                    tension: 0.4
                }]
            },
            options: minimalistaOptions
        });

        new Chart(document.getElementById('balanceMensualChart'), {
            type: 'bar',
            data: {
                labels: ['Balance'],
                datasets: [
                    { label: 'Ingresos', data: [totalIngresos], backgroundColor: '#4CAF50' },
                    { label: 'Gastos', data: [totalGastos], backgroundColor: '#F44336' }
                ]
            },
            options: minimalistaOptions
        });

        function updateCharts() {
            const selectedMonth = document.getElementById('month').value;
            window.location.href = `?month=${selectedMonth}`;
        }
    </script>

</body>
</html>