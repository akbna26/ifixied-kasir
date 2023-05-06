<script>
    $(document).ready(function() {
        load_all('');
    });

    function load_all(id) {
        $.ajax({
            type: "POST",
            url: "<?= base_url('admin/note/load_card') ?>",
            data: {
                id: id
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
                    $('#list_card').html(res.html);
                }
            }
        });
    }

    function kelola_label() {
        $.ajax({
            type: "POST",
            url: "<?= base_url('admin/note/kelola_label') ?>",
            dataType: "JSON",
            data: {},
            success: function(res) {
                if (res.status == 'success') {
                    show_modal_custom({
                        judul: 'Kelola label',
                        html: res.html,
                        size: 'modal-lg',
                    });
                }
            }
        });
    }

    function tambah_label() {
        $.ajax({
            type: "POST",
            url: "<?= base_url('admin/note/tambah_label') ?>",
            dataType: "JSON",
            data: {},
            success: function(res) {
                if (res.status == 'success') {
                    show_modal_custom({
                        judul: 'Tambah label',
                        html: res.html,
                        size: 'modal-md',
                    });
                }
            }
        });
    }

    function tambah_catatan() {
        $.ajax({
            type: "POST",
            url: "<?= base_url('admin/note/tambah_note') ?>",
            dataType: "JSON",
            data: {},
            success: function(res) {
                if (res.status == 'success') {
                    show_modal_custom({
                        judul: 'Tambah Catatan',
                        html: res.html,
                        size: 'modal-lg',
                    });
                }
            }
        });
    }

    function edit_catatan(id) {
        $.ajax({
            type: "POST",
            url: "<?= base_url('admin/note/edit_note') ?>",
            dataType: "JSON",
            data: {
                id: id,
            },
            success: function(res) {
                if (res.status == 'success') {
                    show_modal_custom({
                        judul: 'Edit Catatan',
                        html: res.html,
                        size: 'modal-lg',
                    });
                }
            }
        });
    }

    function hapus_catatan(id, id_label) {
        Swal.fire({
            title: 'Hapus Catatan ?',
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: 'Ya',
            cancelButtonText: 'Batal',
            reverseButtons: true
        }).then((result) => {
            if (result.value) {
                $.ajax({
                    type: "POST",
                    url: "<?= base_url('admin/note/do_submit_catatan') ?>",
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
                                    load_all(id_label)
                                });
                        }
                    }
                });
            } else {
                return false;
            }
        })
    }

    $('.label_link').on('oncontextmenu', function(e) {
        e.preventDefault();
        alert("right clicked!");
    });
</script>