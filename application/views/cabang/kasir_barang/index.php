<!doctype html>
<html lang="en">

<head>

    <meta charset="utf-8" />
    <title>KASIR IFIXIED - <?= $cabang->nama ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="Kasir" name="description" />
    <meta content="Themesbrand" name="author" />
    <!-- App favicon -->
    <link rel="shortcut icon" href="<?= base_url('uploads/img/logo2.png') ?>">

    <link href="<?= base_url('assets/skote/dist/') ?>assets/libs/select2/css/select2.min.css" rel="stylesheet" type="text/css" />
    <link href="<?= base_url('assets/skote/dist/') ?>assets/libs/bootstrap-touchspin/jquery.bootstrap-touchspin.min.css" rel="stylesheet" />

    <!-- Bootstrap Css -->
    <link href="<?= base_url('assets/skote/dist/') ?>assets/css/bootstrap.min.css" id="bootstrap-style" rel="stylesheet" type="text/css" />
    <!-- Icons Css -->
    <link href="<?= base_url('assets/skote/dist/') ?>assets/css/icons.min.css" rel="stylesheet" type="text/css" />
    <!-- App Css-->
    <link href="<?= base_url('assets/skote/dist/') ?>assets/css/app.min.css" id="app-style" rel="stylesheet" type="text/css" />
    <link href="<?= base_url('assets/custom/kasir.css?q=') . time() ?>" id="app-style" rel="stylesheet" type="text/css" />

    <style>
        .form_focus:focus {
            outline: none !important;
            box-shadow: 0 0 5px #719ECE;
        }

        .back_home {
            cursor: pointer;
        }
    </style>
</head>

