<div class="row" id="target_full_page">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body bg1 br-atas p-3 mb-0 d-flex justify-content-between">
                <h3 style="display: inline-block;" class="fw-600 mb-0 text1"><i class="fas fa-info-circle mr-2"></i> <?= $title ?></h3>
                <?php if (session('type') == 'cabang') : ?>
                    <button onclick="tambah();" class="btn btn-light fw-600 btn-sm">
                        <i class="fa fa-plus mr-1"></i> Tambah Servis Berat
                    </button>
                <?php endif; ?>
            </div>

            <div class="card-body">

                <ul class="nav nav-tabs nav-tabs-custom mb-4" role="tablist">
                    <?php foreach ($all_status as $i => $dt) : $dt = (object)$dt; ?>
                        <li class="nav-item" style="cursor: pointer;">
                            <a data-val="<?= $dt->id ?>" class="nav-link select_status <?= $i == 0 ? 'active' : '' ?>" data-toggle="tab" role="tab" onclick="refresh_table();">
                                <?= $dt->nama ?>
                            </a>
                        </li>
                    <?php endforeach; ?>
                </ul>

                <div class="table-responsive">
                    <table class="mt-3 table table-bordered" id="table_data">
                        <thead class="bg1 text1">
                            <tr>
                                <th class="fw-600">NO</th>
                                <th class="fw-600">PELANGGAN</th>
                                <th class="fw-600">TEMPAT & WAKTU</th>
                                <th class="fw-600">SPESIFIKASI</th>
                                <th class="fw-600">INFORMASI (ADMIN)</th>
                                <th class="fw-600">STATUS</th>
                                <th class="fw-600" style="width: 150px;">AKSI</th>
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