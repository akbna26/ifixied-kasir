<script>
    $(document).ready(function() {
        load_table();
    });

    function refresh_table() {
        setTimeout(() => {
            load_table();
        }, 500);
    }

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
                url: '<?= base_url(session('type') . '/servis_berat/table') ?>',
                type: 'GET',
                dataType: 'JSON',
                data: {
                    id_status: $('.select_status.active').data('val'),
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
            url: "<?= base_url(session('type') . '/servis_berat/tambah') ?>",
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
                        size: 'modal-xl',
                    });
                }
            }
        });
    }

    function ubah(id) {
        $.ajax({
            type: "POST",
            url: "<?= base_url(session('type') . '/servis_berat/ubah') ?>",
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
                        size: 'modal-xl',
                    });
                }
            }
        });
    }

    function hapus(id) {
        Swal.fire({
            title: 'Hapus Data Servis ?',
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: 'Ya',
            cancelButtonText: 'Batal',
            reverseButtons: true
        }).then((result) => {
            if (result.value) {
                $.ajax({
                    type: "POST",
                    url: "<?= base_url(session('type') . '/servis_berat/do_submit') ?>",
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
        $.ajax({
            type: "POST",
            url: "<?= base_url(session('type') . '/servis_berat/konfirmasi') ?>",
            dataType: "JSON",
            data: {
                id_servis: id,
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
                        judul: 'Konfirmasi Servis',
                        html: res.html,
                        size: 'modal-xl',
                    });
                }
            }
        });
    }
</script>