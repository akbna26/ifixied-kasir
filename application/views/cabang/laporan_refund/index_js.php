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
                url: '<?= base_url(session('type') . '/laporan_refund/table') ?>',
                type: 'GET',
                dataType: 'JSON',
                data: {
                    select_cabang: $('#select_cabang').val(),
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

    function detail(id) {
        $.ajax({
            type: "POST",
            url: "<?= base_url(session('type') . '/laporan_refund/detail') ?>",
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
                        judul: 'Detail <?= $title ?>',
                        html: res.html,
                        size: 'modal-xl',
                    });
                }
            }
        });
    }
</script>