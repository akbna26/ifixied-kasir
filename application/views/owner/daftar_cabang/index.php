<div class="row">
    <div class="col-12">
        <div class="page-title-box d-flex align-items-center justify-content-between">
            <h4 class="mb-0 font-size-18"><?= $title ?></h4>

            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="javascript: void(0);">IFIXIED</a></li>
                </ol>
            </div>

        </div>
    </div>
</div>

<div class="row">
    <?php foreach ($cabang as $dt) : ?>
        <div class="col-6">
            <div class="card mini-stats-wid bg3">
                <div class="card-body">
                    <div class="media">
                        <div class="media-body">
                            <h4 class="mb-1 text-white"><?= $dt->nama ?></h4>
                            <p class="text-white mb-1 d-none d-md-block font-weight-medium"><?= $dt->lokasi ?></p>
                            <a href="<?= base_url('owner/daftar_cabang/detail/') . encode_id($dt->id) ?>" class="badge badge-primary p-1 mt-2 rounded">Detail Data <i class="fa fa-arrow-right ml-1"></i></a>
                        </div>

                        <div class="mini-stat-icon avatar-sm d-none d-md-block rounded-circle align-self-center">
                            <span class="avatar-title" style="background-color: #ffffff !important;">
                                <i class="bx bx-line-chart text-danger fw-600 font-size-24"></i>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
</div>