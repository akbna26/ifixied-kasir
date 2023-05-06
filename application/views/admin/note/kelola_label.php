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

<table class="table table-striped" style="width: 100%;">
    <thead>
        <tr>
            <th class="text-center" style="width: 50px;">No</th>
            <th>Label</th>
            <th style="width: 250px;">Warna</th>
            <th class="text-center" style="width: 150px;">Hapus</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($data as $i => $val) : ?>
            <tr>
                <td class="text-center"><?= $i + 1 ?></td>
                <td>
                    <input onchange="save_one('<?= encode_id($val->id) ?>','label',this.value);" type="text" class="form-control" placeholder="masukkan nama label" value="<?= $val->label ?>">
                </td>
                <td>
                    <div>
                        <?php foreach ($ref_warna as $i => $dt) : ?>
                            <span onclick="pilih_warna(this,'<?= $val->id ?>','<?= $dt->warna ?>');save_one('<?= encode_id($val->id) ?>','warna','<?= $dt->warna ?>');" class="kotak kotak_<?= $val->id ?>" style="background-color: <?= $dt->warna ?>;">
                                <?php if ($dt->warna == @$val->warna || empty($val->warna) && $i == 0) : ?>
                                    <i style="position: absolute;top:1px;right: 1px;-webkit-text-stroke: 1px #fff;" class="fa fa-check"></i>
                                <?php endif; ?>
                            </span>
                        <?php endforeach; ?>
                    </div>
                </td>
                <td class="text-center">
                    <span onclick="hapus_label('<?= encode_id($val->id) ?>');" class="text-danger text-underline fw-600">hapus</span>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<script>
    function hapus_label(id) {
        Swal.fire({
            title: 'Hapus Label ?',
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
                    data: {
                        hapus: true,
                        id: id,
                    },
                    dataType: "JSON",
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
                            Swal.fire({
                                    icon: 'success',
                                    title: 'Berhasil dihapus',
                                    showConfirmButton: true,
                                })
                                .then(() => {
                                    location.reload();
                                });
                        }
                    }
                });
            } else {
                return false;
            }
        })
    }

    function pilih_warna(dt, id, warna) {
        $('.kotak_' + id).html('');
        $(dt).html(`
            <i style="position: absolute;top:1px;right: 1px;-webkit-text-stroke: 1px #fff;" class="fa fa-check"></i>
        `);
    }

    function save_one(id, target, val) {
        $.ajax({
            type: "POST",
            url: "<?= base_url('admin/note/do_submit_label') ?>",
            data: {
                id: id,
                target: target,
                val: val,
            },
            dataType: "JSON",
            beforeSend: function() {
                Swal.fire({
                    title: 'Loading',
                    html: '<i style="font-size:25px;" class="fa fa-spinner fa-spin"></i>',
                    allowOutsideClick: false,
                    showConfirmButton: false,
                });
            },
            error: function() {
                Swal.close();
            },
            success: function(res) {
                if (res.status == 'success') {
                    Swal.fire({
                            icon: 'success',
                            title: 'Data berhasil disimpan',
                            showConfirmButton: true,
                        })
                        .then(() => {
                            location.reload();
                        })
                }
            }
        });
    }
</script>