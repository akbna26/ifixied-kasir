<!-- toastr plugin -->
<link rel="stylesheet" type="text/css" href="<?= base_url('assets/skote/dist/') ?>assets/libs/toastr/build/toastr.min.css">
<script src="<?= base_url('assets/skote/dist/') ?>assets/libs/toastr/build/toastr.min.js"></script>

<!-- Sweet Alerts js -->
<link href="<?= base_url('assets/skote/dist/') ?>assets/libs/sweetalert2/sweetalert2.min.css" rel="stylesheet" type="text/css" />
<script src="<?= base_url('assets/skote/dist/') ?>assets/libs/sweetalert2/sweetalert2.min.js"></script>

<!-- DataTables -->
<link href="<?= base_url('assets/skote/dist/') ?>assets/libs/datatables.net-bs4/css/dataTables.bootstrap4.min.css" rel="stylesheet" type="text/css" />
<script src="<?= base_url('assets/skote/dist/') ?>assets/libs/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="<?= base_url('assets/skote/dist/') ?>assets/libs/datatables.net-bs4/js/dataTables.bootstrap4.min.js"></script>

<script>
    let qty = 1;
    $(document).ready(function() {
        $(".js-select2").select2();
    });

    $(document).on('select2:open', () => {
        document.querySelector('.select2-search__field').focus();
    });

    toastr.options = {
        "closeButton": true,
        "debug": false,
        "newestOnTop": false,
        "progressBar": true,
        "positionClass": "toast-top-right",
        "preventDuplicates": false,
        "onclick": null,
        "showDuration": 300,
        "hideDuration": 1000,
        "timeOut": 5000,
        "extendedTimeOut": 1000,
        "showEasing": "swing",
        "hideEasing": "linear",
        "showMethod": "fadeIn",
        "hideMethod": "fadeOut"
    }

    $(".input_spin").TouchSpin({
        verticalbuttons: !0,
        min: 1,
        max: 10000,
    });

    function loading_show() {
        Swal.fire({
            title: 'Loading ...',
            html: '<i style="font-size:25px;" class="fa fa-spinner fa-spin"></i>',
            allowOutsideClick: false,
            showConfirmButton: false,
        });
    }

    function loading_hide() {
        Swal.close();
    }

    function rupiah(x) {
        return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
    }

    function formatRupiah(angka) {
        let number_string = angka.replace(/[^,\d]/g, "").toString(),
            split = number_string.split(","),
            sisa = split[0].length % 3,
            rupiah = split[0].substr(0, sisa),
            ribuan = split[0].substr(sisa).match(/\d{3}/gi);

        if (ribuan) {
            separator = sisa ? "." : "";
            rupiah += separator + ribuan.join(".");
        }

        rupiah = split[1] != undefined ? rupiah + "," + split[1] : rupiah;
        return rupiah;
    }

    function angka(x) {
        if (!Number.isInteger(x)) {
            let data = x.replaceAll('.', '');
            data = parseInt(data);
            if (isNaN(data)) {
                return data = 0;
            }
            return data;
        } else {
            return angka;
        }
    }
</script>

<script>
    $('#tombol_cari_manual').on('click', function(e) {
        e.preventDefault();
        $('#modal_cari_manual').modal('show');
        setTimeout(() => {
            load_table();
        }, 500);
    });

    $('body').on('click', '#table_cari_barang .tombol_pilih_barang', function() {
        let barcode = $(this).data('barcode');
        $('.input_barcode').val(barcode);
        $('#modal_custom').modal('hide');

        $('.input_barcode').focus();
    });

    $('#tombol_tambah_quantity').on('click', function(e) {
        e.preventDefault();
        let quantity = $('.input_quantity').val();
        quantity = parseInt(quantity);

        $('.input_quantity').val(quantity + 1);
    });

    $('#tombol_kurang_quantity').on('click', function(e) {
        e.preventDefault();
        let quantity = $('.input_quantity').val();
        quantity = parseInt(quantity);

        if (quantity > 1) {
            $('.input_quantity').val(quantity - 1);
        }
    });

    $('#table_data tbody').on('change', '.quantity_produk', function(e) {
        e.preventDefault();
    });

    $('.input_barcode').on('keydown', function(e) {
        if (e.which === 13) {

            let barcode = $('.input_barcode').val();
            if (barcode != '') {
                get_produk();
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Perhatian',
                    text: 'masukkan kode barang',
                    timer: 2000,
                    showConfirmButton: false,
                })
            }

        } else if (e.which === 9) {
            $('.input_quantity').focus();
            e.preventDefault();
        }

    });

    $('.input_quantity').on('keydown', function(e) {
        if (e.which === 13) {

            let ee = jQuery.Event("keydown");
            ee.which = 13;
            $('.input_barcode').trigger(ee);

        } else if (e.which === 9) {
            if (e.shiftKey) {
                //Focus previous input
            } else {
                //Focus next input
                $('.input_bayar').focus();
                e.preventDefault();
            }
        }

    });
