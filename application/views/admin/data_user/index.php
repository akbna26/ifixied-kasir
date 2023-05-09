<div class="row">
    <div class="col-md-12">
        <button class="btn btn-primary mb-2 btn-rounded float-right" onclick="tambah();">
            <i class="fa fa-plus"></i>
            Tambah User
        </button>
        <div style="clear: both;"></div>
    </div>
</div>
<div class="card">
    <div class="card-body bg2 border1" style="border-top-left-radius: 15px;border-top-right-radius: 15px;">
        <h3 class="text-center fw-600">AKSES YANG TERSEDIA</h3>
        <div style="display: flex;flex-direction: row;justify-content: center;">
            <?php foreach ($ref_role as $i => $dt) : ?>
                <div class="ml-2 mr-2">
                    <button style="border-radius:15px 15px 0 0;" onclick="load_table('<?= encode_id($dt->id) ?>');set_radio(this,'select_type');" class="btn select_type p-2 <?= $i == 0 ? 'active' : '' ?> btn-outline-primary glow2 fw-600 btn-block">
                        <i class="fa fa-users"></i> <?= $dt->keterangan ?>
                    </button>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
    <div class="card-body">

        <table class="mt-3 table table-striped" id="table_data">
            <thead>
                <tr>
                    <th class="fw-600">NO</th>
                    <th class="fw-600">NAMA</th>
                    <th class="fw-600">CABANG</th>
                    <th class="fw-600">INFORMASI</th>
                    <th class="fw-600">WILAYAH</th>
                    <th class="fw-600">ALAMAT</th>
                    <th class="fw-600" style="width:200px;">AKSI</th>
                </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
    </div>
</div>