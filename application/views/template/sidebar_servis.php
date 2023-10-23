<!-- ========== Left Sidebar Start ========== -->
<div class="vertical-menu">

    <div data-simplebar class="h-100 bg_image1">

        <!--- Sidemenu -->
        <div class="side-menu" id="sidebar-menu">
            <!-- Left Menu Start -->
            <ul class="metismenu list-unstyled" id="side-menu">
                <li class="menu-title" key="t-apps">Menu</li>
                <li class="<?= $this->uri->segment(2) == 'dashboard' ? 'mm-active' : '' ?> single-link">
                    <a href="<?= base_url('servis/dashboard') ?>" class="waves-effect fw-600">
                        <i class="bx bx-home-alt"></i>
                        <span>Dashboard</span>
                    </a>
                </li>
                <li class="<?= $this->uri->segment(2) == 'servis_berat' ? 'mm-active' : '' ?> single-link">
                    <a href="<?= base_url('servis/pilih_servis_berat') ?>" class="waves-effect">
                        <i class="bx bx-wrench"></i>
                        <span>Servis Berat</span>
                    </a>
                </li>
            </ul>
        </div>
        <!-- Sidebar -->
    </div>
</div>
<!-- Left Sidebar End -->