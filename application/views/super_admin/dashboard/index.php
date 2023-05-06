<div class="row mb-3">
    <div class="col-md-12">
        <h3 class="text-center">Pilih Role</h3>
        <p class="text-center">super admin dapat login sebagai role yang dipilih sesuai dengan akses yang terdaftar</p>
    </div>
</div>

<div class="row">

    <?php foreach ($ref_role as $dt) : ?>
        <div class="col-md-4 mt-4">
            <div onclick="show_data('<?= $dt->otoritas ?>','<?= encode_id($dt->id) ?>');" class="rounded bg1 text1 p-4 text-center glow2">
                <i class="fa fa-users fw-600" style="font-size: 25px;"></i>
                <span class="d-block text-center fw-600" style="font-size: 20px;"><?= $dt->otoritas ?></span>
                <span class="d-block text-center" style="font-size: 12px;">(<?= $dt->keterangan ?>)</span>
            </div>
        </div>
    <?php endforeach; ?>

</div>