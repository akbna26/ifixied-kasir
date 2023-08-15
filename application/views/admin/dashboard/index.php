<style>
    .grafik_container {
        height: 500px;
        width: 100%;
    }

    .grafik_container2 {
        height: 450px;
        width: 100%;
    }
</style>

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

<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <div id="grafik1" class="grafik_container"></div>
            </div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="card">
            <div class="card-body">
                <div class="card-header bg1">
                    <h5 class="text-center text-white fw-600">10 PRODUK TERLARIS</h5>
                </div>
                <table class="table table-bordered table-sm table-striped text-center">
                    <thead class="bg1 text-white fw-600">
                        <tr>
                            <td>NO</td>
                            <td>PRODUK</td>
                            <td>QTY TERJUAL</td>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>1</td>
                            <td>iPhone 13 Pro Max</td>
                            <td>301</td>
                        </tr>
                        <tr>
                            <td>2</td>
                            <td>MacBook Pro (M1)</td>
                            <td>287</td>
                        </tr>
                        <tr>
                            <td>3</td>
                            <td>Apple Watch Series 7</td>
                            <td>250</td>
                        </tr>
                        <tr>
                            <td>4</td>
                            <td>AirPods Pro</td>
                            <td>244</td>
                        </tr>
                        <tr>
                            <td>5</td>
                            <td>iPad Pro (generasi terbaru)</td>
                            <td>200</td>
                        </tr>
                        <tr>
                            <td>6</td>
                            <td>Apple Pencil (generasi terbaru)</td>
                            <td>170</td>
                        </tr>
                        <tr>
                            <td>7</td>
                            <td>MagSafe Charger</td>
                            <td>155</td>
                        </tr>
                        <tr>
                            <td>8</td>
                            <td>Apple TV 4K</td>
                            <td>140</td>
                        </tr>
                        <tr>
                            <td>9</td>
                            <td>Magic Keyboard (untuk Mac)</td>
                            <td>140</td>
                        </tr>
                        <tr>
                            <td>10</td>
                            <td>Lightning to USB-C Cable</td>
                            <td>120</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="card">
            <div class="card-body">
                <div class="card-header bg1">
                    <h5 class="text-center text-white fw-600">PRODUK TERLARIS DI CABANG</h5>
                </div>
                <table class="table table-bordered table-sm table-striped text-center">
                    <thead class="bg1 text-white fw-600">
                        <tr>
                            <td>NO</td>
                            <td>CABANG</td>
                            <td>PRODUK</td>
                            <td>QTY TERJUAL</td>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>1</td>
                            <td>Office</td>
                            <td>iPhone 13 Pro Max</td>
                            <td>228</td>
                        </tr>
                        <tr>
                            <td>2</td>
                            <td>Tangerang</td>
                            <td>MacBook Pro (M1)</td>
                            <td>287</td>
                        </tr>
                        <tr>
                            <td>3</td>
                            <td>Pekanbaru</td>
                            <td>Apple Watch Series 7</td>
                            <td>250</td>
                        </tr>
                        <tr>
                            <td>4</td>
                            <td>Bogor</td>
                            <td>AirPods Pro</td>
                            <td>244</td>
                        </tr>
                        <tr>
                            <td>5</td>
                            <td>Jatinangor</td>
                            <td>iPad Pro (generasi terbaru)</td>
                            <td>200</td>
                        </tr>
                        <tr>
                            <td>6</td>
                            <td>Madiun</td>
                            <td>Apple Pencil (generasi terbaru)</td>
                            <td>170</td>
                        </tr>
                        <tr>
                            <td>7</td>
                            <td>Bandung</td>
                            <td>MagSafe Charger</td>
                            <td>155</td>
                        </tr>
                        <tr>
                            <td>8</td>
                            <td>Bekasi</td>
                            <td>Apple TV 4K</td>
                            <td>140</td>
                        </tr>
                        <tr>
                            <td>9</td>
                            <td>Depok</td>
                            <td>Magic Keyboard (untuk Mac)</td>
                            <td>140</td>
                        </tr>
                        <tr>
                            <td>10</td>
                            <td>Semarang</td>
                            <td>Lightning to USB-C Cable</td>
                            <td>120</td>
                        </tr>
                        <tr>
                            <td>11</td>
                            <td>Solo</td>
                            <td>Lightning to USB-C Cable</td>
                            <td>80</td>
                        </tr>
                        <tr>
                            <td>12</td>
                            <td>Bantul</td>
                            <td>Lightning to USB-C Cable</td>
                            <td>70</td>
                        </tr>
                        <tr>
                            <td>13</td>
                            <td>Sleman</td>
                            <td>Lightning to USB-C Cable</td>
                            <td>187</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>