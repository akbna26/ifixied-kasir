<form onsubmit="event.preventDefault();do_submit(this);">
    <div class="form-group">
        <label>Cabang</label>
        <select class="form-control js_select2" data-placeholder="pilih cabang" name="id_cabang">
            <option value=""></option>
            <?php foreach ($ref_cabang as $dt) : ?>
                <option <?= $dt->id == @$data->id_cabang ? 'selected' : '' ?> value="<?= $dt->id ?>"><?= $dt->nama ?> - <?= $dt->lokasi ?></option>
            <?php endforeach; ?>
        </select>
    </div>

    <div class="form-group">
        <label>Tanggal</label>
        <input type="date" required name="tanggal" placeholder="Masukkan isian" class="form-control" value="<?= empty($data->tanggal) ? '' : date('Y-m-d', strtotime($data->tanggal)) ?>">
    </div>

    <input type="hidden" name="id" value="<?= encode_id(@$data->id) ?>">
    <button type="submit" class="btn btn-block btn-rounded fw-600 btn-primary"><i class="fas fa-check"></i> KLIK DISINI UNTUK SIMPAN</button>
</form>

<script>
    $(document).ready(function() {
        $('.js_select2').select2({
            width: '100%'
        });
    });

    function do_submit(dt) {

        Swal.fire({
            title: 'Simpan Data Sharing ?',
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: 'Ya',
            cancelButtonText: 'Batal',
            reverseButtons: true
        }).then((result) => {
            if (result.value) {

                $.ajax({
                    type: "POST",
                    url: "<?= base_url('admin/barang_sharing/do_submit') ?>",
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
                                    $('[data-toggle="tooltip"]').tooltip();
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