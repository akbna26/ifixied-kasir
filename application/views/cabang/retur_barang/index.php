<div class="row" id="target_full_page">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body bg1 br-atas p-3 mb-0 d-flex justify-content-between">
                <h3 style="display: inline-block;" class="fw-600 mb-0 text1"><i class="fas fa-info-circle mr-2"></i> <?= $title ?></h3>
                <?php if (session('type') == 'cabang') : ?>
                    <button onclick="tambah();" class="btn btn-light btn-sm fw-600">
                        <i class="fa fa-plus mr-1"></i> Retur Oleh Teknisi
                    </button>
                <?php endif; ?>
                <div style="width: 150px;" onchange="load_table();">
                    <select id="filter_jenis" class="form-control js_select2">
                        <option value="all" selected>semua jenis</option>
                        <option value="part">PART</option>
                        <option value="acc">ACC</option>
                    </select>
                </div>
            </div>

            <div class="card-body">
                <div class="table-responsive">
                    <table class="mt-3 table table-striped" id="table_data">
                        <thead>
                            <tr>
                                <th class="fw-600">NO</th>
                                <th class="fw-600">CABANG</th>
                                <th class="fw-600">NAMA BARANG</th>
                                <th class="fw-600">QTY</th>
                                <th class="fw-600">TANGGAL</th>
                                <th class="fw-600">INVOICE</th>
                                <th class="fw-600">JENIS KLAIM</th>
                                <th class="fw-600">VERIFIKASI GUDANG</th>
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