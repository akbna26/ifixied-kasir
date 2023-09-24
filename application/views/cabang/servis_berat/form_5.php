<div class="alert alert-primary">
    <i class="fa fa-note"></i> Catatan
    <ul class="mb-0 fw-600">
        <li>Verifikasi hanya dapat dilakukan sekali</li>
        <li>Pastikan tidak melakukan kesalahan</li>
    </ul>
</div>

<form onsubmit="event.preventDefault();do_submit(this);">

    <h3 class="text-center">KONFIRMASI STATUS SERVIS</h3>
    <div class="text-center">
        <button data-value="3" type="button" onclick="set_radio(this,'btn_konfirmasi');" class="btn btn-outline-danger btn-lg fw-600 btn_konfirmasi mx-2">Menunggu SparePart</button>
        <button data-value="4" type="button" onclick="set_radio(this,'btn_konfirmasi');" class="btn btn-outline-danger btn-lg fw-600 btn_konfirmasi mx2">Menunggu Konfirmasi User</button>
        <button data-value="6" type="button" onclick="set_radio(this,'btn_konfirmasi');" class="btn btn-outline-success btn-lg fw-600 btn_konfirmasi mx-2">Proses QC</button>
        <button data-value="7" type="button" onclick="set_radio(this,'btn_konfirmasi');" class="btn btn-outline-danger btn-lg fw-600 btn_konfirmasi mx-2">Cancel by User</button>
        <button data-value="8" type="button" onclick="set_radio(this,'btn_konfirmasi');" class="btn btn-outline-danger btn-lg fw-600 btn_konfirmasi mx-2">Cancel by Teknisi</button>
    </div>

    <hr>
    
    <div class="form-group">
        <label>Keterangan <small class="text-danger fw-600">(wajib)</small></label>
        <textarea required name="keterangan" rows="3" placeholder="Masukkan isian" class="form-control"></textarea>
    </div>

    <input type="hidden" name="id" value="<?= encode_id(@$data->id) ?>">
    <input type="hidden" name="form" value="<?= encode_id(5) ?>">
    <button type="submit" class="btn btn-block btn-rounded fw-600 btn-primary"><i class="fas fa-check"></i> KONFIRMASI STATUS</button>
</form>

<script>
    function do_submit(dt) {

        var status = $('.btn_konfirmasi.active').data('value');
        if (status == undefined) {
            Swal.fire({
                icon: 'warning',
                title: 'Pilih Status Servis',
                showConfirmButton: true,
            })
            throw false;
        }

        Swal.fire({
            title: 'Konfirmasi Status Servis ?',
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: 'Ya',
            cancelButtonText: 'Batal',
            reverseButtons: true
        }).then((result) => {
            if (result.value) {

                var form = new FormData(dt);
                form.append('status', status);

                $.ajax({
                    type: "POST",
                    url: "<?= base_url('admin/servis_berat/do_konfirmasi') ?>",
                    data: form,
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