<script src="https://code.highcharts.com/highcharts.js"></script>

<script>
    $(document).ready(function() {
        load_data();
        load_table();
        load_table_servis();
        load_table_operasional();
        load_table_kerugian();
        load_table_kasbon();
    });

    function load_semua() {
        load_data();
        load_table();
        load_table_servis();
        load_table_operasional();
        load_table_kerugian();
        load_table_kasbon();
    }

    function load_data() {
        $.ajax({
            type: "POST",
            url: "<?= base_url($this->type . '/daftar_cabang/get_data') ?>",
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

    function load_table() {
        $('#table_data').DataTable({
            destroy: true,
            processing: true,
            serverSide: true,
            ordering: false,
            autoWidth: false,
            lengthMenu: [
                [10, 25, 50, 100, -1],
                [10, 25, 50, 100, "All"]
            ],
            ajax: {
                url: '<?= base_url($this->type . '/daftar_cabang/table') ?>',
                type: 'GET',
                dataType: 'JSON',
                data: {
                    tanggal: $('#select_tanggal').val(),
                    id_cabang: '<?= encode_id($id_cabang) ?>',
                },
            },
            order: [],
        })
    }

    function load_table_servis() {
        $('#table_servis').DataTable({
            destroy: true,
            processing: true,
            serverSide: true,
            ordering: false,
            autoWidth: false,
            lengthMenu: [
                [10, 25, 50, 100, -1],
                [10, 25, 50, 100, "All"]
            ],
            ajax: {
                url: '<?= base_url($this->type . '/daftar_cabang/table_servis') ?>',
                type: 'GET',
                dataType: 'JSON',
                data: {
                    tanggal: $('#select_tanggal').val(),
                    id_cabang: '<?= encode_id($id_cabang) ?>',
                },
            },
            order: [],
        })
    }

    function load_table_operasional() {
        $('#table_operasional').DataTable({
            destroy: true,
            processing: true,
            serverSide: true,
            ordering: false,
            autoWidth: false,
            lengthMenu: [
                [10, 25, 50, 100, -1],
                [10, 25, 50, 100, "All"]
            ],
            ajax: {
                url: '<?= base_url($this->type . '/daftar_cabang/table_operasional') ?>',
                type: 'GET',
                dataType: 'JSON',
                data: {
                    tanggal: $('#select_tanggal').val(),
                    id_cabang: '<?= encode_id($id_cabang) ?>',
                },
            },
            order: [],
        })
    }

    function load_table_kerugian() {
        $('#table_kerugian').DataTable({
            destroy: true,
            processing: true,
            serverSide: true,
            ordering: false,
            autoWidth: false,
            lengthMenu: [
                [10, 25, 50, 100, -1],
                [10, 25, 50, 100, "All"]
            ],
            ajax: {
                url: '<?= base_url($this->type . '/daftar_cabang/table_kerugian') ?>',
                type: 'GET',
                dataType: 'JSON',
                data: {
                    tanggal: $('#select_tanggal').val(),
                    id_cabang: '<?= encode_id($id_cabang) ?>',
                },
            },
            order: [],
        })
    }

    function load_table_kasbon() {
        $('#table_kasbon').DataTable({
            destroy: true,
            processing: true,
            serverSide: true,
            ordering: false,
            autoWidth: false,
            lengthMenu: [
                [10, 25, 50, 100, -1],
                [10, 25, 50, 100, "All"]
            ],
            ajax: {
                url: '<?= base_url($this->type . '/daftar_cabang/table_kasbon') ?>',
                type: 'GET',
                dataType: 'JSON',
                data: {
                    tanggal: $('#select_tanggal').val(),
                    id_cabang: '<?= encode_id($id_cabang) ?>',
                },
            },
            order: [],
        })
    }
</script>