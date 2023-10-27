<script>
    $(document).ready(function() {
        load_table();
    });

    function load_table() {
        $('#table_data').DataTable({
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
                url: '<?= base_url(session('type') . '/retur_barang/table') ?>',
                type: 'GET',
                dataType: 'JSON',
                data: {
                    filter_jenis: $('#filter_jenis').val(),
                },
            },
            order: [],
            columnDefs: [{
                targets: [0, -1],
                className: 'text-center',
                orderable: false,
            }],
        })
    }

    function tambah() {
        $.ajax({
            type: "POST",
            url: "<?= base_url('cabang/retur_barang/tambah') ?>",
            dataType: "JSON",
            data: {},
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
                        judul: 'Tambah <?= $title ?>',
                        html: res.html,
                        size: 'modal-lg',
                    });
                }
            }
        });
    }

    function ubah(id) {
        $.ajax({
            type: "POST",
            url: "<?= base_url('cabang/retur_barang/ubah') ?>",
            dataType: "JSON",
            data: {
                id: id,
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
                        judul: 'Ubah <?= $title ?>',
                        html: res.html,
                        size: 'modal-lg',
                    });
                }
            }
        });
    }

    function hapus(id) {
        Swal.fire({
            title: 'Hapus Retur Barang ?',
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: 'Ya',
            cancelButtonText: 'Batal',
            reverseButtons: true
        }).then((result) => {
            if (result.value) {
                $.ajax({
                    type: "POST",
                    url: "<?= base_url('cabang/retur_barang/do_submit') ?>",
                    data: {
                        hapus: true,
                        id: id,
                    },
                    dataType: "JSON",
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
                            Swal.fire({
                                    icon: 'success',
                                    title: 'Berhasil dihapus',
                                    showConfirmButton: true,
                                })
                                .then(() => {
                                    $('#table_data').DataTable().ajax.reload();
                                });
                        }
                    }
                });
            } else {
                return false;
            }
        })
    }

    function detail(id) {
        $.ajax({
            type: "POST",
            url: "<?= base_url(session('type') . '/retur_barang/detail') ?>",
            dataType: "JSON",
            data: {
                id: id,
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
                        judul: 'Detail <?= $title ?>',
                        html: res.html,
                        size: 'modal-xl',
                    });
                }
            }
        });
    }

    function verifikasi(id) {
        $.ajax({
            type: "POST",
            url: "<?= base_url(session('type') . '/retur_barang/verifikasi') ?>",
            dataType: "JSON",
            data: {
                id: id,
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
                        judul: 'Verifikasi <?= $title ?>',
                        html: res.html,
                        size: 'modal-lg',
                    });
                }
            }
        });
    }

    function konfirmasi_tiba(id) {
        Swal.fire({
            title: 'Konfirmasi barang sampai ?',
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: 'Ya',
            cancelButtonText: 'Batal',
            reverseButtons: true
        }).then((result) => {
            if (result.value) {
                $.ajax({
                    type: "POST",
                    url: "<?= base_url('gudang/retur_barang/do_konfirmasi_tiba') ?>",
                    data: {
                        id: id,
                    },
                    dataType: "JSON",
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
                            Swal.fire({
                                    icon: 'success',
                                    title: 'Berhasil disimpan',
                                    showConfirmButton: true,
                                })
                                .then(() => {
                                    $('#table_data').DataTable().ajax.reload();
                                });
                        }
                    }
                });
            } else {
                return false;
            }
        })
    }
</script>