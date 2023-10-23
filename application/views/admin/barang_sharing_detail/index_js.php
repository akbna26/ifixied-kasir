<script>
    const ID_SHARING = '<?= encode_id($id) ?>';

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
                url: '<?= base_url($this->type . '/barang_sharing_detail/table') ?>',
                type: 'GET',
                dataType: 'JSON',
                data: {
                    id_sharing: '<?= encode_id($id) ?>'
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
            url: "<?= base_url($this->type . '/barang_sharing_detail/tambah') ?>",
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
            url: "<?= base_url($this->type . '/barang_sharing_detail/ubah') ?>",
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
            title: 'Hapus Dari List Detail ?',
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: 'Ya',
            cancelButtonText: 'Batal',
            reverseButtons: true
        }).then((result) => {
            if (result.value) {
                $.ajax({
                    type: "POST",
                    url: "<?= base_url($this->type . '/barang_sharing_detail/do_submit') ?>",
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

    function cek_disable(dt, id) {
        if ($(dt).is(':checked')) {
            $('#input_id_' + id).prop('disabled', false);
            $('#input_id_' + id).focus();
        } else {
            $('#input_id_' + id).prop('disabled', true);
            $('#input_id_' + id).val('');
        }
    }

    function cek_max(dt, id) {
        var value = parseInt($(dt).val());
        var max = parseInt($(dt).data('max'));

        if (value > max) {
            Swal.fire({
                    icon: 'error',
                    title: 'stock melebihi batas maksimal',
                    text: `stock sekarang ${max}, di input ${value}`,
                    showConfirmButton: true,
                })
                .then(() => {
                    $('#input_id_' + id).val('');
                    throw false;
                })
        }
    }
</script>