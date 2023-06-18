<script src="https://code.highcharts.com/highcharts.js"></script>

<script>
    Highcharts.chart('grafik1', {
        chart: {
            type: 'column'
        },
        title: {
            text: 'Grafik<br>Transaksi Penjualan & Profit Penjualan<br>Mei 2023'
        },
        xAxis: {
            categories: ['Office','Tangerang','Pekanbaru','Bogor','Jatinangor','Madiun','Bandung','Bekasi','Depok','Semarang','Solo','Bantul','Sleman']
        },
        yAxis: {
            title: {
                text: 'Total'
            }
        },
        series: [{
            name: 'Modal',
            data: [12234456, 6352897, 9876543, 5689421, 13379988, 11122233, 9876540, 1456789, 10000001, 15000000, 1234567, 8765432, 9999999],
        }, {
            name: 'Profit',
            data:  [1634209, 1263587, 2854776, 2489412, 2873412, 2224448, 1300820, 2895139, 1759030, 2256789, 1067055, 2750823, 2985467],
        }]
    });
</script>