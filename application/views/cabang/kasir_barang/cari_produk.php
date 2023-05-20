<div class="table-responsive">
    <table class="mt-3 table table-striped" id="table_cari_barang" style="width: 100%;">
        <thead>
            <tr>
                <th class="fw-600">NO</th>
                <th class="fw-600">PRODUK</th>
                <th class="fw-600">KATEGORI</th>
                <th class="fw-600">BARCODE</th>
                <th class="fw-600">STOCK</th>
                <th class="fw-600">HARGA</th>
                <th class="fw-600" style="width: 250px;">AKSI</th>
            </tr>
        </thead>
        <tbody>
        </tbody>
    </table>
</div>

<script>
    $(document).ready(function() {
        load_table();
    });

    function load_table() {
        $('#table_cari_barang').DataTable({
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
                url: '<?= base_url('cabang/kasir_barang/table_cari_produk') ?>',
                type: 'GET',
                dataType: 'JSON',
                data: {},
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