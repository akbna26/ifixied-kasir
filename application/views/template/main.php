<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <title><?= @$title ?> | <?= data_sistem('nama') ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="<?= data_sistem('deskripsi') ?>" name="description" />
    <meta content="<?= data_sistem('nama') ?>" name="author" />

    <!-- App favicon -->
    <link rel="shortcut icon" href="<?= base_url('uploads/img/logo.png') ?>">

    <!-- Bootstrap Css -->
    <link href="<?= base_url('assets/skote/dist/') ?>assets/css/bootstrap.min.css" id="bootstrap-style" rel="stylesheet" type="text/css" />
    <!-- Icons Css -->
    <link href="<?= base_url('assets/skote/dist/') ?>assets/css/icons.min.css" rel="stylesheet" type="text/css" />
    <!-- App Css-->
    <link href="<?= base_url('assets/skote/dist/') ?>assets/css/app.min.css" id="app-style" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="<?= base_url('assets/custom/my_style.css?') . time() ?>">
    <link rel="stylesheet" href="<?= base_url('assets/custom/my_font.css') ?>">
</head>

<body class="<?= empty($no_sidebar) ? '' : 'sidebar-enable vertical-collpsed' ?>" data-sidebar="dark">

    <!-- Begin page -->
    <div id="layout-wrapper">

        <header id="page-topbar">
            <div class="navbar-header">
                <div class="d-flex">
                    <!-- LOGO -->
                    <div class="navbar-brand-box" style="border-bottom: 2px solid #f0fece;">
                        <a href="<?= base_url() ?>" target="_blank" class="logo logo-dark">
                            <span class="logo-sm">
                                <img src="<?= base_url('uploads/img/logo2.png') ?>" alt="" height="22">
                            </span>
                            <span class="logo-lg">
                                <img src="<?= base_url('uploads/img/logo2.png') ?>" alt="" height="40">
                            </span>
                        </a>

                        <a href="<?= base_url() ?>" target="_blank" class="logo logo-light">
                            <span class="logo-sm">
                                <img src="<?= base_url('uploads/img/logo2.png') ?>" alt="" height="22">
                            </span>
                            <span class="logo-lg">
                                <img src="<?= base_url('uploads/img/logo2.png') ?>" style="border:1px solid #fff;border-radius: 50%;" alt="" height="40">
                                <span class="ml-2 bold text-white">IFIXIED</span>
                            </span>
                        </a>
                    </div>

                    <button type="button" class="btn btn-sm px-3 font-size-16 header-item waves-effect" id="vertical-menu-btn">
                        <i class="fa fa-fw fa-bars"></i>
                    </button>
                </div>

                <div class="d-flex">

                    <div class="dropdown d-none d-lg-inline-block ml-1">
                        <button type="button" class="btn header-item noti-icon waves-effect" data-toggle="fullscreen">
                            <i class="bx bx-fullscreen"></i>
                        </button>
                    </div>

                    <div class="dropdown d-inline-block">
                        <button type="button" class="btn header-item noti-icon waves-effect" id="page-header-notifications-dropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="bx bx-bell"></i>
                            <span class="badge badge-danger badge-pill"><?= count(total_informasi()) ?></span>
                        </button>
                        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right p-0" aria-labelledby="page-header-notifications-dropdown">
                            <div class="p-3">
                                <div class="row align-items-center">
                                    <div class="col">
                                        <h6 class="m-0" key="t-notifications"> Notifikasi </h6>
                                    </div>
                                    <div class="col-auto">
                                        <a href="<?= base_url('global/informasi/all') ?>" class="small" key="t-view-all"> View All</a>
                                    </div>
                                </div>
                            </div>
                            <div data-simplebar style="max-height: 230px;">
                                <?php foreach (total_informasi() as $dt) : ?>
                                    <a href="#" onclick="return false;" class="text-reset notification-item">
                                        <div class="media">
                                            <div class="avatar-xs mr-3">
                                                <span class="avatar-title bg-primary rounded-circle font-size-16">
                                                    <i class="fas fa-info"></i>
                                                </span>
                                            </div>
                                            <div class="media-body">
                                                <h6 class="mt-0 mb-1" key="t-your-order"><?= $dt->judul ?></h6>
                                                <div class="font-size-12 text-muted">
                                                    <p class="mb-1" key="t-grammer"><?= substr($dt->keterangan, 0, 30) ?>...</p>
                                                    <p class="mb-0"><i class="mdi mdi-clock-outline"></i> <span key="t-min-ago"><?= tgl_indo($dt->tanggal) ?></span></p>
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    </div>

                    <div class="dropdown d-inline-block">
                        <button type="button" class="btn header-item waves-effect" id="page-header-user-dropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <img class="rounded-circle header-profile-user" src="<?= base_url(session('foto')) ?>" alt="Header Avatar">
                            <span class="d-none d-xl-inline-block ml-1" key="t-henry"><?= session('nama') ?></span>
                            <i class="mdi mdi-chevron-down d-none d-xl-inline-block"></i>
                        </button>
                        <div class="dropdown-menu dropdown-menu-right">
                            <!-- item-->
                            <a class="dropdown-item" href="<?= base_url('global/profil') ?>"><i class="bx bx-user font-size-16 align-middle mr-1"></i> <span key="t-profile">Profile</span></a>
                            <?php if (session('is_super')) : ?>
                                <a class="dropdown-item d-block" href="<?= base_url('super_admin/dashboard') ?>"><i class="bx bx-wrench font-size-16 align-middle mr-1"></i> <span key="t-settings">Pindah Role</span></a>
                            <?php endif; ?>
                            <a class="dropdown-item text-danger" href="<?= base_url('login/logout') ?>"><i class="bx bx-power-off font-size-16 align-middle mr-1 text-danger"></i> <span key="t-logout">Logout</span></a>
                        </div>
                    </div>

                </div>
            </div>
        </header>

        <?php if (empty($no_sidebar)) : ?>
            <?php $this->load->view($include_sidebar); ?>
        <?php endif; ?>

        <div class="main-content">
            <div class="page-content">
                <div class="container-fluid">
                    <?php $this->load->view($index); ?>
                </div>
            </div>

            <footer class="footer">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-sm-6">
                            <script>
                                document.write(new Date().getFullYear())
                            </script>
                        </div>
                        <div class="col-sm-6">
                            <!-- <div class="text-sm-right d-none d-sm-block"> -->
                            <marquee behavior="" direction="">
                                <?= data_sistem('nama') ?>
                            </marquee>
                        </div>
                    </div>
                </div>
            </footer>
        </div>

    </div>
    <!-- END layout-wrapper -->

    <div id="modal_custom" class="modal fade" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="background-color: rgba(255, 255, 255, .5);">
        <div id="modal_custom_size" class="modal-dialog modal-xl">
            <div style="border: 0;" class="modal-content shadow1">
                <div class="modal-header bg1">
                    <h5 class="modal-title mt-0 text1">JUDUL</h5>
                    <button type="button" class="close" onclick="$('#modal_custom').modal('hide');">
                        <span class="text-white" aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    Lorem ipsum dolor sit amet consectetur adipisicing elit. Minus, saepe esse sit nihil aperiam quae porro eveniet in recusandae consequatur reiciendis voluptatibus blanditiis magni! Aliquid ex minima distinctio at quod.
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div>

    <div id="modal_custom_2" class="modal fade" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="background-color: rgba(0, 0, 0, .5);">
        <div id="modal_custom_size_2" class="modal-dialog modal-xl">
            <div style="border: 0;" class="modal-content shadow1">
                <div class="modal-header bg1">
                    <h5 class="modal-title mt-0 text1">JUDUL</h5>
                    <button type="button" class="close" onclick="$('#modal_custom_2').modal('hide');">
                        <span class="text-white" aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    Lorem ipsum dolor sit amet consectetur adipisicing elit. Minus, saepe esse sit nihil aperiam quae porro eveniet in recusandae consequatur reiciendis voluptatibus blanditiis magni! Aliquid ex minima distinctio at quod.
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div>

    <!-- JAVASCRIPT -->
    <script src="<?= base_url('assets/skote/dist/') ?>assets/libs/jquery/jquery.min.js"></script>
    <script src="<?= base_url('assets/skote/dist/') ?>assets/libs/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="<?= base_url('assets/skote/dist/') ?>assets/libs/metismenu/metisMenu.min.js"></script>
    <script src="<?= base_url('assets/skote/dist/') ?>assets/libs/simplebar/simplebar.min.js"></script>
    <script src="<?= base_url('assets/skote/dist/') ?>assets/libs/node-waves/waves.min.js"></script>
    <script>
        const URL_ASSETS = "<?= base_url('assets/skote/dist/') ?>";
        const BASE_URL = "<?= base_url() ?>";
    </script>
    <script src="<?= base_url('assets/skote/dist/') ?>assets/js/app.js"></script>

    <link href="<?= base_url('assets/skote/dist/') ?>assets/libs/datatables.net-bs4/css/dataTables.bootstrap4.min.css" rel="stylesheet" type="text/css" />
    <link href="<?= base_url('assets/skote/dist/') ?>assets/libs/datatables.net-buttons-bs4/css/buttons.bootstrap4.min.css" rel="stylesheet" type="text/css" />
    <script src="<?= base_url('assets/skote/dist/') ?>assets/libs/datatables.net/js/jquery.dataTables.min.js"></script>
    <script src="<?= base_url('assets/skote/dist/') ?>assets/libs/datatables.net-bs4/js/dataTables.bootstrap4.min.js"></script>
    <!-- toastr -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <!-- sweetalert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!-- cdn select2 -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <script src="<?= base_url('assets/custom/my_app.js?') . time() ?>"></script>
    <?php $this->load->view($index_js); ?>
</body>

</html>