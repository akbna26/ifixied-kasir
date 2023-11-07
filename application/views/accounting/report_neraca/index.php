<h3>Report Neraca Harian</h3>
<div class="row">
    <?php foreach ($cabang as $i => $dt) : ?>
        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <h4 style="font-weight: 400;" class="text-primary mb-3"><span class="fw-600">iFixied</span> <?= $dt->nama ?></h4>
                    <div class="row">
                        <div class="col-md-6">
                            <input type="date" class="form-control form-control-sm mb-2" id="pilih_tanggal_<?= $i ?>" value="<?= date('Y-m-d') ?>">
                        </div>
                        <div class="col-md-6">
                            <button type="button" onclick="cetak_harian('<?= encode_id($dt->id) ?>',<?= $i ?>);" class="btn btn-primary btn-sm">Report</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
</div>