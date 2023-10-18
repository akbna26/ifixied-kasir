<div class="row">
    <div class="col-xl-4">
        <div class="card">
            <div class="card-body">
                <div>
                    <div class="d-flex justify-content-start" style="align-items: center;">
                        <i class="mdi mdi-account-circle text-primary h1 mr-2"></i>
                        <h5><?= $this->nama ?></h5>
                    </div>

                    <div>
                        <small class="mb-1"><?= $row->nama_prov ?>, <?= $row->nama_kab ?></small>
                        <p class="text-muted mb-0">email : <?= $row->email ?></p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-8">
        <div class="card">
            <div>
                <div class="row">
                    <div class="col-lg-9 col-sm-8">
                        <div class="p-4">
                            <h5 class="text-primary">Selamat Datang !</h5>
                            <p class="mb-1"><?= data_sistem('nama') ?></p>

                            <div class="text-muted mb-2">
                                <?= data_sistem('deskripsi') ?>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-sm-4 align-self-center gambar_icon">
                        <div>
                            <img src="<?= base_url('assets/skote/dist/') ?>assets/images/crypto/features-img/img-1.png" alt="" class="img-fluid d-block">
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>

<?php if (session('type') == 'owner') : ?>
    <div class="row">
        <div class="col-md-3">
            <div class="card mini-stats-wid">
                <div class="card-body">
                    <div class="media">
                        <div class="media-body">
                            <p class="text-muted font-weight-medium">Total Item</p>
                            <h4 class="mb-0"><?= rupiah($row_data->total_item) ?></h4>
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
                            <h4 class="mb-0"><?= rupiah($row_data->total_stock) ?></h4>
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
                            <h4 class="mb-0"><?= rupiah($row_data->total_modal_part) ?></h4>
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
                            <h4 class="mb-0"><?= rupiah($row_data->total_modal_acc) ?></h4>
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
<?php endif; ?>