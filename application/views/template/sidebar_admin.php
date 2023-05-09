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

                <li class="<?= $this->uri->segment(2) == 'barang' ? 'mm-active' : '' ?> single-link">
                    <a href="<?= base_url('admin/barang') ?>" class="waves-effect fw-600">
                        <i class="bx bx-cube-alt"></i>
                        <span>Barang</span>
                    </a>
                </li>

                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="bx bx-cart"></i>
                        <span>Transaksi</span>
                    </a>
                    <ul class="sub-menu <?= $this->uri->segment(2) == 'transaksi' ? 'mm-collapse mm-show' : '' ?>">
                        <li><a href="<?= base_url('admin/restock_barang') ?>">Restock Barang</a></li>
                    </ul>
                </li>

                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="bx bxs-user-check"></i>
                        <span>Pegawai</span>
                    </a>
                    <ul class="sub-menu <?= $this->uri->segment(2) == 'pegawai' ? 'mm-collapse mm-show' : '' ?>">
                        <li><a href="<?= base_url('admin/pegawai') ?>">Daftar Pegawai</a></li>
                        <li><a href="<?= base_url('admin/setting_pegawai') ?>">Profit Teknisi</a></li>
                    </ul>
                </li>

                <li class="menu-title" key="t-apps">Setting</li>
                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="bx bx-data"></i>
                        <span>Referensi Data</span>
                    </a>
                    <ul class="sub-menu <?= $this->uri->segment(2) == 'referensi' ? 'mm-collapse mm-show' : '' ?>">
                        <li><a href="<?= base_url('admin/ref_cabang') ?>">Data Cabang</a></li>
                        <li><a href="<?= base_url('admin/ref_kategori') ?>">Kategori Barang</a></li>
                        <li><a href="<?= base_url('admin/ref_progres_servis') ?>">Progress Service</a></li>
                        <li><a href="<?= base_url('admin/ref_tindakan') ?>">Tindakan Service</a></li>
                        <li><a href="<?= base_url('admin/ref_jabatan') ?>">Jabatan / Posisi</a></li>
                        <li><a href="<?= base_url('admin/ref_jenis_pembayaran') ?>">Jenis Pembayaran</a></li>
                    </ul>
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