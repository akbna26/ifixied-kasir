<script>
    function show_data(type, otoritas) {
        $.ajax({
            type: "POST",
            url: "<?= base_url('super_admin/dashboard/show_data') ?>",
            data: {
                type: type,
                otoritas: otoritas,
            },
            dataType: 'JSON',
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
                        judul: 'DATA ' + (type.toUpperCase()),
                        html: res.html,
                        size: 'modal-xl',
                    });
                }
            }
        });
    }
</script>