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
                url: '<?= base_url('admin/laporan_transaksi/table') ?>',
                type: 'GET',
                dataType: 'JSON',
                data: {
                    id_cabang: $('#id_cabang').val(),
                    select_tahun: $('#select_tahun').val(),
                    select_bulan: $('#select_bulan').val(),
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