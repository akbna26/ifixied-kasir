<div class="row" id="target_full_page">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body bg1 br-atas p-3 mb-0 d-flex justify-content-between">
                <div>
                    <h3 class="fw-600 mb-0 text1"><i class="fas fa-info-circle mr-2"></i> <?= $title ?></h3>
                    <span class="text-white fw-600 text-underline">Sharing Cabang : <?= $row->nama ?>, <?= tgl_indo($row->tanggal) ?></span>
                </div>
                <div>
                    <button onclick="history.go(-1);" class="btn btn-light btn-sm fw-600 mr-2">
                        <i class="fa fa-arrow-left"></i> Kembali
                    </button>
                    <?php if ($row->is_konfirmasi == 0) : ?>
                        <button onclick="tambah();" class="btn btn-light btn-sm fw-600">
                            <i class="fa fa-plus mr-1"></i> Tambah Data
                        </button>
                    <?php endif; ?>
                    <a target="_blank" href="<?= base_url('admin/cetak/detail_sharing/' . encode_id($row->id)) ?>" class="btn btn-light btn-sm fw-600">
                        <i class="fa fa-print mr-1"></i> Export Data
                    </a>
                </div>
            </div>

            <div class="card-body">
                <div class="table-responsive">
                    <table class="mt-3 table table-striped table-sm" id="table_data">
                        <thead class="bg1 text-white">
                            <tr>
                                <th class="fw-600">NO</th>
                                <th class="fw-600">KATEGORI</th>
                                <th class="fw-600">BARANG</th>
                                <th class="fw-600">STOCK</th>
                                <th class="fw-600">MODAL</th>
                                <th class="fw-600" style="width: 250px;">AKSI</th>
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