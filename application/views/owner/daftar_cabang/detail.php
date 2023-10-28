<style>
    #grafik_profit,
    #grafik_profit_penjualan {
        width: 100%;
        height: 400px;
    }
</style>

<h3 class="fw-600">Dashboard Sistem Informasi iFixied Global Indonesia </h3>
<div>
    <span style="font-weight: 500;" class="text-primary"><?= date('l') ?>,</span>
    <?= date('d F Y') ?> | <span class="fw-600" style="font-size: 18px;"><?= $cabang->nama ?></span>
</div>

<div class="row mt-4">
    <div class="col-12 col-md-6">
        <div class="card" style="border: none !important;box-shadow: 2px 2px 4px rgba(0, 0, 0, 0.2);border-left: 3px solid #0161f2 !important;">
            <div class="card-body">
                <div style="color: #0161f2;">Profit Penjualan Hari Ini</div>
                <div class="d-flex justify-content-between align-items-center mt-2 mb-3">
                    <h3 class="mb-0"><?= $total_profit_penjualan ?></h3>
                    <i style="font-size: 25px;color: #0161f275;" class="fa fa-dollar-sign"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-12 col-md-6">
        <div class="card" style="border: none !important;box-shadow: 2px 2px 4px rgba(0, 0, 0, 0.2);border-left: 3px solid #9452d5 !important;">
            <div class="card-body">
                <div style="color: #9452d5;">Profit Servis IC</div>
                <div class="d-flex justify-content-between align-items-center mt-2 mb-3">
                    <h3 class="mb-0"><?= $total_profit_servis ?></h3>
                    <i style="font-size: 25px;color: #9452d575;" class="fas fa-tag"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-12 col-md-6">
        <div class="card" style="border: none !important;box-shadow: 2px 2px 4px rgba(0, 0, 0, 0.2);border-left: 3px solid #10ad6c !important;">
            <div class="card-body">
                <div style="color: #10ad6c;">Total Profit Harian</div>
                <div class="d-flex justify-content-between align-items-center mt-2 mb-3">
                    <h3 class="mb-0"><?= $total_profit_harian ?></h3>
                    <i style="font-size: 25px;color: #10ad6c75;" class="fas fa-mouse-pointer"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-12 col-md-6">
        <div class="card" style="border: none !important;box-shadow: 2px 2px 4px rgba(0, 0, 0, 0.2);border-left: 3px solid #04cfd5 !important;">
            <div class="card-body">
                <div style="color: #04cfd5;">Total Profit Bulanan</div>
                <div class="d-flex justify-content-between align-items-center mt-2 mb-3">
                    <h3 class="mb-0"><?= $total_profit_bulanan ?></h3>
                    <i style="font-size: 25px;color: #04cfd575;" class="fas fa-percent"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row mt-4">
    <div class="col-md-12">
        <div class="card" style="border: none !important;box-shadow: 2px 2px 4px rgba(0, 0, 0, 0.2);">
            <div class="card-header" style="background-color: #01293c;">
                <div class="d-flex justify-content-between align-items-center">
                    <h3 class="card-title text-white mb-0">GRAFIK PROFIT</h3>
                    <div style="width: 200px;">
                        <div class="row">
                            <div class="col-md-6">
                                <select id="filter_bulan_profit" class="form-control js_select2" onchange="load_grafik_profit();">
                                    <?php foreach ($bulan as $val => $dt) : ?>
                                        <option <?= date('m') == $dt ? 'selected' : '' ?> value="<?= $dt ?>"><?= $val ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <select id="filter_tahun_profit" class="form-control js_select2" onchange="load_grafik_profit();">
                                    <?php foreach ($tahun as $dt) : ?>
                                        <option <?= date('Y') == $dt ? 'selected' : '' ?> value="<?= $dt ?>"><?= $dt ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div id="grafik_profit"></div>
            </div>
        </div>
    </div>

    <div class="col-md-8">
        <div class="card" style="border: none !important;box-shadow: 2px 2px 4px rgba(0, 0, 0, 0.2);">
            <div class="card-header" style="background-color: #01293c;">
                <div class="d-flex justify-content-between align-items-center">
                    <h3 class="card-title text-white mb-0">GRAFIK PART & ACC</h3>
                    <div style="width: 200px;">
                        <div class="row">
                            <div class="col-md-6">
                                <select id="filter_bulan_penjualan" class="form-control js_select2" onchange="load_grafik_profit();">
                                    <?php foreach ($bulan as $val => $dt) : ?>
                                        <option <?= date('m') == $dt ? 'selected' : '' ?> value="<?= $dt ?>"><?= $val ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <select id="filter_tahun_penjualan" class="form-control js_select2" onchange="load_grafik_penjualan();">
                                    <?php foreach ($tahun as $dt) : ?>
                                        <option <?= date('Y') == $dt ? 'selected' : '' ?> value="<?= $dt ?>"><?= $dt ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div id="grafik_profit_penjualan"></div>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card" style="border: none !important;box-shadow: 2px 2px 4px rgba(0, 0, 0, 0.2);min-height: 500px;">
            <div class="card-header" style="background-color: #01293c;">
                <div class="d-flex justify-content-between align-items-center">
                    <h3 class="card-title text-white mb-0 p-2">Report</h3>
                </div>
            </div>
            <div class="card-body">

                <table class="table table-centered table-nowrap table-sm table-hover">
                    <tbody>
                        <tr>
                            <td style="width: 50px;">
                                <div class="font-size-16 text-primary">
                                    <i class="fa fa-dollar-sign"></i>
                                </div>
                            </td>
                            <td>
                                <div>
                                    <h5 class="font-size-14 mb-0">Laporan Transaksi Penjualan</h5>
                                </div>
                            </td>
                            <td>
                                <a href="#transaksi_penjualan" class="btn btn-sm btn-primary">lihat <i class="fa fa-arrow-right"></i></a>
                            </td>
                        </tr>
                        <tr>
                            <td style="width: 50px;">
                                <div class="font-size-16 text-warning">
                                    <i class="fa fa-tag"></i>
                                </div>
                            </td>
                            <td>
                                <div>
                                    <h5 class="font-size-14 mb-0">Laporan Service IC</h5>
                                </div>
                            </td>
                            <td>
                                <a href="#servis_ic" class="btn btn-sm btn-primary">lihat <i class="fa fa-arrow-right"></i></a>
                            </td>
                        </tr>
                        <tr>
                            <td style="width: 50px;">
                                <div class="font-size-16 text-danger">
                                    <i class="fa fa-mouse-pointer"></i>
                                </div>
                            </td>
                            <td>
                                <div>
                                    <h5 class="font-size-14 mb-0">Laporan Operasional</h5>
                                </div>
                            </td>
                            <td>
                                <a href="#laporan_operasional" class="btn btn-sm btn-primary">lihat <i class="fa fa-arrow-right"></i></a>
                            </td>
                        </tr>
                        <tr>
                            <td style="width: 50px;">
                                <div class="font-size-16 text-info">
                                    <i class="fas fa-percent"></i>
                                </div>
                            </td>
                            <td>
                                <div>
                                    <h5 class="font-size-14 mb-0">Laporan Kerugian</h5>
                                </div>
                            </td>
                            <td>
                                <a href="#laporan_kerugian" class="btn btn-sm btn-primary">lihat <i class="fa fa-arrow-right"></i></a>
                            </td>
                        </tr>
                        <tr>
                            <td style="width: 50px;">
                                <div class="font-size-16 text-success">
                                    <i class="fa fa-tag"></i>
                                </div>
                            </td>
                            <td>
                                <div>
                                    <h5 class="font-size-14 mb-0">Laporan Kasbon</h5>
                                </div>
                            </td>
                            <td>
                                <a href="#laporan_kasbon" class="btn btn-sm btn-primary">lihat <i class="fa fa-arrow-right"></i></a>
                            </td>
                        </tr>
                        <tr>
                            <td style="width: 50px;">
                                <div class="font-size-16 text-danger">
                                    <i class="fa fa-chart-line"></i>
                                </div>
                            </td>
                            <td>
                                <div>
                                    <h5 class="font-size-14 mb-0">Modal Service</h5>
                                </div>
                            </td>
                            <td>
                                <a href="#modal_servis" class="btn btn-sm btn-primary">lihat <i class="fa fa-arrow-right"></i></a>
                            </td>
                        </tr>
                        <tr>
                            <td style="width: 50px;">
                                <div class="font-size-16 text-warning">
                                    <i class="fa fa-chart-pie"></i>
                                </div>
                            </td>
                            <td>
                                <div>
                                    <h5 class="font-size-14 mb-0">Sirkulasi Keuangan</h5>
                                </div>
                            </td>
                            <td>
                                <a href="#sirkulasi_keuangan" class="btn btn-sm btn-primary">lihat <i class="fa fa-arrow-right"></i></a>
                            </td>
                        </tr>
                        <tr>
                            <td style="width: 50px;">
                                <div class="font-size-16 text-info">
                                    <i class="fa fa-chart-bar"></i>
                                </div>
                            </td>
                            <td>
                                <div>
                                    <h5 class="font-size-14 mb-0">Rincian Profit</h5>
                                </div>
                            </td>
                            <td>
                                <a href="#rincian_profit" class="btn btn-sm btn-primary">lihat <i class="fa fa-arrow-right"></i></a>
                            </td>
                        </tr>
                        <tr>
                            <td style="width: 50px;">
                                <div class="font-size-16 text-success">
                                    <i class="fa fa-chart-area"></i>
                                </div>
                            </td>
                            <td>
                                <div>
                                    <h5 class="font-size-14 mb-0">Check Stock</h5>
                                </div>
                            </td>
                            <td>
                                <a href="<?= base_url($this->type . '/daftar_cabang/barang?id=' . encode_id($cabang->id)) ?>" class="btn btn-sm btn-primary">lihat <i class="fa fa-arrow-right"></i></a>
                            </td>
                        </tr>
                    </tbody>
                </table>

            </div>
        </div>
    </div>

</div>