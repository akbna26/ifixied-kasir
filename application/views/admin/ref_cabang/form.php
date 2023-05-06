<form onsubmit="event.preventDefault();do_submit(this);">
    <div class="form-group">
        <label>Nama Cabang</label>
        <input type="text" required name="nama" autocomplete="off" placeholder="Masukkan isian" class="form-control" value="<?= @$data->nama ?>">
    </div>

    <div class="form-group">
        <label>Lokasi</label>
        <textarea name="lokasi" required rows="5" placeholder="Masukkan isian" class="form-control"><?= @$data->lokasi ?></textarea>
    </div>

    <input type="hidden" name="id" value="<?= encode_id(@$data->id) ?>">
    <button type="submit" class="btn btn-block btn-rounded fw-600 btn-primary"><i class="fas fa-check"></i> KLIK DISINI UNTUK SIMPAN</button>
</form>

<script>
    function do_submit(dt) {

        Swal.fire({
            title: 'Simpan Data Cabang ?',
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: 'Ya',
            cancelButtonText: 'Batal',
            reverseButtons: true
        }).then((result) => {
            if (result.value) {

                $.ajax({
                    type: "POST",
                    url: "<?= base_url('admin/ref_cabang/do_submit') ?>",
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
                                    title: 'Data berhasil disimpan',
                                    showConfirmButton: true,
                                })
                                .then(() => {
                                    $('#table_data').DataTable().ajax.reload();
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