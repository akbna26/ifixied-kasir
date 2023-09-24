<div class="row" id="target_full_page">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body bg1 br-atas p-3 mb-0 d-flex justify-content-between">
                <h3 style="display: inline-block;" class="fw-600 mb-0 text1"><i class="fas fa-info-circle mr-2"></i> <?= $title ?></h3>
                <?php if (session('type') == 'cabang') : ?>
                    <button onclick="tambah();" class="btn btn-light btn-sm fw-600">
                        <i class="fa fa-plus mr-1"></i> Tambah Data Kerugian
                    </button>
                <?php endif; ?>
            </div>

            <div class="card-body">
                <div class="table-responsive">
                    <table class="mt-3 table table-striped" id="table_data">
                        <thead>
                            <tr>
                                <th class="fw-600">NO</th>
                                <th class="fw-600">CABANG</th>
                                <th class="fw-600">TEKNISI</th>
                                <th class="fw-600">NAMA BARANG</th>
                                <!-- <th class="fw-600">HARGA</th> -->
                                <th class="fw-600">TANGGAL</th>
                                <th class="fw-600">KETERANGAN</th>
                                <th class="fw-600" style="width: 200px;">AKSI</th>
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