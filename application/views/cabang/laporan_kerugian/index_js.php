<script>
    $(document).ready(function() {
        load_table();
    });

    function load_table() {
        $('#table_data').DataTable({
            destroy: true,
            processing: true,
            serverSide: true,
            ordering: false,
            autoWidth: false,
            lengthMenu: [
                [10, 25, 50, 100, -1],
                [10, 25, 50, 100, "All"]
            ],
            ajax: {
                url: '<?= base_url('cabang/laporan_kerugian/table') ?>',
                type: 'GET',
                dataType: 'JSON',
                data: {
                    tanggal: $('#select_tanggal').val(),
                },
            },
            order: [],
        })
    }
</script>