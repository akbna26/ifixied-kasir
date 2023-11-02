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

<script>
    const id_cabang = '<?= encode_id($id_cabang) ?>';

    $(document).ready(function() {
        $('.scroll_link').on('click', function(event) {
            event.preventDefault();
            var target = $($(this).attr('href'));

            $('html, body').animate({
                scrollTop: target.offset().top - 100,
            }, 1000);
        });

        var lastScrollTop = 0;
        var element = $('#tombol_naik');

        $(window).scroll(function() {
            var st = $(this).scrollTop();
            if (st > lastScrollTop) {
                element.hide();
            } else {
                element.show();
            }
            lastScrollTop = st;
        });

        reload_table();
    });

    function reload_table() {
        load_table_transaksi();
        load_table_servis();
        load_table_operasional();
        load_table_kerugian();
        load_table_kasbon();
    }

    function load_table_transaksi() {
        $('#table_data_transaksi').DataTable({
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
                url: '<?= base_url($this->type . '/daftar_cabang/table_transaksi') ?>',
                type: 'GET',
                dataType: 'JSON',
                data: {
                    tgl_start: $('#tgl_start').val(),
                    tgl_end: $('#tgl_end').val(),
                    id_cabang: id_cabang,
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
                    tgl_start: $('#tgl_start').val(),
                    tgl_end: $('#tgl_end').val(),
                    id_cabang: id_cabang,
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
                    tgl_start: $('#tgl_start').val(),
                    tgl_end: $('#tgl_end').val(),
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
                    tgl_start: $('#tgl_start').val(),
                    tgl_end: $('#tgl_end').val(),
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
                    tgl_start: $('#tgl_start').val(),
                    tgl_end: $('#tgl_end').val(),
                    id_cabang: '<?= encode_id($id_cabang) ?>',
                },
            },
            order: [],
        })
    }
</script>