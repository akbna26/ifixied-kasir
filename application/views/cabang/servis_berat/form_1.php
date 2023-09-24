<div class="alert alert-success">
    <h3 class="mb-0 fw-600 text-center">Konfirmasi Status Menjadi Sedang Dicek</h3>
</div>
<form onsubmit="event.preventDefault();do_submit(this);">
    <div class="form-group">
        <label>Keterangan <small class="text-danger fw-600">(wajib)</small></label>
        <textarea required name="keterangan" rows="3" placeholder="Masukkan isian" class="form-control"></textarea>
    </div>

    <input type="hidden" name="id" value="<?= encode_id(@$data->id) ?>">
    <input type="hidden" name="form" value="<?= encode_id(1) ?>">
    <button type="submit" class="btn btn-block btn-rounded fw-600 btn-primary"><i class="fas fa-check"></i> KONFIRMASI STATUS</button>
</form>

<script>
    function do_submit(dt) {

        Swal.fire({
            title: 'Konfirmasi Status Servis ?',
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: 'Ya',
            cancelButtonText: 'Batal',
            reverseButtons: true
        }).then((result) => {
            if (result.value) {

                $.ajax({
                    type: "POST",
                    url: "<?= base_url($this->type . '/servis_berat/do_konfirmasi') ?>",
                    data: new FormData(dt),
                    dataType: "JSON",
                    contentType: false,
                    processData: false,
                    beforeSend: function(res) {
                        Swal.fire({
                            title: 'Loading ...',
                            html: '<i style="font-size:25px;" class="fa fa-spinner fa-spin"></i>',
                            allowOutsideClick: false,
                            showConfirmButton: false,
                        });
                    },
                    error: function(res) {
                        Swal.close();
                    },
                    success: function(res) {
                        if (res.status == 'success') {
                            $('#modal_custom').modal('hide');
                            Swal.fire({
                                    icon: 'success',
                                    title: 'Status berhasil diperbarui',
                                    showConfirmButton: true,
                                })
                                .then(() => {
                                    $('#table_data').DataTable().ajax.reload();
                                    get_total();
                                })
                        }
                    }
                });

            } else {
                return false;
            }
        })
    }
</script>