<script>
    $(document).ready(function() {
        load_table('<?= encode_id(2) ?>');
    });

    var otoritas = '<?= encode_id(2) ?>';

    function load_table(jenis) {
        otoritas = jenis;
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
                url: '<?= base_url('admin/data_user/table') ?>',
                type: 'GET',
                dataType: 'JSON',
                data: {
                    jenis: jenis,
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
            url: "<?= base_url('admin/data_user/tambah') ?>",
            dataType: "JSON",
            data: {
                otoritas: otoritas,
            },
            success: function(res) {
                if (res.status == 'success') {
                    show_modal_custom({
                        judul: 'Tambah Data',
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
            url: "<?= base_url('admin/data_user/ubah') ?>",
            dataType: "JSON",
            data: {
                id: id,
                otoritas: otoritas,
            },
            success: function(res) {
                if (res.status == 'success') {
                    show_modal_custom({
                        judul: 'Ubah Data',
                        html: res.html,
                        size: 'modal-xl',
                    });
                }
            }
        });
    };

    function hapus(id) {
        Swal.fire({
            title: 'Hapus Akun ?',
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: 'Ya',
            cancelButtonText: 'Batal',
            reverseButtons: true
        }).then((result) => {
            if (result.value) {
                $.ajax({
                    type: "POST",
                    url: '<?= base_url('admin/data_user/do_submit') ?>',
                    data: {
                        id: id,
                        hapus: true,
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
</script>