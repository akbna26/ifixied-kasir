<div class="row">
    <div class="col-md-12 text-center">
        <div class="btn-group mb-2" role="group">
            <button id="btnGroupVerticalDrop1" type="button" class="btn btn-primary btn-rounded w-100 dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                Klik Untuk Kelola Note <i class="mdi mdi-chevron-down"></i>
            </button>
            <div class="dropdown-menu" aria-labelledby="btnGroupVerticalDrop1">
                <a class="dropdown-item d-block" onclick="event.preventDefault();tambah_catatan();" href="#"><i class="fa fa-plus"></i> Tambah Catatan</a>
                <a class="dropdown-item d-block" onclick="event.preventDefault();tambah_label();" href="#"><i class="fa fa-plus"></i> Tambah Label</a>
                <a class="dropdown-item d-block" onclick="event.preventDefault();kelola_label();" href="#"><i class="fa fa-edit"></i> Kelola Label</a>
            </div>
        </div>
        <div style="clear: both;"></div>
    </div>
    <div class="col-md-12 bg-white">
        <ul class="nav nav-tabs nav-tabs-custom nav-justified" role="tablist">
            <li class="nav-item">
                <a class="nav-link active" onclick="load_all('')" data-toggle="tab" role="tab">
                    <span>All</span>
                </a>
            </li>
            <?php foreach ($label as $dt) : ?>
                <li class="nav-item">
                    <a class="nav-link label_link" data-id="<?= encode_id($dt->id) ?>" onclick="load_all('<?= encode_id($dt->id) ?>')" data-toggle="tab" role="tab">
                        <span class="badge p-1" style="color:#000;border:1px solid #000;background-color: <?= $dt->warna ?>;"><?= $dt->label ?></span>
                    </a>
                </li>
            <?php endforeach; ?>
        </ul>
    </div>
</div>

<div class="row mt-4" id="list_card">
</div>