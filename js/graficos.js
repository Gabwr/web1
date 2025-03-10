if (!window.chartsInicializados) {
    window.chartsInicializados = true;

    let ingresosVsGastosChart, gastosPorConceptoChart, totalIngresosGastosChart,
        evolucionIngresosChart, evolucionGastosChart, distribucionGastosChart,
        balanceMensualChart;

    function iniciarCharts() {
        ingresosVsGastosChart = echarts.init(document.getElementById('ingresosVsGastosChart'));
        gastosPorConceptoChart = echarts.init(document.getElementById('gastosPorConceptoChart'));
        totalIngresosGastosChart = echarts.init(document.getElementById('totalIngresosGastosChart'));
        evolucionIngresosChart = echarts.init(document.getElementById('evolucionIngresosChart'));
        evolucionGastosChart = echarts.init(document.getElementById('evolucionGastosChart'));
        distribucionGastosChart = echarts.init(document.getElementById('distribucionGastosChart'));
        balanceMensualChart = echarts.init(document.getElementById('balanceMensualChart'));
    }

    function actualizarCharts() {
        const selectedMonth = document.getElementById('month').value;

        const cachedData = localStorage.getItem(`chartsData_${selectedMonth}`);
        if (cachedData) {
            renderCharts(JSON.parse(cachedData));
            return;
        }

        fetch(`../server/traerdata.php?month=${selectedMonth}`)
            .then(response => response.json())
            .then(data => {
                localStorage.setItem(`chartsData_${selectedMonth}`, JSON.stringify(data));
                renderCharts(data);
            })
            .catch(error => console.error('Error al cargar los datos:', error));
    }

    function renderCharts(data) {
        const ingresosData = data.ingresos.map(item => item.total);
        const gastosData = data.gastos.map(item => item.total);
        const fechas = data.ingresos.map(item => item.fecha);
        const conceptos = data.conceptos.map(item => item.concepto);
        const gastosPorConcepto = data.conceptos.map(item => item.total);
        const totalIngresos = data.totalIngresos || 0;
        const totalGastos = data.totalGastos || 0;

        ingresosVsGastosChart.setOption({
            title: { text: 'Ingresos vs Gastos' },
            tooltip: {},
            legend: { data: ['Ingresos', 'Gastos'] },
            xAxis: { type: 'category', data: fechas, name: 'Fechas' },
            yAxis: { type: 'value', name: 'Total' },
            series: [
                { name: 'Ingresos', type: 'line', data: ingresosData, smooth: true, itemStyle: { color: '#4CAF50' } },
                { name: 'Gastos', type: 'line', data: gastosData, smooth: true, itemStyle: { color: '#F44336' } }
            ]
        });

        gastosPorConceptoChart.setOption({
            title: { text: 'Gastos por Concepto' },
            tooltip: {},
            legend: { data: conceptos , top: '10%',},
            series: [{
                name: 'Gastos',
                type: 'pie',
                radius: '50%',
                data: conceptos.map((concepto, index) => ({ name: concepto, value: gastosPorConcepto[index] })),
                emphasis: {
                    itemStyle: {
                        shadowBlur: 10,
                        shadowOffsetX: 0,
                        shadowColor: 'rgba(0, 0, 0, 0.5)'
                    }
                }
            }]
        });

        totalIngresosGastosChart.setOption({
            title: { text: 'Total Ingresos y Gastos' },
            tooltip: {},
            series: [{
                name: 'Total',
                type: 'pie',
                radius: '50%',
                data: [
                    { name: 'Ingresos', value: totalIngresos },
                    { name: 'Gastos', value: totalGastos }
                ],
                emphasis: {
                    itemStyle: {
                        shadowBlur: 10,
                        shadowOffsetX: 0,
                        shadowColor: 'rgba(0, 0, 0, 0.5)'
                    }
                }
            }]
        });

        evolucionIngresosChart.setOption({
            title: { text: 'Evolución de Ingresos' },
            tooltip: {},
            xAxis: { type: 'category', data: fechas, name: 'Fechas' },
            yAxis: { type: 'value', name: 'Total' },
            series: [{ name: 'Ingresos', type: 'line', data: ingresosData, smooth: true, itemStyle: { color: '#4CAF50' } }]
        });

        evolucionGastosChart.setOption({
            title: { text: 'Evolución de Gastos' },
            tooltip: {},
            xAxis: { type: 'category', data: fechas, name: 'Fechas' },
            yAxis: { type: 'value', name: 'Total' },
            series: [{ name: 'Gastos', type: 'line', data: gastosData, smooth: true, itemStyle: { color: '#F44336' } }]
        });

        distribucionGastosChart.setOption({
            title: { text: 'Distribución de Gastos' },
            tooltip: {},
            legend: { data: conceptos ,top: '10%',},
            series: [{
                name: 'Gastos',
                type: 'pie',
                radius: '50%',
                data: conceptos.map((concepto, index) => ({ name: concepto, value: gastosPorConcepto[index] })),
                emphasis: {
                    itemStyle: {
                        shadowBlur: 10,
                        shadowOffsetX: 0,
                        shadowColor: 'rgba(0, 0, 0, 0.5)'
                    }
                }
            }]
        });

        balanceMensualChart.setOption({
            title: { text: 'Balance Mensual' },
            tooltip: {},
            xAxis: { type: 'category', data: ['Balance'] },
            yAxis: { type: 'value', name: 'Total' },
            series: [
                { name: 'Ingresos', type: 'bar', data: [totalIngresos], itemStyle: { color: '#4CAF50' } },
                { name: 'Gastos', type: 'bar', data: [totalGastos], itemStyle: { color: '#F44336' } }
            ]
        });
    }

    document.addEventListener('visibilitychange', function () {
        if (!document.hidden) {
            const selectedMonth = document.getElementById('month').value;
            const cachedData = localStorage.getItem(`chartsData_${selectedMonth}`);
            if (cachedData) {
                renderCharts(JSON.parse(cachedData));
            } else {
                actualizarCharts();
            }
        }
    });

    iniciarCharts();
    const selectedMonth = document.getElementById('month').value;
    const cachedData = localStorage.getItem(`chartsData_${selectedMonth}`);
    if (cachedData) {
        renderCharts(JSON.parse(cachedData));
    } else {
        actualizarCharts();
    }
} else {
    iniciarCharts();
    const selectedMonth = document.getElementById('month').value;
    const cachedData = localStorage.getItem(`chartsData_${selectedMonth}`);
    if (cachedData) {
        renderCharts(JSON.parse(cachedData));
    } else {
        actualizarCharts();
    }
}