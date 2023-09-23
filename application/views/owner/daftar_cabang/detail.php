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
        <input onchange="load_data();load_table();load_table_servis();" value="<?= date('Y-m-d') ?>" type="date" style="width: 140px;" class="form-control form-control-sm" id="select_tanggal">
    </div>
</div>

<div class="row">
    <div class="col-6">
        <div class="card">
            <div class="card-body">
                <h3 class="fw-600">Rp. <span id="total_profit_penjualan">0</span></h3>
                <div>Profit Penjualan Hari ini</div>
            </div>
        </div>
    </div>
    <div class="col-6">
        <div class="card">
            <div class="card-body">
                <h3 class="fw-600">Rp. <span id="total_profit_servis">0</span></h3>
                <div>Profit Service Berat Hari ini</div>
            </div>
        </div>
    </div>
    <div class="col-6">
        <div class="card">
            <div class="card-body">
                <h3 class="fw-600">Rp. <span id="total_profit_harian">0</span></h3>
                <div>Total Profit Harian</div>
            </div>
        </div>
    </div>
    <div class="col-6">
        <div class="card">
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

<div class="card">
    <div class="card-body">
        <h4>Laporan Transaksi</h4>
        <hr>
        <div class="table-responsive">
            <table class="mt-3 table table-striped table-bordered" id="table_data">
                <thead class="bg1">
                    <tr>
                        <th class="fw-600 text1">NO</th>
                        <th class="fw-600 text1">TANGGAL</th>
                        <th class="fw-600 text1">NAMA BARANG</th>
                        <th class="fw-600 text1">MODAL</th>
                        <th class="fw-600 text1">HARGA SATUAN</th>
                        <th class="fw-600 text1">QTY</th>
                        <th class="fw-600 text1">SUB TOTAL<br>(dikurangi potongan)</th>
                        <th class="fw-600 text1">PROFIT</th>
                        <th class="fw-600 text1">METODE PEMBAYARAN</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-body">
        <h4>Laporan Servis</h4>
        <hr>
        <div class="table-responsive">
            <table class="mt-3 table table-striped table-bordered" id="table_servis">
                <thead class="bg1">
                    <tr>
                        <th class="fw-600 text1">NO</th>
                        <th class="fw-600 text1">TANGGAL</th>
                        <th class="fw-600 text1">INFORMASI</th>
                        <th class="fw-600 text1">HARGA JUAL</th>
                        <th class="fw-600 text1">MODAL</th>
                        <th class="fw-600 text1">PROFIT</th>
                        <th class="fw-600 text1">TEKNISI</th>
                        <th class="fw-600 text1">TINDAKAN</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-body">
        <h4>Laporan Operasional</h4>
        <hr>
        <div class="table-responsive">
            <table class="mt-3 table table-striped table-bordered" id="table_operasional">
                <thead class="bg1">
                    <tr>
                        <th class="fw-600 text1">NO</th>
                        <th class="fw-600 text1">TANGGAL</th>
                        <th class="fw-600 text1">KETERANGAN</th>
                        <th class="fw-600 text1">DEBIT</th>
                        <th class="fw-600 text1">KREDIT</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-body">
        <h4>Laporan Kerugian</h4>
        <hr>
        <div class="table-responsive">
            <table class="mt-3 table table-striped table-bordered" id="table_kerugian">
                <thead class="bg1">
                    <tr>
                        <th class="fw-600 text1">NO</th>
                        <th class="fw-600 text1">TANGGAL</th>
                        <th class="fw-600 text1">KETERANGAN</th>
                        <th class="fw-600 text1">DEBIT</th>
                        <th class="fw-600 text1">KREDIT</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
    </div>