<style>
    .kotak {
        height: 40px;
        width: 40px;
        margin: 2px;
        border: 1px solid #000;
        display: inline-block;
        position: relative;
    }
</style>
<form onsubmit="event.preventDefault();do_submit(this);">
    <div class="form-group">
        <label>Label</label>
        <input type="text" required name="label" autocomplete="off" placeholder="label" class="form-control" value="<?= @$data->label ?>">
    </div>

    <div class="form-group">
        <label>Warna</label>
        <div>
            <?php foreach ($ref_warna as $i => $dt) : ?>
                <span onclick="pilih_warna(this,'<?= $dt->warna ?>');" class="kotak" style="background-color: <?= $dt->warna ?>;">
                    <?php if ($dt->warna == @$data->warna || empty($data->warna) && $i == 0) : ?>
                        <i style="position: absolute;top:1px;right: 1px;-webkit-text-stroke: 1px #fff;" class="fa fa-check"></i>
                    <?php endif; ?>
                </span>
            <?php endforeach; ?>
        </div>
        <input type="hidden" name="warna" id="input_warna" value="<?= empty($data->warna) ? '#ffffff' : $data->warna ?>">
    </div>

    <input type="hidden" name="id" value="<?= encode_id(@$data->id) ?>">
    <button type="submit" class="btn btn-block btn-rounded btn-primary"><i class="fas fa-check"></i> KLIK DISINI UNTUK SIMPAN</button>
</form>

<script>
    function do_submit(dt) {
        Swal.fire({
            title: 'Simpan Label ?',
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: 'Ya',
            cancelButtonText: 'Batal',
            reverseButtons: true
        }).then((result) => {
            if (result.value) {

                $.ajax({
                    type: "POST",
                    url: "<?= base_url('admin/note/do_submit_label') ?>",
                    data: new FormData(dt),
                    dataType: "JSON",
                    contentType: false,
                    processData: false,
                    beforeSend: function(res) {
                        Swal.fire({
                            title: 'Loading',
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
                            }).then(() => {
                                location.reload();
                            })
                        }
                    }
                });
            } else {
                return false;
            }
        })
    }

    function pilih_warna(dt, warna) {
        $('.kotak').html('');
        $(dt).html(`
            <i style="position: absolute;top:1px;right: 1px;-webkit-text-stroke: 1px #fff;" class="fa fa-check"></i>
        `);
        $('#input_warna').val(warna);
    }   
</script>