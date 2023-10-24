<!-- ========== Left Sidebar Start ========== -->
<div class="vertical-menu">

    <div data-simplebar class="h-100 bg_image1">

        <!--- Sidemenu -->
        <div class="side-menu" id="sidebar-menu">
            <!-- Left Menu Start -->
            <ul class="metismenu list-unstyled" id="side-menu">
                <li class="menu-title" key="t-apps">Menu</li>
                <li class="<?= $this->uri->segment(2) == 'dashboard' ? 'mm-active' : '' ?> single-link">
                    <a href="<?= base_url('accounting/dashboard') ?>" class="waves-effect fw-600">
                        <i class="bx bx-home-alt"></i>
                        <span>Dashboard</span>
                    </a>
                </li>            
                <li class="<?= $this->uri->segment(2) == 'laporan_modal' ? 'mm-active' : '' ?> single-link">
                    <a href="<?= base_url('accounting/laporan_modal') ?>" class="waves-effect fw-600">
                        <i class="bx bx-chart"></i>
                        <span>Sirkulasi Transaksi</span>
                    </a>
                </li>
                <li class="<?= $this->uri->segment(2) == 'sirkulasi_part' ? 'mm-active' : '' ?> single-link">
                    <a href="<?= base_url('accounting/sirkulasi_part') ?>" class="waves-effect fw-600">
                        <i class="bx bx-store"></i>
                        <span>Sirkulasi Part</span>
                    </a>
                </li>
                <li class="<?= $this->uri->segment(2) == 'sirkulasi_acc' ? 'mm-active' : '' ?> single-link">
                    <a href="<?= base_url('accounting/sirkulasi_acc') ?>" class="waves-effect fw-600">
                        <i class="bx bx-store"></i>
                        <span>Sirkulasi Acc</span>
                    </a>
                </li>
                <li class="<?= $this->uri->segment(2) == 'laporan_transaksi' ? 'mm-active' : '' ?> single-link">
                    <a href="<?= base_url('accounting/laporan_transaksi') ?>" class="waves-effect fw-600">
                        <i class="bx bx-store"></i>
                        <span>Transaksi Kasir</span>
                    </a>
                </li>
                <li class="<?= $this->uri->segment(2) == 'laporan_dp' ? 'mm-active' : '' ?> single-link">
                    <a href="<?= base_url('accounting/laporan_dp') ?>" class="waves-effect fw-600">
                        <i class="bx bx-store"></i>
                        <span>Transaksi DP</span>
                    </a>
                </li>
                <li class="<?= $this->uri->segment(2) == 'paylater' ? 'mm-active' : '' ?> single-link">
                    <a href="<?= base_url('accounting/paylater') ?>" class="waves-effect fw-600">
                        <i class="bx bx-store"></i>
                        <span>Market Place</span>
                    </a>
                </li>
                <li class="<?= $this->uri->segment(2) == 'kasbon' ? 'mm-active' : '' ?> single-link">
                    <a href="<?= base_url('accounting/kasbon') ?>" class="waves-effect fw-600">
                        <i class="bx bx-store"></i>
                        <span>Kasbon</span>
                    </a>
                </li>
                <li class="<?= $this->uri->segment(2) == 'setor_tunai' ? 'mm-active' : '' ?> single-link">
                    <a href="<?= base_url('accounting/setor_tunai') ?>" class="waves-effect fw-600">
                        <i class="bx bx-store"></i>
                        <span>Setor Tunai</span>
                    </a>
                </li>
                <li class="<?= $this->uri->segment(2) == 'modal_awal' ? 'mm-active' : '' ?> single-link">
                    <a href="<?= base_url('accounting/modal_awal') ?>" class="waves-effect fw-600">
                        <i class="bx bx-store"></i>
                        <span>Modal Awal Cash</span>
                    </a>
                </li>
                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="bx bx-file-find"></i>
                        <span>Log</span>
                    </a>
                    <ul class="sub-menu <?= $this->uri->segment(2) == 'log' ? 'mm-collapse mm-show' : '' ?>">
                        <li><a href="<?= base_url('accounting/cancel_transaksi') ?>">Transaksi Cancel</a></li>
                        <li><a href="<?= base_url('accounting/cancel_servis') ?>">Servis Cancel</a></li>
                    </ul>
                </li>
                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="bx bx-printer"></i>
                        <span>Manajemen Export</span>
                    </a>
                    <ul class="sub-menu <?= $this->uri->segment(2) == 'report_harian' ? 'mm-collapse mm-show' : '' ?>">
                        <li><a href="<?= base_url('accounting/report_harian') ?>">Report Harian</a></li>
                    </ul>
                </li>

            </ul>
        </div>
        <!-- Sidebar -->
    </div>
</div>
<!-- Left Sidebar End -->