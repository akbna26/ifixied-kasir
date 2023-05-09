<div class="row" id="target_full_page">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body bg1 br-atas p-3 mb-0 d-flex justify-content-between">
                <h3 style="display: inline-block;" class="fw-600 mb-0 text1"><i class="fas fa-info-circle mr-2"></i> <?= $title ?></h3>
                <button onclick="tambah();" class="btn btn-primary btn-rounded fw-600 glow">
                    <i class="fa fa-plus mr-1"></i> Tambah Data
                </button>
            </div>

            <div class="card-body">

                <div class="row bg2 border1 rounded p-3 mb-3">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Filter Cabang</label>
                            <select id="id_cabang" class="form-control js_select2" data-placeholder="pilih cabang" onchange="load_table();">
                                <option selected value="all">Semua Data</option>
                                <?php foreach ($ref_cabang as $dt) : ?>
                                    <option value="<?= $dt->id ?>"><?= $dt->nama ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Filter Jabatan</label>
                            <select id="id_jabatan" class="form-control js_select2" data-placeholder="pilih jabatan" onchange="load_table();">
                                <option selected value="all">Semua Data</option>
                                <?php foreach ($ref_jabatan as $dt) : ?>
                                    <option value="<?= $dt->id ?>"><?= $dt->nama ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="table-responsive">
                    <table class="mt-3 table table-striped" id="table_data">
                        <thead>
                            <tr>
                                <th class="fw-600">NO</th>
                                <th class="fw-600">NAMA PEGAWAI</th>
                                <th style="width: 300px;" class="fw-600">CABANG</th>
                                <th class="fw-600">JABATAN</th>
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