<div class="row" id="target_full_page">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body bg1 br-atas p-3 mb-0 d-flex justify-content-between">
                <h3 style="display: inline-block;" class="fw-600 mb-0 text1"><i class="fas fa-info-circle mr-2"></i> <?= $title ?></h3>
                <div style="width: 150px;">
                    <input type="date" class="form-control" value="" id="select_tanggal" onchange="load_table()">
                </div>
            </div>

            <div class="card-body">
                <div class="table-responsive">
                    <table class="mt-3 table table-striped" id="table_data">
                        <thead class="bg1">
                            <tr>
                                <th class="fw-600 text1">NO</th>
                                <th class="fw-600 text1">TANGGAL</th>
                                <th class="fw-600 text1">JENIS</th>
                                <th class="fw-600 text1">KETERANGAN</th>
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