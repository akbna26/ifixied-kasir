<script src="https://code.highcharts.com/highcharts.js"></script>

<script>
    $(document).ready(function() {
        load_data();
    });

    function load_data() {
        $.ajax({
            type: "POST",
            url: "<?= base_url('owner/daftar_cabang/get_data') ?>",
            data: {
                id_cabang: '<?= encode_id($id_cabang) ?>',
                tanggal: $('#select_tanggal').val(),
            },
            dataType: "JSON",
            beforeSend: function() {
                Swal.fire({
                    title: 'Loading',
                    html: '<i style="font-size:25px;" class="fa fa-spinner fa-spin"></i>',
                    allowOutsideClick: false,
                    showConfirmButton: false,
                });
            },
            complete: function() {
                Swal.close();
            },
            success: function(res) {
                if (res.status == 'success') {
                    load_grafik(res);
                    $('#total_profit_penjualan').html(res.data.total_profit_penjualan)
                    $('#total_profit_servis').html(res.data.total_profit_servis)
                    $('#total_profit_harian').html(res.data.total_profit_harian)
                    $('#total_profit_bulanan').html(res.data.total_profit_bulanan)
                }
            }
        });
    }

    function load_grafik(res) {
        Highcharts.chart('grafik', {
            chart: {
                type: 'column'
            },
            title: {
                text: `Grafik Profit Harian<br> ${res.grafik.waktu}`
            },
            xAxis: {
                categories: res.grafik.kategori
            },
            yAxis: {
                title: {
                    text: 'Total'
                }
            },
            series: [{
                name: 'Profit',
                data: res.grafik.series,
            }]
        });
    }
</script>