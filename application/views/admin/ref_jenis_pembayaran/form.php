<form onsubmit="event.preventDefault();do_submit(this);">
    <div class="form-group">
        <label>Nama/Jenis Pembayaran</label>
        <input type="text" required name="nama" autocomplete="off" placeholder="Masukkan isian" class="form-control" value="<?= @$data->nama ?>">
    </div>

    <div class="form-group">
        <label>Nomer Rekening</label>
        <input type="text" required name="no_rek" autocomplete="off" placeholder="Masukkan isian" class="form-control" value="<?= @$data->no_rek ?>">
    </div>

    <div class="form-group">
        <label>Prosentase Potongan</label>
        <input type="text" required name="persen_potongan" autocomplete="off" placeholder="Masukkan isian" class="form-control rupiah" value="<?= !empty($data->persen_potongan) ? rupiah($data->persen_potongan,true) : '' ?>">
    </div>

    <input type="hidden" name="id" value="<?= encode_id(@$data->id) ?>">
    <button type="submit" class="btn btn-block btn-rounded fw-600 btn-primary"><i class="fas fa-check"></i> KLIK DISINI UNTUK SIMPAN</button>
</form>

<script>
    function do_submit(dt) {

        Swal.fire({
            title: 'Simpan Jenis Pembayaran ?',
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: 'Ya',
            cancelButtonText: 'Batal',
            reverseButtons: true
        }).then((result) => {
            if (result.value) {

                $.ajax({
                    type: "POST",
                    url: "<?= base_url('admin/ref_jenis_pembayaran/do_submit') ?>",
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