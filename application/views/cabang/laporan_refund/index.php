<div class="row" id="target_full_page">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body bg1 br-atas p-3 mb-0 d-flex justify-content-between">
                <h3 style="display: inline-block;" class="fw-600 mb-0 text1"><i class="fas fa-info-circle mr-2"></i> <?= $title ?></h3>
            </div>

            <div class="card-body">

                <div class="row bg2 border1 rounded p-3 mb-3">
                    <?php if ($this->type == 'admin') : ?>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Cabang</label>
                                <select id="select_cabang" class="form-control js_select2" data-placeholder="pilih cabang" onchange="load_table();">
                                    <option selected value="all">Semua Data</option>
                                    <?php foreach ($ref_cabang as $dt) : ?>
                                        <option value="<?= $dt->id ?>"><?= $dt->nama ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                    <?php endif; ?>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Tahun</label>
                            <select id="select_tahun" class="form-control js_select2" data-placeholder="pilih tahun" onchange="load_table();">
                                <option selected value="all">Semua Data</option>
                                <?php foreach ($ref_tahun as $dt) : ?>
                                    <option value="<?= $dt->tahun ?>"><?= $dt->tahun ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Bulan</label>
                            <select id="select_bulan" class="form-control js_select2" data-placeholder="pilih bulan" onchange="load_table();">
                                <option selected value="all">Semua Data</option>
                                <?php foreach ($ref_bulan as $dt) : ?>
                                    <option value="<?= $dt->bulan ?>"><?= $dt->nama ?></option>
                                <?php endforeach; ?>
                            </select>
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
                                <th class="fw-600">INVOICE</th>
                                <th class="fw-600">TOTAL ITEM</th>
                                <th class="fw-600">DAFTAR ITEM</th>
                                <th class="fw-600">AKSI</th>
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