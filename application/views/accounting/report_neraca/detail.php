<style>
    .bg_bawah {
        background-image: url('<?= base_url('uploads/img/logo.png') ?>');
        background-repeat: no-repeat;
        background-size: 100px;
        background-position: right bottom;
    }

    .nav-link {
        padding: 2px 2px;
    }

    .fs-12 {
        font-size: 12px;
    }

    .nav-tabs-custom,
    .nav-tabs {
        border-bottom: none;
    }

    input[type="text"]:disabled {
        background: #dddddd;
    }
</style>
<div class="card bg_bawah_">
    <div class="card-body">

        <!-- Nav tabs -->
        <div class="row align-items-center">
            <div class="col-md-3">
                <h4 class="card-title">Neraca Harian</h4>
                <p class="card-title-desc mb-0"><span class="text-primary fw-600 font-size-18"><?= $cabang->nama ?></span>, <?= tgl_indo($tanggal) ?></p>
            </div>
            <div class="col-md-9">
                <ul class="nav nav-tabs nav-tabs-custom nav-justified" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" data-toggle="tab" href="#tab1" role="tab">
                            <span class="d-block d-sm-none"><i class="fas fa-home"></i></span>
                            <span class="d-none d-sm-block fs-12">Modal Awal</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="tab" href="#tab2" role="tab">
                            <span class="d-block d-sm-none"><i class="far fa-user"></i></span>
                            <span class="d-none d-sm-block fs-12">Neraca</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="tab" href="#tab3" role="tab">
                            <span class="d-block d-sm-none"><i class="far fa-envelope"></i></span>
                            <span class="d-none d-sm-block fs-12">Dana</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="tab" href="#tab4" role="tab">
                            <span class="d-block d-sm-none"><i class="fas fa-cog"></i></span>
                            <span class="d-none d-sm-block fs-12">Profit</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="tab" href="#tab4" role="tab">
                            <span class="d-block d-sm-none"><i class="fas fa-cog"></i></span>
                            <span class="d-none d-sm-block fs-12">Operasional</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="tab" href="#tab5" role="tab">
                            <span class="d-block d-sm-none"><i class="fas fa-cog"></i></span>
                            <span class="d-none d-sm-block fs-12">Piutang</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="tab" href="#tab6" role="tab">
                            <span class="d-block d-sm-none"><i class="fas fa-cog"></i></span>
                            <span class="d-none d-sm-block fs-12">Hutang</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="tab" href="#tab7" role="tab">
                            <span class="d-block d-sm-none"><i class="fas fa-cog"></i></span>
                            <span class="d-none d-sm-block fs-12">Iklan</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="tab" href="#tab8" role="tab">
                            <span class="d-block d-sm-none"><i class="fas fa-cog"></i></span>
                            <span class="d-none d-sm-block fs-12">Kerugian</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="tab" href="#tab9" role="tab">
                            <span class="d-block d-sm-none"><i class="fas fa-cog"></i></span>
                            <span class="d-none d-sm-block fs-12">Margin Error</span>
                        </a>
                    </li>
                </ul>
            </div>
        </div>

        <hr style="border-bottom: 3px double #01293C;">

        <!-- Tab panes -->
        <div class="tab-content p-3 text-muted">
            <div class="tab-pane active" id="tab1" role="tabpanel">
                <?php include('tab1.php') ?>
            </div>
            <div class="tab-pane" id="tab2" role="tabpanel">
                <?php include('tab2.php') ?>
            </div>
            <div class="tab-pane" id="tab3" role="tabpanel">
                <?php include('tab3.php') ?>
            </div>
            <div class="tab-pane" id="tab4" role="tabpanel">
                <?php include('tab4.php') ?>
            </div>
            <div class="tab-pane" id="tab5" role="tabpanel">
                <?php include('tab5.php') ?>
            </div>
            <div class="tab-pane" id="tab6" role="tabpanel">
                <?php include('tab6.php') ?>
            </div>
            <div class="tab-pane" id="tab7" role="tabpanel">
                <?php include('tab7.php') ?>
            </div>
            <div class="tab-pane" id="tab8" role="tabpanel">
                <?php include('tab8.php') ?>
            </div>
            <div class="tab-pane" id="tab9" role="tabpanel">
                <?php include('tab9.php') ?>
            </div>
        </div>

    </div>
</div>