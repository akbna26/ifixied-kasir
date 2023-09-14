<script>
    function cari_invoice() {
        var invoice = $('#invoice').val();
        if (!invoice) {
            Swal.fire({
                icon: 'warning',
                title: 'invoice kosong',
                showConfirmButton: true,
            });
            throw false;
        }

        $.ajax({
            type: "POST",
            url: "<?= base_url('cabang/refund_barang/cari_invoice') ?>",
            data: {
                invoice: invoice,
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
                    if (res.data.length > 0) {
                        Swal.close();
                        $('#invoice').prop('disabled', true);
                        $('#invoice').addClass('is-valid');
                        $('#cari_invoice').hide();
                        $('#ganti_invoice').show();
                        toastr.success('invoice berhasil ditemukan');

                        var html = '<option value=""></option>';
                        $.map(res.data, function(e, i) {
                            html += `<option data-hargamodal="${e.harga_modal}" data-hargajual="${e.harga_jual}" value="${e.id}">${e.barcode} - ${e.nama}</option>`
                        });
                        $('#select_barang').html(html);

                    } else {
                        Swal.fire({
                            icon: 'warning',
                            title: 'transaksi tidak ditemukan',
                            text: 'nomer invoice : ' + invoice,
                            showConfirmButton: true,
                        });
                    }
                }
            }
        });
    }

    function reload_halaman() {
        Swal.fire({
            title: 'Ganti Invoice ?',
            text: 'halaman akan dimuat ulang',
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: 'Ya',
            cancelButtonText: 'Batal',
            reverseButtons: true
        }).then((result) => {
            if (result.value) {
                location.reload();
            }
        })
    }

    function pilih_barang(dt) {
        $('.tr_hidden').show();
        var harga_modal = $('option:selected', dt).data('hargamodal');
        var harga_jual = $('option:selected', dt).data('hargajual');
        $('#harga_modal').html(formatRupiah(harga_modal + ''));
        $('#harga_jual').html(formatRupiah(harga_jual + ''));

        // reset pilihan
        $('#status_klaim').val('').change();
        $('#barang_pengganti').val('').change();
        $('#nilai_refund').val('');
        $('#tr_refund').hide()
        $('#tr_pengganti').hide();
    }

    function pilih_refund(dt) {
        var id = $(dt).val();
        if (id == 3 || id == 4) {
            $('#tr_refund').show()
            $('#tr_pengganti').hide();

            var harga_jual = $('option:selected', $('#select_barang')).data('hargajual');
            $('#nilai_refund').val(formatRupiah(harga_jual + ''));
        } else {
            $('#tr_pengganti').show()
            $('#tr_refund').hide();
        }
    }

    function tambah_produk() {
        var detik = new Date().getTime();
        var select_barang = $('#select_barang').val();
        var harga_modal = angka($('#harga_modal').html());
        var harga_jual = angka($('#harga_jual').html());
        var total_qty = angka($('#total_qty').val());
        var status_klaim = $('#status_klaim').val();

        var nilai_refund = angka($('#nilai_refund').val());
        var barang_pengganti = $('#barang_pengganti').val();
        var pembayaran = $('.btn_pembayaran.active').data('nilai')

        var nama_barang = $('option:selected', $('#select_barang')).text()
        var nama_klaim = $('option:selected', $('#status_klaim')).text()
        var nama_pengganti = $('option:selected', $('#barang_pengganti')).text()

        if (!select_barang || !harga_modal || !total_qty || !status_klaim) {
            Swal.fire({
                icon: 'warning',
                title: 'isian tidak boleh kosong',
                showConfirmButton: true,
            });
            throw false;
        } else {
            if (status_klaim == 3 || status_klaim == 4) {
                if (!nilai_refund) {
                    Swal.fire({
                        icon: 'warning',
                        title: 'isian tidak boleh kosong',
                        showConfirmButton: true,
                    });
                    throw false;
                }
                if (pembayaran == undefined) {
                    Swal.fire({
                        icon: 'warning',
                        title: 'pilih jenis pembayaran',
                        text: 'cash atau debit',
                        showConfirmButton: true,
                    });
                    throw false;
                }
                barang_pengganti = '';
                nama_pengganti = '';
            } else {
                if (!barang_pengganti) {
                    Swal.fire({
                        icon: 'warning',
                        title: 'isian tidak boleh kosong',
                        showConfirmButton: true,
                    });
                    throw false;
                }
                nilai_refund = '';
                pembayaran = '';
            }
        }

        var html = `
            <tr id="tr_${select_barang}_${detik}">
                <td class="td_barang" data-nilai="${select_barang}">${nama_barang}</td>
                <td class="td_hargajual" data-nilai="${harga_jual}">${formatRupiah(harga_jual+'')}</td>
                <td style="display:none;" class="td_hargamodal" data-nilai="${harga_modal}">${formatRupiah(harga_modal+'')}</td>
                <td class="td_qty" data-nilai="${total_qty}">${formatRupiah(total_qty+'')}</td>
                <td class="td_klaim" data-nilai="${status_klaim}">${nama_klaim}</td>
                <td class="td_refund" data-pembayaran="${pembayaran}" data-nilai="${nilai_refund}">${formatRupiah(nilai_refund+'')}</td>
                <td class="td_pengganti" data-nilai="${barang_pengganti}">${nama_pengganti}</td>
                <td>
                    <button onclick="$('#tr_${select_barang}_${detik}').remove();" class="btn btn-outline-danger"><i class="fa fa-trash-alt"></i></button>
                </td>
            </tr>
        `;

        $('#tbody_daftar').append(html);

        $('#select_barang').val('').change();
        $('#status_klaim').val('').change();
        $('#barang_pengganti').val('').change();
        $('#total_qty').val('');
        $('#nilai_refund').val('');
        $('.tr_hidden').hide();
        $('#tr_refund').hide();
        $('#tr_pengganti').hide();
        $('.btn_pembayaran').removeClass('active');
        toastr.success('barang berhasil ditambahkan');
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
            return x;
        }
    }

    function do_submit(dt) {
        Swal.fire({
            title: 'Simpan Transaksi Refund ?',
            text: 'transaksi tidak dapat dibatalkan kembali',
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: 'Ya',
            cancelButtonText: 'Batal',
            reverseButtons: true
        }).then((result) => {
            if (result.value) {

                var id_barang = [];
                $('.td_barang').each(function(i, obj) {
                    var nilai = $(this).data('nilai');
                    id_barang.push(nilai);
                });

                if (id_barang.length < 1) {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Belum ada data',
                        showConfirmButton: true,
                    });
                    throw false;
                }

                var harga_modal = [];
                $('.td_hargamodal').each(function(i, obj) {
                    var nilai = $(this).data('nilai');
                    harga_modal.push(nilai);
                });

                var harga_jual = [];
                $('.td_hargajual').each(function(i, obj) {
                    var nilai = $(this).data('nilai');
                    harga_jual.push(nilai);
                });

                var qty = [];
                $('.td_qty').each(function(i, obj) {
                    var nilai = $(this).data('nilai');
                    qty.push(nilai);
                });

                var id_klaim = [];
                $('.td_klaim').each(function(i, obj) {
                    var nilai = $(this).data('nilai');
                    id_klaim.push(nilai);
                });

                var id_refund = [];
                var pembayaran = [];
                $('.td_refund').each(function(i, obj) {
                    var nilai = $(this).data('nilai');
                    id_refund.push(nilai);

                    var jenis_bayar = $(this).data('pembayaran');
                    pembayaran.push(jenis_bayar);
                });

                var id_pengganti = [];
                $('.td_pengganti').each(function(i, obj) {
                    var nilai = $(this).data('nilai');
                    id_pengganti.push(nilai);
                });

                var invoice = $('#invoice').val();
                var select_pegawai = $('#select_pegawai').val();

                var form = new FormData(dt);
                form.append('invoice', invoice);
                form.append('id_barang', id_barang);
                form.append('harga_modal', harga_modal);
                form.append('harga_jual', harga_jual);
                form.append('qty', qty);
                form.append('id_klaim', id_klaim);
                form.append('nilai_refund', id_refund);
                form.append('id_pengganti', id_pengganti);
                form.append('pembayaran', pembayaran);
                form.append('id_pegawai', select_pegawai);

                $.ajax({
                    type: "POST",
                    url: "<?= base_url('cabang/refund_barang/do_submit') ?>",
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
                            $('#modal_custom').modal('hide');
                            Swal.fire({
                                    icon: 'success',
                                    title: 'Transaksi berhasil disimpan',
                                    showConfirmButton: true,
                                })
                                .then(() => {
                                    window.open(res.link);
                                    location.href="<?= base_url('cabang/refund_barang') ?>";
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