<body data-sidebar="dark" style="background-color: #01293C !important;">

    <!-- Begin page -->
    <div id="layout-wrapper">
        <div>

            <div class="page-content pt-0">
                <div class="container-fluid">
                    <div class="">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-lg-8">
                                    <div class="media">
                                        <div class="mr-3">
                                            <img width="100" src="<?= base_url('uploads/img/logo2.png') ?>" alt="" class="img-thumbnail back_home">
                                        </div>
                                        <div class="media-body align-self-center float-right">
                                            <div class="text-muted">
                                                <h5 class="mb-1 text-white"><?= $cabang->nama ?> - (Kasir Barang)</h5>
                                                <p class="mb-0 text-white"><?= $cabang->lokasi ?></p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-xl-8">
                            <div class="card rad-10">
                                <div class="card-body p-30c">
                                    <div class="row mx-0">
                                        <div class="col-sm-9 px-0 row mx-0">
                                            <div class="col-md-4 search-box custt d-inline-block px-md-0 px-0">
                                                <div class="position-relative">
                                                    <input name="barcode" id="input_barcode" autocomplete="off" autofocus type="text" class="form-control editt input_barcode form_focus" placeholder="Cari Barang">
                                                    <i class="bx bx-search-alt search-icon"></i>
                                                </div>
                                            </div>
                                            <div class="col-md-2 px-md-3 px-0 mt-md-0 mt-2">
                                                <input type="number" min="1" value="1" name="quantity" class="input_quantity input_spin form_focus">
                                            </div>
                                        </div>
                                        <div class="col-sm-3 px-0 mt-md-0 mt-4">
                                            <div class="text-sm-right">
                                                <button id="tombol_cari_manual" type="button" class="btn btn-success rad-10 waves-effect waves-light w-100"><i class="mdi mdi-magnify mr-1"></i> Cari Produk</button>
                                            </div>
                                        </div><!-- end col-->
                                    </div>
                                </div>
                            </div>
                            <div class="card rad-10">
                                <div class="card-body p-30c">
                                    <h5 class="card-title mb-4 text-info row align-items-center mx-0">Keranjang<i class="mdi mdi-cart ml-auto"></i></h5>
                                    <div class="table-responsive">
                                        <table id="table_data" class="table table-centered mb-0 table-nowrap">
                                            <thead class="thead-light">
                                                <tr>
                                                    <th>Produk</th>
                                                    <th width="100">Quantity</th>
                                                    <th>Satuan</th>
                                                    <th>Harga</th>
                                                    <th>Diskon (%)</th>
                                                    <th>Sub Total</th>
                                                    <th><i class="mdi mdi-cog"></i></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr class="text-center tr_default">
                                                    <td colspan="7">belum ada data</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-4">
                            <div class="card rad-10">
                                <div class="card-body p-0">
                                    <h5 class="card-title mb-0 p-30c text-info row align-items-center mx-0">Pembayaran<i class="fa fa-info-circle ml-auto"></i></h5>
                                    <div class="row mx-0">
                                        <div class="col-md-12 px-0">
                                            <div class="bordd bordd-tb select-cust py-1 px-3">
                                                <select id="select_member" class="w-100 ph js-select2 form_focus">
                                                    <option selected value="">Pilih Member</option>
                                                    <?php foreach ($member as $key) : ?>
                                                        <option value="<?= $key->id ?>"><?= $key->nama ?></option>
                                                    <?php endforeach; ?>
                                                </select>
                                            </div>
                                            <div class="bordd bordd-b select-cust py-1 px-3">
                                                <select name="metode" class="w-100 ph js-select2 form_focus">
                                                    <option selected value="tunai">Tunai</option>
                                                    <option value="transfer">Transfer</option>
                                                </select>
                                            </div>
                                            <div class="bordd bordd-b isi-cust py-1 px-3">
                                                <input name="bayar" autocomplete="off" type="text" class="form-control bord-zero ph input_bayar form_focus" placeholder="Nominal Bayar">
                                                <input type="hidden" readonly autocomplete="off" value="0" class="form-control kembali" name="kembali" placeholder="kembali">
                                            </div>
                                            <div class="mt-md-4 mt-3 p-30c py-3 kembaliann row align-items-center mx-0">
                                                <div class="px-0 txt-kem col-md-6 col-4">Kembalian</div>
                                                <div class="px-0 col-md-6 text-right col-8">Rp <span class="input_bayar_banner">0</span></div>
                                            </div>
                                            <div class="row p-30c mt-bayarr pb-md-3 pb-2 align-items-center">
                                                <div class="col-6">
                                                    <!-- <h5 class="font-size-15 m-0"><i class="mdi mdi-cash-multiple text-success align-middle mr-md-2 mr-1"></i>Cash</h5> -->
                                                </div>
                                                <div class="col-6">
                                                    <!-- <ul class="list-inline user-chat-nav custt text-right mb-0">
                                                        <li class="list-inline-item">
                                                            <div class="dropdown" data-toggle="tooltip" data-placement="top" title="" data-original-title="Metode Pembayaran">
                                                                <button class="btn nav-btn dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                                    <i class="bx bx-dots-horizontal-rounded"></i>
                                                                </button>
                                                                <div class="dropdown-menu dropdown-menu-right">
                                                                    <a class="dropdown-item" href="#">Ubah Transfer Bank</a>
                                                                </div>
                                                            </div>
                                                        </li>
                                                    </ul> -->
                                                </div>
                                            </div>
                                            <div class="row p-30c pt-0 align-items-center">
                                                <div class="col-md-7">
                                                    <p class="text-muted mb-0 lh-1"> Total</p>
                                                    <h5 class="font-size-20 m-0 font-weight-bold">Rp <span class="total_harga">0</span></h5>
                                                </div>
                                                <div class="col-md-5 mt-md-0 mt-2">
                                                    <a href="#" id="tombol_bayar" class="btn btn-info rad-10 w-100">
                                                        <i class="mdi mdi-cash-multiple mr-1"></i> Bayar
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- end card -->
                        </div>
                    </div>
                    <!-- end row -->

                </div> <!-- container-fluid -->
            </div>
            <!-- End Page-content -->


            <footer class="footer l-0">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-sm-6">
                            © 2023 <?= data_sistem('nama') ?>.
                        </div>
                    </div>
                </div>
            </footer>
        </div>
        <!-- end main content-->

    </div>
    <!-- END layout-wrapper -->

    <!-- Right bar overlay-->
    <div class="rightbar-overlay"></div>

    <!-- JAVASCRIPT -->
    <script>
        const MAIN_URL = "<?= base_url() ?>assets/skote/dist/";
        const URL_BASE = "<?= base_url() ?>";
    </script>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>

    <script src="<?= base_url('assets/skote/dist/') ?>assets/libs/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="<?= base_url('assets/skote/dist/') ?>assets/libs/metismenu/metisMenu.min.js"></script>
    <script src="<?= base_url('assets/skote/dist/') ?>assets/libs/simplebar/simplebar.min.js"></script>
    <script src="<?= base_url('assets/skote/dist/') ?>assets/libs/node-waves/waves.min.js"></script>

    <script src="<?= base_url('assets/skote/dist/') ?>assets/libs/select2/js/select2.min.js"></script>
    <!-- Bootrstrap touchspin -->
    <script src="<?= base_url('assets/skote/dist/') ?>assets/libs/bootstrap-touchspin/jquery.bootstrap-touchspin.min.js"></script>

    <script src="<?= base_url('assets/skote/dist/') ?>assets/js/app.js"></script>

    <?php include('index_js.php'); ?>
</body>

</html>