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

            </ul>
        </div>
        <!-- Sidebar -->
    </div>
</div>
<!-- Left Sidebar End -->