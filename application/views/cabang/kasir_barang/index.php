<!doctype html>
<html lang="en">

<head>

    <meta charset="utf-8" />
    <title>KASIR IFIXIED - <?= $cabang->nama ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="Kasir" name="description" />
    <meta content="Themesbrand" name="author" />
    <!-- App favicon -->
    <link rel="shortcut icon" href="<?= base_url('uploads/img/logo.png') ?>">

    <link href="<?= base_url('assets/skote/dist/') ?>assets/libs/select2/css/select2.min.css" rel="stylesheet" type="text/css" />
    <link href="<?= base_url('assets/skote/dist/') ?>assets/libs/bootstrap-touchspin/jquery.bootstrap-touchspin.min.css" rel="stylesheet" />

    <!-- Bootstrap Css -->
    <link href="<?= base_url('assets/skote/dist/') ?>assets/css/bootstrap.min.css" id="bootstrap-style" rel="stylesheet" type="text/css" />
    <!-- Icons Css -->
    <link href="<?= base_url('assets/skote/dist/') ?>assets/css/icons.min.css" rel="stylesheet" type="text/css" />
    <!-- App Css-->
    <link href="<?= base_url('assets/skote/dist/') ?>assets/css/app.min.css" id="app-style" rel="stylesheet" type="text/css" />
    <link href="<?= base_url('assets/custom/kasir.css?q=') . time() ?>" id="app-style" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="<?= base_url('assets/custom/my_style.css?') . time() ?>">

    <style>
        .form_focus:focus {
            outline: none !important;
            box-shadow: 0 0 5px #719ECE;
        }

        .back_home {
            cursor: pointer;
        }

        .inv_dp:hover {
            cursor: pointer;
            text-decoration: underline;
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
                                            <img width="100" src="<?= base_url('uploads/img/logo.png') ?>" alt="" class="img-thumbnail back_home">
                                        </div>
                                        <div class="media-body align-self-center float-right">
                                            <div class="text-muted">
                                                <h5 class="mb-1 text-white"><?= $cabang->nama ?> - (Kasir Barang)</h5>
                                                <p class="mb-0 text-white"><?= $cabang->lokasi ?></p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-4 d-flex" style="justify-content: center;align-items: center;flex-direction: column;">
                                    <h4 class="text-white fw-600">Invoice : <?= $no_invoice ?></h4>
                                    <div class="text-white">
                                        <span><?= strftime('%A, %d %B %Y'); ?></span> <i class="fa fa-clock mr-1 ml-2"></i> <span id="info_waktu">-</span> WIB
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
                                                <button onclick="cari_manual();" type="button" class="btn btn-success rad-10 waves-effect waves-light w-100"><i class="mdi mdi-magnify mr-1"></i> Cari Produk</button>
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
                                                    <th>Barcode</th>
                                                    <th width="100">Quantity</th>
                                                    <th>Harga</th>
                                                    <th>Sub Total</th>
                                                    <th><i class="mdi mdi-cog"></i></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr class="text-center tr_default">
                                                    <td colspan="6">belum ada data</td>
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
                                                <select id="select_pegawai" class="w-100 ph js-select2 form_focus" onchange="pilih_pegawai(this);">
                                                    <option selected disabled value="">Pilih Pegawai</option>
                                                    <?php foreach ($pegawai as $key) : ?>
                                                        <option value="<?= $key->id ?>"><?= $key->nama ?></option>
                                                    <?php endforeach; ?>
                                                </select>
                                            </div>
                                            <div class="bordd bordd-b select-cust py-1 px-3">
                                                <select id="select_jenis_pembayaran" class="w-100 ph js-select2 form_focus">
                                                    <option selected disabled value="">Jenis Pembayaran</option>
                                                    <?php foreach ($ref_jenis_pembayaran as $i => $key) : ?>
                                                        <option value="<?= $key->id ?>"><?= $key->nama ?> (potongan <?= $key->persen_potongan ?> %)</option>
                                                    <?php endforeach; ?>
                                                </select>
                                            </div>
                                            <div class="bordd bordd-b isi-cust py-1 px-3">
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text bg1 text-white fw-600" style="width: 80px;">
                                                            <i class="bx bx-dollar-circle mr-1"></i> Bayar
                                                        </span>
                                                    </div>
                                                    <div class="custom-file">
                                                        <input onchange="hitung_bayar();" type="text" id="total_bayar" class="form-control rupiah" placeholder="masukkan nominal pembayaran">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="bordd bordd-b isi-cust py-1 px-3">
                                                <div class="d-flex justify-content-between">
                                                    <div id="span_inv_dp" class="text-danger"></div>
                                                    <span onclick="inv_dp()" class="text-primary inv_dp">invoice DP</span>
                                                </div>
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text bg1 text-white fw-600" style="width: 80px;">
                                                            <i class="bx bx-dollar-circle mr-1"></i> DP
                                                        </span>
                                                    </div>
                                                    <div class="custom-file">
                                                        <input onchange="hitung_bayar();" readonly type="text" id="total_dp" class="form-control rupiah" placeholder="otomatis dari Invoice DP">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="bordd bordd-b isi-cust py-1 px-3 text-center">
                                                <small class="text-center d-block text-underline text-danger">Split Pembayaran</small>
                                                <div class="btn-group btn-group-example" role="group">
                                                    <button type="button" onclick="set_radio(this,'cek_split');is_split(1);hitung_bayar();" data-value="1" class="btn btn-outline-primary w-sm cek_split">Ya</button>
                                                    <button type="button" onclick="set_radio(this,'cek_split');is_split(0);hitung_bayar();" data-value="0" class="btn btn-outline-primary w-sm cek_split active">Tidak</button>
                                                </div>
                                            </div>
                                            <div class="bordd bordd-b select-cust py-1 px-3 is_split" style="display: none;">
                                                <select id="select_jenis_pembayaran_2" class="w-100 ph js-select2 form_focus">
                                                    <option selected disabled value="">Jenis Pembayaran Kedua</option>
                                                    <?php foreach ($ref_jenis_pembayaran as $key) : ?>
                                                        <option value="<?= $key->id ?>"><?= $key->nama ?> (potongan <?= $key->persen_potongan ?> %)</option>
                                                    <?php endforeach; ?>
                                                </select>
                                            </div>
                                            <div class="bordd bordd-b isi-cust py-1 px-3 is_split" style="display: none;">
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text bg1 text-white fw-600" style="width: 80px;">
                                                            <i class="bx bx-dollar-circle mr-1"></i> Split
                                                        </span>
                                                    </div>
                                                    <div class="custom-file">
                                                        <input type="text" class="form-control rupiah" onchange="hitung_bayar();" id="total_bayar_split" placeholder="masukkan nominal pembayaran">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="mt-md-4 mt-3 p-30c py-3 kembaliann row align-items-center mx-0">
                                                <div class="px-0 txt-kem col-md-6 col-4">Kembalian</div>
                                                <div class="px-0 col-md-6 text-right col-8">Rp <span class="input_bayar_banner">0</span></div>
                                            </div>
                                            <div class="row p-30c pb-md-3 pb-2 align-items-center">
                                            </div>
                                            <div class="row p-30c pt-0 align-items-center">
                                                <div class="col-md-7">
                                                    <p class="text-muted mb-0 lh-1"> Total</p>
                                                    <h5 class="font-size-20 m-0 font-weight-bold">Rp <span class="total_harga">0</span></h5>
                                                </div>
                                                <div class="col-md-5 mt-md-0 mt-2">
                                                    <button type="button" onclick="cek_bayar();" class="btn btn-primary rad-10 w-100">
                                                        <i class="mdi mdi-cash-multiple mr-1"></i> Bayar
                                                    </button>
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


            <!-- <footer class="footer l-0">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-sm-6">
                            © 2023 <?= data_sistem('nama') ?>.
                        </div>
                    </div>
                </div>
            </footer> -->
        </div>
        <!-- end main content-->

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
                    <h5 class="modal-title mt-0 text1">TRANSAKSI - KASIR IFIXIED</h5>
                    <button type="button" class="close" onclick="$('#modal_custom_2').modal('hide');">
                        <span class="text-white" aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="alert alert-danger">
                        <h3 class="mb-0 text-center text-danger">WAJIB DIBACAKAN/DICEK</h3>
                    </div>
                    <div class="card my-3">
                        <div class="card-body">
                            <div id="target_cek_dulu"></div>
                        </div>
                    </div>
                    <form onsubmit="event.preventDefault();do_submit(this);" enctype="multipart/form-data">
                        <div class="form-group">
                            <label>Nama Pelanggan <small class="text-danger">*) wajib</small></label>
                            <input type="text" required name="nama_pelanggan" autocomplete="off" placeholder="Nama Pelanggan" class="form-control">
                        </div>
                        <div class="form-group">
                            <label>No HP <small class="text-danger">*) wajib</small></label>
                            <input type="number" required name="no_hp" autocomplete="off" placeholder="Nomer HP Pelanggan" class="form-control">
                        </div>
                        <div class="form-group">
                            <label>Keterangan <small class="text-danger">*) opsional</small></label>
                            <textarea name="keterangan" rows="2" placeholder="Tulis keterangan jika diperlukan" class="form-control"></textarea>
                        </div>
                        <button type="submit" class="btn btn-block fw-600 btn-primary"><i class="fas fa-check"></i> PROSES TRANSAKSI</button>
                    </form>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div>

    <div id="modal_inv" class="modal fade" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="background-color: rgba(0, 0, 0, .5);">
        <div class="modal-dialog modal-md">
            <div style="border: 0;" class="modal-content shadow1">
                <div class="modal-header bg1">
                    <h5 class="modal-title mt-0 text1">Cek Invoice DP</h5>
                    <button type="button" class="close" onclick="$('#modal_inv').modal('hide');">
                        <span class="text-white" aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label>Nomer Invoice</label>
                        <input id="val_inv_dp" type="text" class="form-control" placeholder="INVDP ...">
                    </div>
                    <button onclick="cari_dp();" class="btn btn-primary">Cari</button>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div>

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