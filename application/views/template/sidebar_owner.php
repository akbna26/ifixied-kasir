<!-- ========== Left Sidebar Start ========== -->
<div class="vertical-menu">

    <div data-simplebar class="h-100 bg_image1">

        <!--- Sidemenu -->
        <div class="side-menu" id="sidebar-menu">
            <!-- Left Menu Start -->
            <ul class="metismenu list-unstyled" id="side-menu">
                <li class="menu-title" key="t-apps">Menu</li>
                <li class="<?= $this->uri->segment(2) == 'dashboard' ? 'mm-active' : '' ?> single-link">
                    <a href="<?= base_url('owner/dashboard') ?>" class="waves-effect">
                        <i class="bx bx-home-alt"></i>
                        <span>Dashboard</span>
                    </a>
                </li>
                <li class="<?= $this->uri->segment(2) == 'daftar_cabang' ? 'mm-active' : '' ?> single-link">
                    <a href="<?= base_url('owner/daftar_cabang') ?>" class="waves-effect">
                        <i class="bx bx-buildings"></i>
                        <span>Daftar Cabang</span>
                    </a>
                </li>
                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="bx bx-printer"></i>
                        <span>Manajemen Export</span>
                    </a>
                    <ul class="sub-menu <?= $this->uri->segment(2) == 'report_harian' ? 'mm-collapse mm-show' : '' ?>">
                        <li><a href="<?= base_url('owner/report_harian') ?>">Report Harian</a></li>
                    </ul>
                </li>

                <li class="<?= $this->uri->segment(2) == 'laporan_modal' ? 'mm-active' : '' ?> single-link">
                    <a href="<?= base_url('owner/laporan_modal') ?>" class="waves-effect">
                        <i class="bx bx-chart"></i>
                        <span>Sirkulasi Transaksi</span>
                    </a>
                </li>
                <li class="<?= $this->uri->segment(2) == 'sirkulasi_part' ? 'mm-active' : '' ?> single-link">
                    <a href="<?= base_url('owner/sirkulasi_part') ?>" class="waves-effect">
                        <i class="bx bx-store"></i>
                        <span>Sirkulasi Part</span>
                    </a>
                </li>
                <li class="<?= $this->uri->segment(2) == 'sirkulasi_acc' ? 'mm-active' : '' ?> single-link">
                    <a href="<?= base_url('owner/sirkulasi_acc') ?>" class="waves-effect">
                        <i class="bx bx-cube-alt"></i>
                        <span>Sirkulasi Acc</span>
                    </a>
                </li>

            </ul>
        </div>
        <!-- Sidebar -->
    </div>
</div>
<!-- Left Sidebar End -->