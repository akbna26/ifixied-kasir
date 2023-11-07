<style>
    .bg_uang {
        background-image: url(<?= base_url('assets/img/uang.png') ?>);
        background-size: 50px 50px;
        background-repeat: no-repeat;
        background-position: right;
        background-origin: content-box;
    }
</style>
<div class="row" id="target_full_page">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body bg1 br-atas p-3 mb-0 d-flex justify-content-between">
                <div>
                    <h3 style="display: inline-block;" class="fw-600 mb-0 text1"><i class="fas fa-info-circle mr-2"></i> <?= $title ?></h3>
                </div>
                <div class="d-flex">
                    <div style="width: 120px;" class="mr-1">
                        <input type="date" value="<?= date('Y-m-d') ?>" id="filter_tanggal" class="form-control" onchange="load_table();">
                    </div>
                    <?php if (in_array(session('type'), ['admin', 'accounting', 'owner', 'owner_cabang'])) : ?>
                        <div style="width: 120px;" class="mr-1">
                            <select onchange="load_table();" id="filter_cabang" class="js_select2">
                                <option value="all" selected>Pilih Cabang</option>
                                <?php foreach ($ref_cabang as $dt) : ?>
                                    <option value="<?= $dt->id ?>"><?= $dt->nama ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    <?php elseif (session('type') == 'cabang') : ?>
                        <input type="hidden" id="filter_cabang" value="<?= $this->id_cabang ?>">
                    <?php endif; ?>
                    <div style="width: 120px;">
                        <select onchange="load_table();" id="filter_rekening" class="js_select2">
                            <option value="all" selected>Pilih Rekening</option>
                            <option value="cash">CASH</option>
                            <option value="bca">BCA</option>
                            <option value="mandiri">MANDIRI</option>
                        </select>
                    </div>
                </div>
            </div>

            <div class="card-body">

                <div class="row" id="target_total" style="display: none;">
                    <div class="col-md-3">
                        <div class="card">
                            <div class="card-body bg-soft-danger bg_uang">
                                <h5>Modal Sebelumnya</h5>
                                <h3 class="mb-0" id="card_total_modal">0</h3>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card">
                            <div class="card-body bg-soft-success bg_uang">
                                <h4>Kredit</h4>
                                <h3 class="mb-0" id="card_total_kredit">0</h3>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card">
                            <div class="card-body bg-soft-success bg_uang">
                                <h4>Debit</h4>
                                <h3 class="mb-0" id="card_total_debit">0</h3>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card">
                            <div class="card-body bg-soft-success bg_uang">
                                <h4>Total</h4>
                                <h3 class="mb-0" id="card_total">0</h3>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="table-responsive">
                    <table class="mt-3 table table-striped" id="table_data">
                        <thead class="bg1 text-white">
                            <tr>
                                <th class="fw-600">NO</th>
                                <th class="fw-600">CABANG</th>
                                <th class="fw-600">TANGGAL</th>
                                <th class="fw-600">JENIS TRANSAKSI</th>
                                <th class="fw-600">KREDIT</th>
                                <th class="fw-600">DEBIT</th>
                                <th class="fw-600">JENIS PEMBAYARAN</th>
                                <th class="fw-600">KETERANGAN</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>