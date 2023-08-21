<style>
    .grafik_custom {
        width: 100%;
        height: 450px;
    }
</style>

<div class="row">
    <div class="col-12">
        <div class="page-title-box d-flex align-items-center justify-content-between">
            <h4 class="mb-0 font-size-18"><?= $title ?></h4>

            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="javascript: void(0);"><?= $cabang->nama ?></a></li>
                </ol>
            </div>

        </div>
    </div>
</div>

<div class="card-body bg1 rounded p-3 mb-3 d-flex align-items-center justify-content-between">
    <h3 style="display: inline-block;" class="fw-600 mb-0 text1"><i class="fas fa-info-circle mr-2"></i> <?= $title ?></h3>
    <div style="width: 150px;">
        <input onchange="load_data();" value="<?= date('Y-m-d') ?>" type="date" style="width: 140px;" class="form-control form-control-sm" id="select_tanggal">
    </div>
</div>

<div class="row">
    <div class="col-6">
        <div class="card bg2">
            <div class="card-body">
                <h3 class="fw-600">Rp. <span id="total_profit_penjualan">0</span></h3>
                <div>Profit Penjualan</div>
            </div>
        </div>
    </div>
    <div class="col-6">
        <div class="card bg2">
            <div class="card-body">
                <h3 class="fw-600">Rp. <span id="total_profit_servis">0</span></h3>
                <div>Profit Service Berat</div>
            </div>
        </div>
    </div>
    <div class="col-6">
        <div class="card bg2">
            <div class="card-body">
                <h3 class="fw-600">Rp. <span id="total_profit_harian">0</span></h3>
                <div>Total Profit Harian</div>
            </div>
        </div>
    </div>
    <div class="col-6">
        <div class="card bg2">
            <div class="card-body">
                <h3 class="fw-600">Rp. <span id="total_profit_bulanan">0</span></h3>
                <div>Total Profit Bulanan</div>
            </div>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-body">
        <div id="grafik" class="grafik_custom"></div>
    </div>
</div>