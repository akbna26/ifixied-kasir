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

<!-- loading overlay -->
<script src="https://cdn.jsdelivr.net/npm/gasparesganga-jquery-loading-overlay@2.1.7/dist/loadingoverlay.min.js"></script>

<script>
    let qty = 1;
    let get_row = []
    $(document).ready(function() {
        $(".js-select2").select2();
    });

    $(document).on('select2:open', () => {
        document.querySelector('.select2-search__field').focus();
    });

    const URL = "";
    const MENU = "";

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

    function loading_show(elemen = 'body') {
        $(elemen).LoadingOverlay("show", {
            background: "rgba(255, 255, 255, .7)"
        });
    }

    function loading_hide(elemen = 'body') {
        $(elemen).LoadingOverlay("hide");
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

    function load_table() {
        $('#table_cari_barang').DataTable({
            destroy: true,
            processing: true,
            serverSide: true,
            ordering: true,
            autoWidth: false,
            lengthMenu: [
                [10, 25, 50, 100, -1],
                [10, 25, 50, 100, "All"]
            ],
            ajax: {
                url: URL + 'get_data_barang',
                type: 'GET',
                dataType: 'JSON',
                beforeSend: function() {},
                complete: function(e) {},
                error: function(e) {},
                data: {
                    menu: MENU,
                }
            },
            drawCallback: function(res) {

            },
            order: [],
            columnDefs: [{
                    targets: [0, -1],
                    className: 'text-center'
                },
                {
                    targets: [0, -1],
                    orderable: false,
                }
            ],
        })

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
    function removeItemAll(arr, value) {
        var i = 0;
        while (i < arr.length) {
            if (arr[i] === value) {
                arr.splice(i, 1);
            } else {
                ++i;
            }
        }
        return arr;
    }

    $('#table_data tbody').on('click', '.hapus_barang', function(e) {
        e.preventDefault();

        // $(this).parents('.tr_parent').remove();
        var row = $(this).closest("tr").data('id');
        //         Array.prototype.remove = function(el) {
        //            return this.splice(this.indexOf(el), 1);
        //        }

        var i = 0;
        while (i < get_row.length) {
            if (get_row[i] == row) {
                get_row.splice(i, 1);
            } else {
                ++i;
            }
        }

        $(`.tr_parent[data-id=${row}]`).remove();

        //removeItemAll(get_row, row);
        //console.log(get_row);

        //get_row.remove(row);






        total_produk();

        let ii = 0;
        $('.sub_total').each(function(i, obj) {
            ii++;
        });

        if (ii == 0) {
            let html = `
            <tr class="text-center tr_default">
                <td colspan="7">belum ada data</td>
            </tr>
            `;

            $('#table_data tbody').append(html);
        }


    });
</script>

<script>
    $('#tombol_cari_manual').on('click', function(e) {
        e.preventDefault();
        $('#modal_cari_manual').modal('show');
        setTimeout(() => {
            load_table();
        }, 500);
    });

    $('#table_cari_barang tbody').on('click', '.tombol_pilih_barang', function() {
        let barcode = $(this).data('barcode');
        $('.input_barcode').val(barcode);
        $('#modal_cari_manual').modal('hide');

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

    //    $(`#table_data tbody`).on('click', '#tombol_kurang_quantity', function(e) {
    //        e.preventDefault();
    //        
    ////        let hitung = (parseInt($(`#table_data tbody`).closest("tr").find("input.quantity_produk").val()) + parseInt(quantity)) 
    ////                            
    ////        $(`.tr_parent[data-id=${row.id}]`).closest("tr").find("input.quantity_produk").attr('value', hitung)
    ////        $(`.tr_parent[data-id=${row.id}]`).closest("tr").find("input.quantity_produk").val(hitung)
    ////                            
    //        console.log($(`#table_data tbody .tr_parent`).closest("tr").find("input.quantity_produk").val())
    //    })

    $('#table_data tbody').on('change', '.quantity_produk', function(e) {
        e.preventDefault();
        let value = $(this).val();
        let diskon = $(this).data('diskon');
        let harga_satuan = $(this).parents('.tr_parent').children('td:nth-child(4)').html();

        harga_satuan = angka(harga_satuan);

        diskon = diskon != null ? parseFloat(diskon) : 0;
        let sub_total = 0
        if (value >= $(this).data('min_beli_2') && value < $(this).data('min_beli_3')) {
            sub_total = (value * $(this).data('harga_jual2')) - (value * $(this).data('harga_jual2') * (diskon / 100));
            $(this).parents('.tr_parent').children('td:nth-child(4)').html(rupiah($(this).data('harga_jual2')));
        } else if (value >= $(this).data('min_beli_2')) {
            sub_total = (value * $(this).data('harga_jual3')) - (value * $(this).data('harga_jual3') * (diskon / 100));
            $(this).parents('.tr_parent').children('td:nth-child(4)').html(rupiah($(this).data('harga_jual3')));
        } else {
            sub_total = (value * harga_satuan) - (value * harga_satuan * (diskon / 100));
            $(this).parents('.tr_parent').children('td:nth-child(4)').html(rupiah($(this).data('harga_jual1')));
        }

        $(this).parents('.tr_parent').children('td:nth-child(6)').html(rupiah(sub_total));
        total_produk();
    });

    $('.input_bayar').on('keyup', function(e) {
        e.preventDefault();

        let value = $(this).val();
        $(this).val(formatRupiah(value));

        let total_data = 0;
        $('.sub_total').each(function(i, obj) {
            let total = $(this).html();
            total = angka(total);
            total_data += total;
        });

        let kembalian = angka(value) - total_data;
        $('.kembali').val(rupiah(kembalian));
        $('.input_bayar_banner').html(rupiah(kembalian));
    });

    $('#tombol_bayar').on('click', function(e) {
        e.preventDefault();
        let kembali = angka($('.kembali').val());

        let barang = $("input[name='id_produk[]']")
            .map(function() {
                return $(this).val();
            }).get();

        if (barang.length == 0) {
            Swal.fire({
                icon: 'warning',
                title: 'Gagal',
                text: 'Belum ada transaksi',
                timer: 2000,
                showConfirmButton: false,
            })
        } else if (kembali < 0) {
            Swal.fire({
                icon: 'error',
                title: 'Gagal',
                text: 'Pembayaran kurang',
                timer: 2000,
                showConfirmButton: false,
            })
        } else {
            Swal.fire({
                title: 'Lakukan Pembayaran ?',
                text: "transaksi akan diproses",
                showCancelButton: true,
                confirmButtonText: 'Ya',
                cancelButtonText: 'Batal',
                reverseButtons: true
            }).then((result) => {
                if (result.value) {

                    submit_bayar();

                } else {
                    return false;
                }
            })
        }
    });

    $('.input_barcode').on('keydown', function(e) {
        if (e.which === 13) {

            let barcode = $('.input_barcode').val();
            if (barcode != '') {

                //var ids = $('#table_data tbody').closest('tr').find('.quantity_produk');


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

    $('.input_bayar').on('keydown', function(e) {
        if (e.which === 13) {
            $('#tombol_bayar').trigger('click');
            e.preventDefault();
        } else if (e.which === 9) {
            if (e.shiftKey) {
                //Focus previous input
                $('.input_quantity').focus();
                e.preventDefault();
            } else {
                //Focus next input
            }
        }
    });
</script>

<script>
    let total_item = {};

    let jumlah_duplikat = {}


    function get_produk() {

        let barcode = $('.input_barcode').val();
        let quantity = $('.input_quantity').val();

        let data = new FormData();
        data.append('menu', MENU);
        data.append('barcode', barcode);

        $.ajax({
            url: URL + 'get_produk',
            type: "POST",
            data: data,
            dataType: 'JSON',
            processData: false,
            contentType: false,
            beforeSend: function() {
                // console.log('sedang menghapus');
            },
            complete: function() {
                // console.log('Berhasil');
            },
            error: function(e) {
                console.log(e);
                toastr.error('gagal, terjadi kesalahan');
            },
            success: function(data) {
                if (data.status == 'success') {

                    if (data.stock < quantity) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Perhatian',
                            text: 'Sisa Stock ' + data.data.merk_nama + ' ' + data.stock + ' ' + data.data.satuan,
                            // timer: 2000,
                            // showConfirmButton: false,
                        })
                    } else {
                        $('.input_quantity').val(1);
                        $('.input_barcode').val('');
                        $('.input_barcode').focus();

                        let row = data.data;
                        let diskon = data.data.diskon != null ? parseFloat(data.data.diskon) : 0;
                        let sub_total = (quantity * row.harga_jual1) - (quantity * row.harga_jual1 * (diskon / 100));


                        get_row.push(row.id)
                        let ttl = 1
                        $.each(get_row, function(idx, val) {
                            if (val == row.id) {
                                total_item[row.id] = ttl++
                            }
                        })

                        if (total_item[row.id] > 1) {
                            //let quantity = $('.input_quantity').val();
                            //quantity = parseInt(quantity);

                            //let hitung = (parseInt(total_item[row.id]) + parseInt(quantity)) - 1
                            let hitung = (parseInt($(`.tr_parent[data-id=${row.id}]`).closest("tr").find("input.quantity_produk").val()) + parseInt(quantity))

                            $(`.tr_parent[data-id=${row.id}]`).closest("tr").find("input.quantity_produk").attr('value', hitung)
                            $(`.tr_parent[data-id=${row.id}]`).closest("tr").find("input.quantity_produk").val(hitung)

                            var sub_totals = (hitung * row.harga_jual1) - (hitung * row.harga_jual1 * (diskon / 100))

                            $(`.tr_parent[data-id=${row.id}]`).closest("tr").find("td.sub_total").text(sub_totals)

                            total_produk();
                        } else {


                            let html = `                       
                            <tr class="tr_parent" data-id="${row.id}">
                                <td>${row.merk_nama}</td>
                                <td class="text-center">
                                    <input name="id_produk[]" type="hidden" value="${row.id}" />
                                    <input class="sub_totals" name="sub_total[]" type="hidden" value="${sub_total}" />
                                    <input name="harga[]" type="hidden" class="harga" value="${row.harga_jual1}" />
                                    <input name="diskon[]" type="hidden" value="${row.diskon}" />
                                    <input name="harga_beli[]" type="hidden" value="${row.harga_beli}" />
                                    <input name="quantity[]" data-id-val="${row.id}" data-harga_jual1="${row.harga_jual1}" data-harga_jual2="${row.harga_jual2}" data-harga_jual3="${row.harga_jual3}" data-min_beli_2="${row.min_beli_2}" data-min_beli_3="${row.min_beli_3}" data-diskon="${row.diskon ? row.diskon : 0}" min="1" type="number" class="form-control quantity_produk input_spin" value="${quantity}" />
                                </td>
                                <td>${row.satuan}</td>
                                <td class="text-right"  class="harga">${rupiah(row.harga_jual1)}</td>
                                <td class="text-center">
                                    ${row.diskon ? row.diskon + ' %' : 0}
                                </td>
                                <td class="text-right sub_total">${rupiah(sub_total)}</td>
                                <td class="text-center text-danger">                                  
                                    <a href="javascript:void(0);" class="text-danger hapus_barang" data-toggle="tooltip" data-placement="top" title="" data-original-title="Hapus"><i class="mdi mdi-trash-can font-size-18"></i></a>
                                </td>
                            </tr>
                        `;

                            $('#table_data .tr_default').remove();


                            $('#table_data tbody').append(html);
                            total_produk();
                        }


                        $(".input_spin").TouchSpin({
                            verticalbuttons: !0,
                            min: 1,
                            max: 10000,
                        });
                    }

                } else {
                    $('.input_barcode').val('');
                    $('row.input_barcode').focus();
                    toastr.error(data.msg);
                }
            },
        });
    }

    function total_produk() {
        let total_data = 0;
        $('.sub_total').each(function(i, obj) {
            let total = $(this).html();
            total = angka(total);
            total_data += total;
        });

        let bayar = $('.input_bayar').val();
        let kembalian = angka(bayar) - total_data
        $('.kembali').val(rupiah(kembalian));
        $('.input_bayar_banner').html(rupiah(kembalian));

        total_harga_produk = total_data;
        $('.total_harga').html(rupiah(total_data));
    }

    function submit_bayar() {
        let barang = $("input[name='id_produk[]']")
            .map(function() {
                return $(this).val();
            }).get();

        let quantity = $("input[name='quantity[]']")
            .map(function() {
                return $(this).val();
            }).get();

        let sub_total = $("input[name='sub_total[]']")
            .map(function() {
                return $(this).val();
            }).get();

        let harga = $("input[name='harga[]']")
            .map(function() {
                return $(this).val();
            }).get();

        let diskon = $("input[name='diskon[]']")
            .map(function() {
                return $(this).val();
            }).get();

        let harga_beli = $("input[name='harga_beli[]']")
            .map(function() {
                return $(this).val();
            }).get();

        let bayar = $('.input_bayar').val();
        let member = $('#select_member').val();
        let kembali = $('.kembali').val();
        let metode = $('select[name=metode]').val();

        let data = new FormData();
        data.append('menu', MENU);
        data.append('barang', barang);
        data.append('quantity', quantity);
        data.append('sub_total', sub_total);
        data.append('harga', harga);
        data.append('diskon', diskon);
        data.append('bayar', bayar);
        data.append('member', member);
        data.append('kembali', kembali);
        data.append('metode', metode);
        data.append('harga_beli', harga_beli);

        $.ajax({
            url: URL + 'submit_bayar',
            type: "POST",
            data: data,
            dataType: 'JSON',
            processData: false,
            contentType: false,
            beforeSend: function() {
                // console.log('sedang menghapus');
                loading_show();
            },
            complete: function() {
                loading_hide();
                // console.log('Berhasil');
            },
            error: function(e) {
                console.log(e);
                loading_hide();
                toastr.error('gagal, terjadi kesalahan');
            },
            success: function(data) {
                if (data.status == 'success') {
                    // window.open(URL + 'nota/' + MENU + '/' + data.id_transaksi, '_blank');
                    toastr.success('Transaksi berhasil');
                    setTimeout(() => {
                        location.reload();
                    }, 700);
                } else {
                    toastr.error(data.msg);
                }
            },
        });

    }
</script>

<script>
    $('.back_home').on('click', function(e) {
        e.preventDefault();
        let url = '<?= base_url('cabang/dashboard') ?>';
        window.open(url, '_self');
    });

    $('body').on('click', '.tombol_gagal', function(e) {
        e.preventDefault();
        Swal.fire({
            icon: 'warning',
            title: 'Perhatian',
            text: 'stok tidak tersedia',
            timer: 2000,
            showConfirmButton: false,
        })
    });
</script>