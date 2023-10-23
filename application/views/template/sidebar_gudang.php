<!-- ========== Left Sidebar Start ========== -->
<div class="vertical-menu">

    <div data-simplebar class="h-100 bg_image1">

        <!--- Sidemenu -->
        <div class="side-menu" id="sidebar-menu">
            <!-- Left Menu Start -->
            <ul class="metismenu list-unstyled" id="side-menu">
                <li class="menu-title" key="t-apps">Menu</li>
                <li class="<?= $this->uri->segment(2) == 'dashboard' ? 'mm-active' : '' ?> single-link">
                    <a href="<?= base_url('gudang/dashboard') ?>" class="waves-effect fw-600">
                        <i class="bx bx-home-alt"></i>
                        <span>Dashboard</span>
                    </a>
                </li>
                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="bx bx-cube-alt"></i>
                        <span>Master Barang</span>
                    </a>
                    <ul class="sub-menu <?= $this->uri->segment(2) == 'barang' ? 'mm-collapse mm-show' : '' ?>">
                        <li><a href="<?= base_url('gudang/barang') ?>">List Barang</a></li>
                        <li><a href="<?= base_url('gudang/barang_restock') ?>">Restock Barang</a></li>
                        <li><a href="<?= base_url('gudang/barang_sharing') ?>">Sharing</a></li>
                    </ul>
                </li>
                <li class="<?= $this->uri->segment(2) == 'retur_barang' ? 'mm-active' : '' ?> single-link">
                    <a href="<?= base_url('gudang/retur_barang') ?>" class="waves-effect fw-600">
                        <i class="bx bx-check-shield"></i>
                        <span>Verifikasi Retur</span>
                    </a>
                </li>
                <li class="<?= $this->uri->segment(2) == 'sirkulasi_part' ? 'mm-active' : '' ?> single-link">
                    <a href="<?= base_url('gudang/sirkulasi_part') ?>" class="waves-effect fw-600">
                        <i class="bx bx-store"></i>
                        <span>Sirkulasi Part</span>
                    </a>
                </li>
                <li class="<?= $this->uri->segment(2) == 'sirkulasi_acc' ? 'mm-active' : '' ?> single-link">
                    <a href="<?= base_url('gudang/sirkulasi_acc') ?>" class="waves-effect fw-600">
                        <i class="bx bx-store"></i>
                        <span>Sirkulasi Acc</span>
                    </a>
                </li>

            </ul>
        </div>
        <!-- Sidebar -->
    </div>
</div>
<!-- Left Sidebar End -->