<!-- ========== Left Sidebar Start ========== -->
<div class="vertical-menu">

    <div data-simplebar class="h-100 bg_image1">

        <!--- Sidemenu -->
        <div class="side-menu" id="sidebar-menu">
            <!-- Left Menu Start -->
            <ul class="metismenu list-unstyled" id="side-menu">
                <li class="menu-title" key="t-apps">Menu</li>
                <li class="<?= $this->uri->segment(2) == 'dashboard' ? 'mm-active' : '' ?> single-link">
                    <a href="<?= base_url('cabang/dashboard') ?>" class="waves-effect">
                        <i class="bx bx-home-alt"></i>
                        <span>Dashboard</span>
                    </a>
                </li>
                <li class="<?= $this->uri->segment(2) == 'kasir_barang' ? 'mm-active' : '' ?> single-link">
                    <a href="<?= base_url('cabang/kasir_barang') ?>" class="waves-effect">
                        <i class="bx bx-cart"></i>
                        <span>Transaksi Penjualan</span>
                    </a>
                </li>
                <li class="<?= $this->uri->segment(2) == 'servis_berat' ? 'mm-active' : '' ?> single-link">
                    <a href="<?= base_url('cabang/servis_berat') ?>" class="waves-effect">
                        <i class="bx bx-wrench"></i>
                        <span>Service Berat</span>
                    </a>
                </li>
                <li class="<?= $this->uri->segment(2) == 'operasional' ? 'mm-active' : '' ?> single-link">
                    <a href="<?= base_url('cabang/operasional') ?>" class="waves-effect">
                        <i class="bx bx-notepad"></i>
                        <span>Operasional</span>
                    </a>
                </li>
                <li class="<?= $this->uri->segment(2) == 'kerugian' ? 'mm-active' : '' ?> single-link">
                    <a href="<?= base_url('cabang/kerugian') ?>" class="waves-effect">
                        <i class="bx bx-transfer-alt"></i>
                        <span>Kerugian</span>
                    </a>
                </li>
                <li class="<?= $this->uri->segment(2) == 'human_error' ? 'mm-active' : '' ?> single-link">
                    <a href="<?= base_url('cabang/human_error') ?>" class="waves-effect">
                        <i class="bx bx-tired"></i>
                        <span>Human Error</span>
                    </a>
                </li>
                <li class="<?= $this->uri->segment(2) == 'retur_barang' ? 'mm-active' : '' ?> single-link">
                    <a href="<?= base_url('cabang/retur_barang') ?>" class="waves-effect">
                        <i class="bx bx-sync"></i>
                        <span>Retur Barang</span>
                    </a>
                </li>
                <li class="<?= $this->uri->segment(2) == 'refund_barang' ? 'mm-active' : '' ?> single-link">
                    <a href="<?= base_url('cabang/refund_barang') ?>" class="waves-effect">
                        <i class="bx bx-money"></i>
                        <span>Refund/Klaim Garansi</span>
                    </a>
                </li>
                <li class="<?= $this->uri->segment(2) == 'kasir_dp' ? 'mm-active' : '' ?> single-link">
                    <a href="<?= base_url('cabang/kasir_dp') ?>" class="waves-effect">
                        <i class="bx bx-file"></i>
                        <span>DP Barang</span>
                    </a>
                </li>
                <li class="<?= $this->uri->segment(2) == 'kasbon' ? 'mm-active' : '' ?> single-link">
                    <a href="<?= base_url('cabang/kasbon') ?>" class="waves-effect">
                        <i class="bx bx-bitcoin"></i>
                        <span>Kasbon</span>
                    </a>
                </li>
                <li class="<?= $this->uri->segment(2) == 'setor_tunai' ? 'mm-active' : '' ?> single-link">
                    <a href="<?= base_url('cabang/setor_tunai') ?>" class="waves-effect">
                        <i class="bx bx-dollar-circle"></i>
                        <span>Setor Tunai</span>
                    </a>
                </li>
                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="bx bx-cube-alt"></i>
                        <span>Barang</span>
                    </a>
                    <ul class="sub-menu <?= in_array($this->uri->segment(2), ['barang', 'barang_sharing', 'barang_sharing_detail']) ? 'mm-collapse mm-show' : '' ?>">
                        <li><a href="<?= base_url('cabang/barang') ?>">Data Barang</a></li>
                        <li><a href="<?= base_url('cabang/barang_sharing') ?>">Riwayat ReStock</a></li>
                        <li><a href="<?= base_url('cabang/stock_cabang_lain') ?>">Stock Cabang Lain</a></li>
                    </ul>
                </li>

                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="bx bx-line-chart"></i>
                        <span>Laporan</span>
                    </a>
                    <ul class="sub-menu <?= $this->uri->segment(2) == 'laporan' ? 'mm-collapse mm-show' : '' ?>">
                        <li><a href="<?= base_url('cabang/laporan_mutasi') ?>">Mutasi Transaksi</a></li>
                        <li><a href="<?= base_url('cabang/laporan_transaksi') ?>">Rekap Transaksi</a></li>
                        <li><a href="<?= base_url('cabang/laporan_refund') ?>">Refund Barang</a></li>
                        <li><a href="<?= base_url('cabang/laporan_kerugian') ?>">Kerugian</a></li>
                        <li><a href="<?= base_url('cabang/laporan_servis') ?>">Servis</a></li>
                        <li><a href="<?= base_url('cabang/laporan_modal') ?>">Sirkulasi Transaksi</a></li>
                    </ul>
                </li>

            </ul>
        </div>
    </div>
</div>