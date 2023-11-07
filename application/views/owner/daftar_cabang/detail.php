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
                                <select id="filter_bulan_penjualan" class="form-control js_select2" onchange="load_grafik_penjualan();">
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
        <div class="card rounded" style="border: none !important;box-shadow: 2px 2px 4px rgba(0, 0, 0, 0.2);min-height: 500px;" id="target_report">
            <div class="card-header" style="background-color: #01293c;">
                <div class="d-flex justify-content-between align-items-center">
                    <h3 class="card-title text-white mb-0 p-2">Report</h3>
                    <div style="width: 200px;">
                        <div class="row">
                            <div class="col-md-6" style="padding-right: 2px;">
                                <input type="date" class="form-control form-control-sm bg-success" id="tgl_start" value="<?= date('Y-m-d') ?>" onchange="reload_table()">
                            </div>
                            <div class="col-md-6" style="padding-left: 2px;">
                                <input type="date" class="form-control form-control-sm bg-danger" id="tgl_end" value="<?= date('Y-m-d') ?>" onchange="reload_table()">
                            </div>
                        </div>
                    </div>
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
                                <a href="#transaksi_penjualan" class="btn btn-sm btn-primary scroll_link">lihat <i class="fa fa-arrow-right"></i></a>
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
                                <a href="#servis_ic" class="btn btn-sm btn-primary scroll_link">lihat <i class="fa fa-arrow-right"></i></a>
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
                                <a href="#laporan_operasional" class="btn btn-sm btn-primary scroll_link">lihat <i class="fa fa-arrow-right"></i></a>
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
                                <a href="#laporan_kerugian" class="btn btn-sm btn-primary scroll_link">lihat <i class="fa fa-arrow-right"></i></a>
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
                                <a href="#laporan_kasbon" class="btn btn-sm btn-primary scroll_link">lihat <i class="fa fa-arrow-right"></i></a>
                            </td>
                        </tr>
                        <!-- <tr>
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
                                <a href="#modal_servis" class="btn btn-sm btn-primary scroll_link">lihat <i class="fa fa-arrow-right"></i></a>
                            </td>
                        </tr> -->
                        <!-- <tr>
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
                                <a href="#sirkulasi_keuangan" class="btn btn-sm btn-primary scroll_link">lihat <i class="fa fa-arrow-right"></i></a>
                            </td>
                        </tr> -->
                        <!-- <tr>
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
                                <a href="#rincian_profit" class="btn btn-sm btn-primary scroll_link">lihat <i class="fa fa-arrow-right"></i></a>
                            </td>
                        </tr> -->
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

<div class="row">
    <div class="col-md-12">
        <div class="card" style="border: none !important;box-shadow: 2px 2px 4px rgba(0, 0, 0, 0.2);" id="transaksi_penjualan">
            <div class="card-header" style="background-color: #01293c;">
                <div class="d-flex justify-content-between align-items-center py-2">
                    <h3 class="card-title text-white mb-0"><i class="fa fa-dollar-sign mr-2"></i> LAPORAN TRANSAKSI PENJUALAN</h3>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="mt-3 table table-striped table-bordered" id="table_data_transaksi">
                        <thead>
                            <tr>
                                <th class="fw-600">NO</th>
                                <th class="fw-600">TANGGAL</th>
                                <th class="fw-600">NAMA BARANG</th>
                                <th class="fw-600">MODAL</th>
                                <th class="fw-600">HARGA SATUAN</th>
                                <th class="fw-600">QTY</th>
                                <th class="fw-600">SUB TOTAL<br>(dikurangi potongan)</th>
                                <th class="fw-600">PROFIT</th>
                                <th class="fw-600">METODE PEMBAYARAN</th>
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

<div class="row">
    <div class="col-md-12">
        <div class="card" style="border: none !important;box-shadow: 2px 2px 4px rgba(0, 0, 0, 0.2);" id="servis_ic">
            <div class="card-header" style="background-color: #01293c;">
                <div class="d-flex justify-content-between align-items-center py-2">
                    <h3 class="card-title text-white mb-0"><i class="fa fa-tag mr-2"></i> LAPORAN SERVICE IC</h3>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="mt-3 table table-striped table-bordered" id="table_servis">
                        <thead>
                            <tr>
                                <th class="fw-600">NO</th>
                                <th class="fw-600">TANGGAL</th>
                                <th class="fw-600">INFORMASI</th>
                                <th class="fw-600">HARGA JUAL</th>
                                <th class="fw-600">MODAL</th>
                                <th class="fw-600">PROFIT</th>
                                <th class="fw-600">TEKNISI</th>
                                <th class="fw-600">TINDAKAN</th>
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

<div class="row">
    <div class="col-md-12">
        <div class="card" style="border: none !important;box-shadow: 2px 2px 4px rgba(0, 0, 0, 0.2);" id="laporan_operasional">
            <div class="card-header" style="background-color: #01293c;">
                <div class="d-flex justify-content-between align-items-center py-2">
                    <h3 class="card-title text-white mb-0"><i class="fa fa-mouse-pointer mr-2"></i> LAPORAN OPERASIONAL</h3>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="mt-3 table table-striped table-bordered" id="table_operasional">
                        <thead>
                            <tr>
                                <th class="fw-600">NO</th>
                                <th class="fw-600">CABANG</th>
                                <th class="fw-600">JENIS OPERASIONAL</th>
                                <th class="fw-600">TANGGAL</th>
                                <th class="fw-600">KETERANGAN</th>
                                <th class="fw-600">JUMLAH</th>
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

<div class="row">
    <div class="col-md-12">
        <div class="card" style="border: none !important;box-shadow: 2px 2px 4px rgba(0, 0, 0, 0.2);" id="laporan_kerugian">
            <div class="card-header" style="background-color: #01293c;">
                <div class="d-flex justify-content-between align-items-center py-2">
                    <h3 class="card-title text-white mb-0"><i class="fa fa-percent mr-2"></i> LAPORAN KERUGIAN</h3>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="mt-3 table table-striped table-bordered" id="table_kerugian">
                        <thead>
                            <tr>
                                <th class="fw-600">NO</th>
                                <th class="fw-600">CABANG</th>
                                <th class="fw-600">TANGGAL</th>
                                <th class="fw-600">JENIS</th>
                                <th class="fw-600">KETERANGAN</th>
                                <th class="fw-600">JUMLAH</th>
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

<div class="row">
    <div class="col-md-12">
        <div class="card" style="border: none !important;box-shadow: 2px 2px 4px rgba(0, 0, 0, 0.2);" id="laporan_kasbon">
            <div class="card-header" style="background-color: #01293c;">
                <div class="d-flex justify-content-between align-items-center py-2">
                    <h3 class="card-title text-white mb-0"><i class="fa fa-tag mr-2"></i> LAPORAN KASBON</h3>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="mt-3 table table-striped table-bordered" id="table_kasbon">
                        <thead>
                            <tr>
                                <th class="fw-600">NO</th>
                                <th class="fw-600">CABANG</th>
                                <th class="fw-600">NAMA PEGAWAI</th>
                                <th class="fw-600">SUMBER DANA</th>
                                <th class="fw-600">TANGGAL</th>
                                <th class="fw-600">KETERANGAN</th>
                                <th class="fw-600">JUMLAH</th>
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

<button id="tombol_naik" style="position: fixed;right: 0;bottom: 0; z-index: 999;" class="btn btn-primary m-4 scroll_link" href="#target_report"><i class="fa fa-arrow-up"></i></button>