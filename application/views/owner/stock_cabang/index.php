<div class="row" id="target_full_page">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body bg1 br-atas p-3 mb-0 d-flex justify-content-between">
                <h3 style="display: inline-block;" class="fw-600 mb-0 text1"><i class="fas fa-info-circle mr-2"></i> <?= $title ?></h3>
                <div>
                    <select id="id_kategori" class="form-control js_select2" data-placeholder="pilih kategori" onchange="load_table();">
                        <option selected value="all">Semua Data</option>
                        <?php foreach ($ref_kategori as $dt) : ?>
                            <option value="<?= $dt->id ?>"><?= $dt->nama ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>

            <div class="card-body">

                <div class="row">
                    <div class="col-md-3">
                        <div class="card mini-stats-wid">
                            <div class="card-body">
                                <div class="media">
                                    <div class="media-body">
                                        <p class="text-muted font-weight-medium">Total Item</p>
                                        <h4 class="mb-0"><?= rupiah($row->total_item) ?></h4>
                                    </div>

                                    <div class="mini-stat-icon avatar-sm rounded-circle bg-primary align-self-center">
                                        <span class="avatar-title">
                                            <i class="bx bx-dollar-circle font-size-24"></i>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card mini-stats-wid">
                            <div class="card-body">
                                <div class="media">
                                    <div class="media-body">
                                        <p class="text-muted font-weight-medium">Total Stock</p>
                                        <h4 class="mb-0"><?= rupiah($row->total_stock) ?></h4>
                                    </div>

                                    <div class="mini-stat-icon avatar-sm rounded-circle bg-primary align-self-center">
                                        <span class="avatar-title">
                                            <i class="bx bx-dollar-circle font-size-24"></i>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card mini-stats-wid">
                            <div class="card-body">
                                <div class="media">
                                    <div class="media-body">
                                        <p class="text-muted font-weight-medium">Total Modal Part</p>
                                        <h4 class="mb-0"><?= rupiah($row->total_modal_part) ?></h4>
                                    </div>

                                    <div class="mini-stat-icon avatar-sm rounded-circle bg-primary align-self-center">
                                        <span class="avatar-title">
                                            <i class="bx bx-dollar-circle font-size-24"></i>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card mini-stats-wid">
                            <div class="card-body">
                                <div class="media">
                                    <div class="media-body">
                                        <p class="text-muted font-weight-medium">Total Modal ACC</p>
                                        <h4 class="mb-0"><?= rupiah($row->total_modal_acc) ?></h4>
                                    </div>

                                    <div class="mini-stat-icon avatar-sm rounded-circle bg-primary align-self-center">
                                        <span class="avatar-title">
                                            <i class="bx bx-dollar-circle font-size-24"></i>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="table-responsive">
                    <table class="mt-3 table" id="table_data">
                        <thead class="bg1 text-white">
                            <tr>
                                <th class="fw-600">NO</th>
                                <th class="fw-600">NAMA BARANG</th>
                                <th class="fw-600">HARGA</th>
                                <th class="fw-600">STOCK</th>
                                <th class="fw-600">TOTAL MODAL</th>
                                <th class="fw-600">KODE BARCODE</th>
                                <th class="fw-600">INFORMASI</th>
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