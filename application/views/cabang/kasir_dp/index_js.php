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
                url: '<?= base_url(session('type') . '/kasir_dp/table') ?>',
                type: 'GET',
                dataType: 'JSON',
                data: {},
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
            url: "<?= base_url('cabang/kasir_dp/tambah') ?>",
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

    function form_refund(id) {
        $.ajax({
            type: "POST",
            url: "<?= base_url('admin/laporan_dp/form_refund') ?>",
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
                        judul: 'Refund DP',
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
            url: "<?= base_url('cabang/kasir_dp/ubah') ?>",
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
            title: 'Hapus Informasi ?',
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: 'Ya',
            cancelButtonText: 'Batal',
            reverseButtons: true
        }).then((result) => {
            if (result.value) {
                $.ajax({
                    type: "POST",
                    url: "<?= base_url('cabang/kasir_dp/do_submit') ?>",
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

    function konfirmasi(id) {
        Swal.fire({
            title: 'Konfirmasi Transaksi ?',
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: 'Ya',
            cancelButtonText: 'Batal',
            reverseButtons: true
        }).then((result) => {
            if (result.value) {
                $.ajax({
                    type: "POST",
                    url: "<?= base_url('admin/laporan_dp/do_konfirmasi') ?>",
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

    function cancel(id) {
        Swal.fire({
            title: 'Batalkan Transaksi ?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Ya',
            cancelButtonText: 'Batal',
            reverseButtons: true
        }).then((result) => {
            if (result.value) {
                $.ajax({
                    type: "POST",
                    url: "<?= base_url('admin/laporan_dp/do_cancel') ?>",
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

    function refund(id) {
        Swal.fire({
            title: 'Konfirmasi Refund DP ?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Ya',
            cancelButtonText: 'Batal',
            reverseButtons: true
        }).then((result) => {
            if (result.value) {
                $.ajax({
                    type: "POST",
                    url: "<?= base_url('admin/laporan_dp/do_refund') ?>",
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