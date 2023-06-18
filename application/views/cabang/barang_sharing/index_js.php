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
                url: '<?= base_url('cabang/barang_sharing/table') ?>',
                type: 'GET',
                dataType: 'JSON',
                data: {},
            },
            initComplete: function() {
                $('[data-toggle="tooltip"]').tooltip()
            },
            order: [],
            columnDefs: [{
                targets: [0, 3, 4, -1],
                className: 'text-center',
                orderable: false,
            }],
        })
    }
</script>