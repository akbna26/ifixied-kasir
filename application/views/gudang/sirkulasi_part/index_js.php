<script>
    $(document).ready(function() {
        load_table();
    });

    function generate_total(arr) {
        $.ajax({
            type: "POST",
            url: '<?= base_url($this->type . '/sirkulasi_part/generate_total') ?>',
            data: arr,
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
                    $('#card_total_modal').html(res.total_modal == '' ? 0 : res.total_modal)
                    $('#card_total_kredit').html(res.total_kredit == '' ? 0 : res.total_kredit)
                    $('#card_total_debit').html(res.total_debit == '' ? 0 : res.total_debit)
                    $('#card_total').html(res.total == '' ? 0 : res.total)
                }
            }
        });
    }

    function load_table() {
        var arr = {
            filter_cabang: $('#filter_cabang').val(),
            filter_tanggal: $('#filter_tanggal').val(),
        }

        generate_total(arr);

        $('#table_data').DataTable({
            destroy: true,
            processing: true,
            serverSide: true,
            ordering: false,
            autoWidth: false,
            lengthMenu: [
                [10, 25, 50, 100],
                [10, 25, 50, 100]
            ],
            ajax: {
                url: '<?= base_url($this->type . '/sirkulasi_part/table') ?>',
                type: 'GET',
                dataType: 'JSON',
                data: arr,
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