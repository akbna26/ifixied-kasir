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
                    <div class="col-lg-3 col-sm-4 align-self-center">
                        <div>
                            <img src="<?= base_url('assets/skote/dist/') ?>assets/images/crypto/features-img/img-1.png" alt="" class="img-fluid d-block">
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>

<h4 class="text-right">REKAP HARI INI - <?= tgl_indo(date('Y-m-d')) ?></h4>

<div class="row">
    <div class="col-md-6">
        <div class="card blog-stats-wid fw-600 bg-soft-success">
            <div class="card-body">
                <div class="d-flex flex-wrap">
                    <div class="mr-3">
                        <p class="mb-2 text-muted text-underline">TOTAL DP</p>
                        <h5 class="mb-0">Rp. <?= rupiah($total['dp']->total) ?> <small class="text-muted">(<?= rupiah($total['dp']->banyak) ?> transaksi)</small></h5>
                    </div>
                    <div class="avatar-sm ml-auto">
                        <div class="avatar-title bg-light rounded-circle text-primary font-size-20">
                            <i class="bx bx-dollar-circle"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card blog-stats-wid fw-600 bg-soft-success">
            <div class="card-body">
                <div class="d-flex flex-wrap">
                    <div class="mr-3">
                        <p class="mb-2 text-muted text-underline">TOTAL PENJUALAN BARANG</p>
                        <h5 class="mb-0">Rp. <?= rupiah($total['barang']->total) ?> <small class="text-muted">(<?= rupiah($total['barang']->banyak) ?> transaksi)</small></h5>
                    </div>
                    <div class="avatar-sm ml-auto">
                        <div class="avatar-title bg-light rounded-circle text-primary font-size-20">
                            <i class="bx bx-dollar-circle"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card blog-stats-wid fw-600 bg-soft-warning">
            <div class="card-body">
                <div class="d-flex flex-wrap">
                    <div class="mr-3">
                        <p class="mb-2 text-muted text-underline">TOTAL REFUND/RETUR</p>
                        <h5 class="mb-0">Rp. <?= rupiah($total['refund']->total) ?> <small class="text-muted">(<?= rupiah($total['refund']->banyak) ?> transaksi)</small></h5>
                    </div>
                    <div class="avatar-sm ml-auto">
                        <div class="avatar-title bg-light rounded-circle text-primary font-size-20">
                            <i class="bx bx-dollar-circle"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="card blog-stats-wid fw-600 bg-soft-warning">
            <div class="card-body">
                <div class="d-flex flex-wrap">
                    <div class="mr-3">
                        <p class="mb-2 text-muted text-underline">TOTAL SERVIS</p>
                        <h5 class="mb-0">Rp. <?= rupiah($total['servis_berat']->total) ?> <small class="text-muted">(<?= rupiah($total['servis_berat']->banyak) ?> transaksi)</small></h5>
                    </div>
                    <div class="avatar-sm ml-auto">
                        <div class="avatar-title bg-light rounded-circle text-primary font-size-20">
                            <i class="bx bx-dollar-circle"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>