</script>

<script>
    $('.back_home').on('click', function(e) {
        e.preventDefault();
        let url = '<?= base_url('cabang/dashboard') ?>';
        window.open(url, '_self');
    });

    $(document).ready(function() {
        setInterval(() => {
            waktu();
        }, 1000);

        var last_pegawai = localStorage.getItem("last_pegawai");
        if (last_pegawai) {
            $('#select_pegawai').val(last_pegawai).change();
        }
    });

    function waktu() {
        var waktu = new Date();
        var jam = waktu.getHours();
        var menit = waktu.getMinutes();
        var detik = waktu.getSeconds();

        jam = jam < 10 ? '0' + jam : jam;
        menit = menit < 10 ? '0' + menit : menit;
        detik = detik < 10 ? '0' + detik : detik;

        var hasil = jam + ':' + menit + ':' + detik;
        $('#info_waktu').html(hasil);
    }

    $('body').on('keyup', '.rupiah', function() {
        $(this).val(formatRupiah(this.value));
    });

    function set_radio(dt, kelas) {
        $('.' + kelas).removeClass('active');
        $(dt).addClass('active');
    }

    function is_split(type) {
        if (type == 1) {
            $('.is_split').show(500);
        } else {
            $('.is_split').hide(500);
        }
    }

    function pilih_pegawai(dt) {
        var val = $(dt).val();
        localStorage.setItem("last_pegawai", val);
    }

    function show_modal_custom(obj) {
        if (obj.judul.indexOf('class="fa') != -1) {
            var judul = obj.judul;
        } else {
            var judul = '<i class="fa fa-info-circle mr-2"></i>' + obj.judul;
        }

        $('#modal_custom .modal-title').html(judul);
        $('#modal_custom .modal-body').html(obj.html);
        $("#modal_custom_size").removeClass();
        $("#modal_custom_size").addClass('modal-dialog');
        $("#modal_custom_size").addClass(obj.size);
        $('#modal_custom').modal('show');
    }

    function cari_manual() {
        $.ajax({
            type: "POST",
            url: "<?= base_url('cabang/kasir_barang/cari_produk') ?>",
            dataType: "JSON",
            data: {
                id: true,
            },
            beforeSend: function(res) {
                Swal.fire({
                    title: 'Loading ...',
                    html: '<i style="font-size:25px;" class="fa fa-spinner fa-spin"></i>',
                    allowOutsideClick: false,
                    showConfirmButton: false,
                });
            },
            complete: function(res) {
                Swal.close();
            },
            success: function(res) {
                if (res.status == 'success') {
                    show_modal_custom({
                        judul: 'List Produk',
                        html: res.html,
                        size: 'modal-xl',
                    });
                }
            }
        });
    }

    function get_produk() {
        $.ajax({
            type: "POST",
            url: "<?= base_url('cabang/kasir_barang/get_one') ?>",
            data: {
                barcode: $('#input_barcode').val(),
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
            error: function() {
                Swal.close();
            },
            success: function(res) {
                if (res.status == 'success') {
                    var qty = angka($('.input_quantity').val());

                    if (res.data == null) {
                        Swal.fire({
                            icon: 'warning',
                            title: 'kode barcode tidak ditemukan',
                            showConfirmButton: true,
                        }).then(() => {
                            $('.input_quantity').val('1');
                            $('#input_barcode').val('');
                        })
                    } else if (!qty || qty == null) {
                        Swal.fire({
                            icon: 'warning',
                            title: 'Stock tidak valid',
                            showConfirmButton: true,
                        }).then(() => {
                            $('.input_quantity').val('1');
                            $('#input_barcode').val('');
                        })
                    } else if (angka(res.data.stock) == 0) {
                        Swal.fire({
                            icon: 'warning',
                            title: 'Stock Habis',
                            showConfirmButton: true,
                        }).then(() => {
                            $('.input_quantity').val('1');
                            $('#input_barcode').val('');
                        })
                    } else if (angka(res.data.stock) < qty) {
                        Swal.fire({
                            icon: 'warning',
                            title: 'Stock Tersedia : ' + angka(res.data.stock),
                            showConfirmButton: true,
                        }).then(() => {
                            $('.input_quantity').val('1');
                            $('#input_barcode').val('');
                        })
                    } else {
                        Swal.close();
                        $('.input_quantity').val('1');
                        $('#input_barcode').val('');

                        $('.tr_default').remove();
                        generate_row(res.data, qty);
                    }
                }
            }
        });
    }

    function get_time() {
        return new Date().getTime();
    }

    function generate_row(data, qty) {
        var sub_total = angka(data.harga_jual) * qty;
        var id_unik = get_time();

        var html = `
            <tr class="tr_${id_unik}">
                <td class="tr_id" data-nilai="${data.id}">${data.nama}</td>
                <td>${data.barcode}</td>
                <td class="tr_qty" data-nilai="${qty}">${qty}</td>
                <td class="tr_harga" data-hargajual="${data.harga_jual}" data-hargamodal="${data.harga_modal}">${rupiah(data.harga_jual)}</td>
                <td class="tr_sub_total" data-nilai="${sub_total}">${rupiah(sub_total)}</td>
                <td>
                    <button onclick="remove_tr('tr_${id_unik}')" class="btn btn-outline-danger"><i class="bx bxs-trash"></i></button>
                </td>
            </tr>
        `;

        $('#table_data tbody').append(html);
        hitung_bayar();
    }

    function remove_tr(id_unik) {
        $('.' + id_unik).remove();
        hitung_bayar();
    }

    function hitung_bayar() {
        let total_nilai = 0;
        $('.tr_sub_total').each(function(i, obj) {
            let total = $(this).data('nilai');
            total_nilai += total;
        });

        $('.total_harga').html(rupiah(total_nilai));

        var total_bayar = angka($('#total_bayar').val())
        var dp = angka($('#total_dp').val());

        var cek_split = $('.cek_split.active').data('value');
        if (cek_split == 1) {
            var total_bayar_split = angka($('#total_bayar_split').val());
        } else {
            var total_bayar_split = 0;
        }

        var kembalian = (total_bayar + dp + total_bayar_split) - total_nilai;
        $('.input_bayar_banner').html(rupiah(kembalian));
    }

    function cek_bayar() {
        let total_nilai = 0;
        $('.tr_sub_total').each(function(i, obj) {
            let total = $(this).data('nilai');
            total_nilai += total;
        });

        var nominal_bayar = $('#total_bayar').val();
        var jenis_bayar_1 = $('#select_jenis_pembayaran').val();
        var input_bayar_banner = angka($('.input_bayar_banner').text());
        var cek_split = $('.cek_split.active').data('value');
        var jenis_bayar_2 = $('#select_jenis_pembayaran_2').val();

        if (!total_nilai) {
            Swal.fire({
                icon: 'warning',
                title: 'Silahkan lakukan transaksi terlebih dahulu',
                showConfirmButton: true,
            });
            throw false;
        } else if (!jenis_bayar_1) {
            Swal.fire({
                icon: 'warning',
                title: 'Jenis pembayaran belum dipilih',
                showConfirmButton: true,
            });
            throw false;
        } else if (!nominal_bayar) {
            Swal.fire({
                icon: 'warning',
                title: 'Isi nominal bayar',
                showConfirmButton: true,
            });
            throw false;
        } else if (input_bayar_banner < 0) {
            Swal.fire({
                icon: 'warning',
                title: 'Nominal bayar tidak sesuai',
                showConfirmButton: true,
            });
            throw false;
        } else if (cek_split == 1) {
            if (!jenis_bayar_2) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Jenis pembayaran kedua belum dipilih',
                    showConfirmButton: true,
                });
                throw false;
            }
        }

        var cekDulu = $('#table_data').html();
        $('#target_cek_dulu').html(`
            <table class="table table-bordered" id="table_dummy_cek">
                ${cekDulu}
            </table>
        `);
        $("#table_dummy_cek tr").each(function() {
            $(this).find("th:last").remove();
            $(this).find("td:last").remove();
            $(this).find("td.tr_id").removeClass('tr_id')
            $(this).find("td.tr_qty").removeClass('tr_qty')
            $(this).find("td.tr_harga").removeClass('tr_harga')
            $(this).find("td.tr_sub_total").removeClass('tr_sub_total')
        });
        $('#modal_custom_2').modal('show');
    }

    function do_submit(dt) {
        Swal.fire({
            title: 'Simpan Transaksi ?',
            text: 'transaksi tidak dapat dibatalkan kembali',
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: 'Ya',
            cancelButtonText: 'Batal',
            reverseButtons: true
        }).then((result) => {
            if (result.value) {

                var produk_id = [];
                $('.tr_id').each(function(i, obj) {
                    var nilai = $(this).data('nilai');
                    produk_id.push(nilai);
                });

                var produk_qty = [];
                $('.tr_qty').each(function(i, obj) {
                    var nilai = $(this).data('nilai');
                    produk_qty.push(nilai);
                });

                var produk_sub_total = [];
                $('.tr_sub_total').each(function(i, obj) {
                    var nilai = $(this).data('nilai');
                    produk_sub_total.push(nilai);
                });

                var produk_hargamodal = [];
                var produk_hargajual = [];
                $('.tr_harga').each(function(i, obj) {
                    var hargamodal = $(this).data('hargamodal');
                    var hargajual = $(this).data('hargajual');
                    produk_hargamodal.push(hargamodal);
                    produk_hargajual.push(hargajual);
                });

                let total_nilai = 0;
                $('.tr_sub_total').each(function(i, obj) {
                    let total = $(this).data('nilai');
                    total_nilai += total;
                });

                var select_pegawai = $('#select_pegawai').val();
                var total_dp = angka($('#total_dp').val());
                var total_bayar_split = angka($('#total_bayar_split').val());

                var nominal_bayar = angka($('#total_bayar').val());
                var jenis_bayar_1 = $('#select_jenis_pembayaran').val();
                var input_bayar_banner = angka($('.input_bayar_banner').text());
                var cek_split = $('.cek_split.active').data('value');
                var jenis_bayar_2 = $('#select_jenis_pembayaran_2').val();

                var form = new FormData(dt);
                form.append('nominal_bayar', nominal_bayar);
                form.append('jenis_bayar_1', jenis_bayar_1);
                form.append('kembalian', input_bayar_banner);
                form.append('cek_split', cek_split);
                form.append('jenis_bayar_2', jenis_bayar_2);

                form.append('select_pegawai', select_pegawai);
                form.append('total_dp', total_dp);
                form.append('total_bayar_split', total_bayar_split);
                form.append('total_nilai', total_nilai);

                form.append('produk_id', produk_id);
                form.append('produk_qty', produk_qty);
                form.append('produk_sub_total', produk_sub_total);
                form.append('produk_hargamodal', produk_hargamodal);
                form.append('produk_hargajual', produk_hargajual);

                $.ajax({
                    type: "POST",
                    url: "<?= base_url('cabang/kasir_barang/do_submit') ?>",
                    data: form,
                    dataType: "JSON",
                    contentType: false,
                    processData: false,
                    beforeSend: function(res) {
                        Swal.fire({
                            title: 'Loading ...',
                            html: '<i style="font-size:25px;" class="fa fa-spinner fa-spin"></i>',
                            allowOutsideClick: false,
                            showConfirmButton: false,
                        });
                    },
                    error: function(res) {
                        Swal.close();
                    },
                    success: function(res) {
                        if (res.status == 'success') {
                            $('#modal_custom_2').modal('hide');
                            Swal.fire({
                                    icon: 'success',
                                    title: 'Transaksi berhasil disimpan',
                                    showConfirmButton: true,
                                })
                                .then(() => {
                                    window.open(res.link)
                                    location.reload();
                                })
                        }
                    }
                });

            } else {
                return false;
            }
        })

    }
</script>

<!-- <script>
    $(document).ready(function() {
        $(document).on("contextmenu", function() {
            return false;
        });
    });

    $(document).keydown(function(e) {
        if (e.key == "F12" || (e.ctrlKey && e.shiftKey && e.key == "I")) {
            e.preventDefault();
        }
    });
</script> -->