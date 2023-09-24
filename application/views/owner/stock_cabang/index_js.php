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
                url: '<?= base_url($this->type . '/daftar_cabang/table_stock_cabang') ?>',
                type: 'GET',
                dataType: 'JSON',
                data: {
                    id_kategori: $('#id_kategori').val(),
                    id_cabang: '<?= encode_id($id_cabang) ?>',
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
</script>