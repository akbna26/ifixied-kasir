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
                url: '<?= base_url(session('type') . '/barang/table_stock_cabang') ?>',
                type: 'GET',
                dataType: 'JSON',
                data: {
                    id_kategori: $('#id_kategori').val(),
                    id_cabang: $('#id_cabang').val(),
                },
            },
            initComplete: function() {
                $('[data-toggle="tooltip"]').tooltip()
            },
            order: [],
            columnDefs: [{
                    targets: [0, -1],
                    className: 'text-center',
                    orderable: false,
                },
                {
                    targets: [2],
                    className: 'text-center',
                },
            ],
        })
    }

    function sharing(id) {
        $.ajax({
            type: "POST",
            url: "<?= base_url('admin/barang/sharing') ?>",
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
                        judul: 'Sharing ke cabang lain',
                        html: res.html,
                        size: 'modal-lg',
                    });
                }
            }
        });
    }
</script>