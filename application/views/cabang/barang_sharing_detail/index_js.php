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
                url: '<?= base_url('cabang/barang_sharing_detail/table') ?>',
                type: 'GET',
                dataType: 'JSON',
                data: {
                    id_sharing:'<?= encode_id($id) ?>'
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
</script>