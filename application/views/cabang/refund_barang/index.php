<style>
    .select2-container .select2-selection--single {
        height: auto !important;
        padding: 6px 12px !important;
    }
</style>
<div class="row" id="target_full_page">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body bg1 br-atas p-3 mb-0 d-flex justify-content-between">
                <h3 style="display: inline-block;" class="fw-600 mb-0 text1"><i class="fas fa-info-circle mr-2"></i> <?= $title ?></h3>
            </div>

            <div class="card-body">

                <div class="alert alert-primary">
                    <h4>Catatan</h4>
                    <ul class="mb-0">
                        <li>Pastikan invoice sudah sesuai</li>
                        <li>Transaksi tidak dapat dibatalkan</li>
                        <li>Silahkan klik ganti invoice untuk mengganti / membatalkan transaksi</li>
                    </ul>
                </div>

                <div class="row">
                    <div class="col-md-8">
                        <div class="form-group">
                            <input type="text" autocomplete="off" class="form-control" id="invoice" placeholder="invoice, contoh : INV1-202301-XXXX" value="">
                            <small class="text-danger fw-600">*) masukkan invoice</small>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <button id="cari_invoice" onclick="cari_invoice();" class="btn btn-block btn-primary fw-600"><i class="bx bx-search-alt-2 mr-1"></i> Cari Invoice</button>
                        <button id="ganti_invoice" style="display: none;" onclick="reload_halaman();" class="btn btn-block mt-0 btn-danger fw-600"><i class="fa fa-times mr-1"></i> Ganti Invoice</button>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <input type="text" disabled placeholder="cabang asal" class="form-control" id="cabang_asal">
                            <input type="hidden" id="cabang_asal_id">
                            <small class="text-danger fw-600">*) Cabang Asal</small>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <input type="text" disabled placeholder="cabang klaim" class="form-control" value="<?= $ref_cabang->nama ?>">
                            <small class="text-danger fw-600">*) Cabang Klaim</small>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <select required name="id_pegawai" id="select_pegawai" class="form-control js_select2" data-placeholder="pilih pegawai">
                                <option value=""></option>
                                <?php foreach ($ref_pegawai as $dt) : ?>
                                    <option value="<?= $dt->id ?>"><?= $dt->nama ?></option>
                                <?php endforeach; ?>
                            </select>
                            <small class="text-danger fw-600">*) Pegawai yang bertugas</small>
                        </div>
                    </div>
                </div>

                <hr>

                <div class="row mt-4">
                    <div class="col-md-12">

                        <h3>Detail Barang</h3>
                        <table class="table table-bordered table-sm">
                            <tr>
                                <td style="width: 200px;">
                                    List Barang
                                    <small class="text-danger d-block fw-600">*) pilih barang terlebih dahulu</small>
                                </td>
                                <td>
                                    <select id="select_barang" onchange="pilih_barang(this);" class="form-control js_select2" data-placeholder="pilih barang">
                                        <option value=""></option>
                                    </select>
                                </td>
                            </tr>
                            <tr style="display: none;">
                                <td>Harga Modal</td>
                                <td>
                                    <span class="text-primary fw-600 h4" id="harga_modal">-</span>
                                </td>
                            </tr>
                            <tr class="tr_hidden" style="display: none;">
                                <td>Harga Jual</td>
                                <td>
                                    <span class="text-primary fw-600 h4" id="harga_jual">-</span>
                                </td>
                            </tr>
                            <tr style="display: none;">
                                <td>Quantity</td>
                                <td>
                                    <input id="total_qty" value="1" type="text" class="form-control rupiah" placeholder="quantity" autocomplete="off">
                                </td>
                            </tr>
                            <tr class="tr_hidden" style="display: none;">
                                <td style="width: 200px;">Status Klaim</td>
                                <td>
                                    <select id="status_klaim" onchange="pilih_refund(this);" class="form-control js_select2" data-placeholder="pilih barang">
                                        <option value=""></option>
                                        <?php foreach ($ref_status_refund as $dt) : ?>
                                            <option value="<?= $dt->id ?>"><?= $dt->nama ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </td>
                            </tr>
                            <tr id="tr_refund" style="display: none;">
                                <td>Nilai Refund</td>
                                <td>
                                    <div class="mb-1">
                                        <select class="form-control js_select2" data-placeholder="pilih jenis pembayaran" id="jenis_pembayaran">
                                            <option value=""></option>
                                            <?php foreach ($ref_jenis_pembayaran as $dt) : ?>
                                                <option value="<?= $dt->id ?>"><?= $dt->nama ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                    <input disabled id="nilai_refund" type="text" class="form-control rupiah is-valid" placeholder="nilai refund" autocomplete="off">
                                </td>
                            </tr>
                            <tr id="tr_pengganti" style="display: none;">
                                <td style="width: 200px;">Barang Pengganti</td>
                                <td>
                                    <select id="barang_pengganti" class="form-control js_select2" data-placeholder="pilih barang pengganti">
                                        <option value=""></option>
                                        <?php foreach ($list_barang as $dt) : ?>
                                            <option value="<?= $dt->id ?>"><?= $dt->barcode ?> - <?= $dt->nama ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2">
                                    <button class="btn btn-warning btn-block btn-lg fw-600" onclick="tambah_produk();" style="color: #01293c !important;"><i class="fa fa-plus"></i> TAMBAH
                                    </button>
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>

                <hr>

                <h3>Daftar Return</h3>
                <div class="table-responsive">
                    <table class="mt-3 table table-bordered table-striped" id="table_data">
                        <thead class="bg1 text-white">
                            <tr>
                                <th class="fw-600">NAMA BARANG</th>
                                <th class="fw-600">HARGA JUAL</th>
                                <th style="display: none;" class="fw-600">HARGA MODAL</th>
                                <th class="fw-600" hidden>QTY</th>
                                <th class="fw-600">STATUS KLAIM</th>
                                <th class="fw-600">NILAI REFUND</th>
                                <th class="fw-600">BARANG PENGGANTI</th>
                                <th class="fw-600" style="width: 100px;">AKSI</th>
                            </tr>
                        </thead>
                        <tbody id="tbody_daftar">

                        </tbody>
                    </table>
                    <button onclick="do_submit();" type="button" class="btn btn-primary btn-block btn-lg fw-600"><i class="fa fa-check"></i> SIMPAN</button>
                </div>
            </div>
        </div>
    </div>
</div>