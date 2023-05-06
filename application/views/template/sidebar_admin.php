<!-- ========== Left Sidebar Start ========== -->
<div class="vertical-menu">

    <div data-simplebar class="h-100">

        <!--- Sidemenu -->
        <div class="side-menu" id="sidebar-menu">
            <!-- Left Menu Start -->
            <ul class="metismenu list-unstyled" id="side-menu">
            <li class="menu-title" key="t-apps">Menu</li>
                <li class="<?= $this->uri->segment(2) == 'dashboard' ? 'mm-active' : '' ?> single-link">
                    <a href="<?= base_url('admin/dashboard') ?>" class="waves-effect fw-600">
                        <i class="bx bx-home-alt"></i>
                        <span>Dashboard</span>
                    </a>
                </li>
                
                <li class="menu-title" key="t-apps">Setting</li>
                
                <li class="<?= $this->uri->segment(2) == 'ref_cabang' ? 'mm-active' : '' ?> single-link">
                    <a href="<?= base_url('admin/ref_cabang') ?>" class="waves-effect fw-600">
                        <i class="bx bx-building-house"></i>
                        <span>Referensi Cabang</span>
                    </a>
                </li>
                <li class="<?= $this->uri->segment(2) == 'data_user' ? 'mm-active' : '' ?> single-link">
                    <a href="<?= base_url('admin/data_user') ?>" class="waves-effect fw-600">
                        <i class="bx bxs-user"></i>
                        <span>Data User</span>
                    </a>
                </li>
                <li class="<?= $this->uri->segment(2) == 'informasi' ? 'mm-active' : '' ?> single-link">
                    <a href="<?= base_url('admin/informasi') ?>" class="waves-effect fw-600">
                        <i class="bx bx-info-circle"></i>
                        <span>Informasi</span>
                    </a>
                </li>
                <!-- <li class="<?= $this->uri->segment(2) == 'note' ? 'mm-active' : '' ?> single-link">
                    <a href="<?= base_url('admin/note') ?>" class="waves-effect fw-600">
                        <i class="fas fa-sticky-note"></i>
                        <span>Sticky Note</span>
                    </a>
                </li> -->
            </ul>
        </div>
        <!-- Sidebar -->
    </div>
</div>
<!-- Left Sidebar End -->