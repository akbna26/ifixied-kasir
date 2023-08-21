<!-- ========== Left Sidebar Start ========== -->
<div class="vertical-menu">

    <div data-simplebar class="h-100 bg_image1">

        <!--- Sidemenu -->
        <div class="side-menu" id="sidebar-menu">
            <!-- Left Menu Start -->
            <ul class="metismenu list-unstyled" id="side-menu">
                <li class="menu-title" key="t-apps">Menu</li>
                <li class="<?= $this->uri->segment(2) == 'dashboard' ? 'mm-active' : '' ?> single-link">
                    <a href="<?= base_url('cabang/dashboard') ?>" class="waves-effect fw-600">
                        <i class="bx bx-home-alt"></i>
                        <span>Dashboard</span>
                    </a>
                </li>
                <li class="<?= $this->uri->segment(2) == 'kasir_barang' ? 'mm-active' : '' ?> single-link">
                    <a href="<?= base_url('cabang/kasir_barang') ?>" class="waves-effect fw-600">
                        <i class="bx bx-cart"></i>
                        <span>Transaksi Penjualan</span>
                    </a>
                </li>
                <li class="<?= $this->uri->segment(2) == 'servis_berat' ? 'mm-active' : '' ?> single-link">
                    <a href="<?= base_url('cabang/servis_berat') ?>" class="waves-effect fw-600">
                        <i class="bx bx-wrench"></i>
                        <span>Service Berat</span>
                    </a>
                </li>
                <li class="<?= $this->uri->segment(2) == 'operasional' ? 'mm-active' : '' ?> single-link">
                    <a href="<?= base_url('cabang/operasional') ?>" class="waves-effect fw-600">
                        <i class="bx bx-notepad"></i>
                        <span>Operasional</span>
                    </a>
                </li>
                <li class="<?= $this->uri->segment(2) == 'retur_barang' ? 'mm-active' : '' ?> single-link">
                    <a href="<?= base_url('cabang/retur_barang') ?>" class="waves-effect fw-600">
                        <i class="bx bx-sync"></i>
                        <span>Retur Barang</span>
                    </a>
                </li>
                <li class="<?= $this->uri->segment(2) == 'refund_barang' ? 'mm-active' : '' ?> single-link">
                    <a href="<?= base_url('cabang/refund_barang') ?>" class="waves-effect fw-600">
                        <i class="bx bx-money"></i>
                        <span>Refund Barang</span>
                    </a>
                </li>
                <li class="<?= $this->uri->segment(2) == 'kasir_dp' ? 'mm-active' : '' ?> single-link">
                    <a href="<?= base_url('cabang/kasir_dp') ?>" class="waves-effect fw-600">
                        <i class="bx bx-file"></i>
                        <span>DP Barang</span>
                    </a>
                </li>
                <li class="<?= $this->uri->segment(2) == 'kasbon' ? 'mm-active' : '' ?> single-link">
                    <a href="<?= base_url('cabang/kasbon') ?>" class="waves-effect fw-600">
                        <i class="bx bx-bitcoin"></i>
                        <span>Kasbon</span>
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
                    </ul>
                </li>

            </ul>
        </div>
        <!-- Sidebar -->
    </div>
</div>
<!-- Left Sidebar End -->