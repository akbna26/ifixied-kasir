<script src="https://code.highcharts.com/highcharts.js" type="text/javascript"></script>
<script src="https://code.highcharts.com/modules/exporting.js"></script>
<script src="https://code.highcharts.com/modules/full-screen.js"></script>

<script>
    $(document).ready(function() {
        load_grafik_profit();
        load_grafik_penjualan();
    });

    function load_grafik_profit() {
        var tahun = $('#filter_tahun_profit').val();
        var bulan = $('#filter_bulan_profit').val();
        var nm_bulan = $('#filter_bulan_profit').find(':selected').text();

        $.ajax({
            type: "POST",
            url: "<?= base_url($this->type . '/daftar_cabang/get_data') ?>",
            data: {
                id_cabang: '<?= encode_id($cabang->id) ?>',
                bulan: bulan,
                tahun: tahun,
            },
            dataType: "JSON",
            success: function(res) {
                if (res.status == 'success') {

                    Highcharts.chart('grafik_profit', {
                        chart: {
                            type: 'column'
                        },
                        title: {
                            text: nm_bulan + " " + tahun,
                        },
                        xAxis: {
                            categories: res.grafik.kategori
                        },
                        yAxis: {
                            title: {
                                text: 'Profit'
                            },
                            labels: {
                                formatter: function() {
                                    var value = this.value;
                                    var suffix = '';
                                    if (value >= 1000000000) {
                                        value = value / 1000000000;
                                        suffix = 'M';
                                    } else if (value >= 1000000) {
                                        value = value / 1000000;
                                        suffix = 'JT';
                                    } else if (value >= 1000) {
                                        value = value / 1000;
                                        suffix = 'RB';
                                    }
                                    return value + ' ' + suffix;
                                }
                            }
                        },
                        series: [{
                            name: 'Profit',
                            data: res.grafik.series,
                            colorByPoint: true,
                            dataLabels: {
                                enabled: true,
                                inside: true,
                                formatter: function() {
                                    return Highcharts.numberFormat(this.y, 0, ',', '.');
                                }
                            }
                        }]
                    });

                }
            }
        });
    }

    function load_grafik_penjualan() {
        var tahun = $('#filter_tahun_penjualan').val();
        var bulan = $('#filter_bulan_penjualan').val();
        var nm_bulan = $('#filter_bulan_penjualan').find(':selected').text();

        $.ajax({
            type: "POST",
            url: "<?= base_url($this->type . '/daftar_cabang/get_data_penjualan') ?>",
            data: {
                id_cabang: '<?= encode_id($cabang->id) ?>',
                bulan: bulan,
                tahun: tahun,
            },
            dataType: "JSON",
            success: function(res) {
                if (res.status == 'success') {

                    Highcharts.chart('grafik_profit_penjualan', {
                        chart: {
                            type: 'pie'
                        },
                        title: {
                            text: nm_bulan + " " + tahun,
                        },
                        plotOptions: {
                            pie: {
                                dataLabels: {
                                    enabled: true,
                                    format: '{point.name} ({point.percentage:.1f}%)'
                                }
                            }
                        },
                        series: [{
                            name: 'Terjual',
                            data: res.grafik.series
                        }]
                    });

                }
            }
        });
    }
</script>