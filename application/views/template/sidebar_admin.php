<!-- ========== Left Sidebar Start ========== -->
<div class="vertical-menu">

    <div data-simplebar class="h-100 bg_image1">

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

                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="bx bx-cube-alt"></i>
                        <span>Master Barang</span>
                    </a>
                    <ul class="sub-menu <?= $this->uri->segment(2) == 'barang' ? 'mm-collapse mm-show' : '' ?>">
                        <li><a href="<?= base_url('admin/barang') ?>">List Barang</a></li>
                        <li><a href="<?= base_url('admin/barang_restock') ?>">Restock Barang</a></li>
                        <li><a href="<?= base_url('admin/barang_sharing') ?>">Sharing</a></li>
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

                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="bx bx-line-chart"></i>
                        <span>Laporan</span>
                    </a>
                    <ul class="sub-menu <?= $this->uri->segment(2) == 'laporan' ? 'mm-collapse mm-show' : '' ?>">
                        <li><a href="<?= base_url('admin/laporan_servis') ?>">Servis</a></li>
                        <li><a href="<?= base_url('admin/laporan_transaksi') ?>">Transaksi Kasir</a></li>
                        <li><a href="<?= base_url('admin/laporan_dp') ?>">Transaksi DP</a></li>
                        <li><a href="<?= base_url('admin/laporan_refund') ?>">Refund Barang</a></li>
                        <li><a href="<?= base_url('admin/retur_barang') ?>">Retur Barang</a></li>
                        <li><a href="<?= base_url('admin/operasional') ?>">Operasional</a></li>
                        <li><a href="<?= base_url('admin/paylater') ?>">Market Place</a></li>
                        <li><a href="<?= base_url('admin/kasbon') ?>">Kasbon</a></li>
                        <li><a href="<?= base_url('admin/kerugian') ?>">Kerugian</a></li>
                        <li><a href="<?= base_url('admin/setor_tunai') ?>">Setor Tunai</a></li>
                        <li><a href="<?= base_url('admin/laporan_modal') ?>">Sirkulasi Transaksi</a></li>
                    </ul>
                </li>

                <li class="<?= $this->uri->segment(2) == 'modal_awal' ? 'mm-active' : '' ?> single-link">
                    <a href="<?= base_url('admin/modal_awal') ?>" class="waves-effect">
                        <i class="bx bx-select-multiple"></i>
                        <span>Modal Awal Cash</span>
                    </a>
                </li>

                <li class="<?= $this->uri->segment(2) == 'servis_berat' ? 'mm-active' : '' ?> single-link">
                    <a href="<?= base_url('admin/servis_berat') ?>" class="waves-effect">
                        <i class="bx bx-wrench"></i>
                        <span>Servis Berat</span>
                    </a>
                </li>

                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="bx bx-file-find"></i>
                        <span>Log</span>
                    </a>
                    <ul class="sub-menu <?= $this->uri->segment(2) == 'log' ? 'mm-collapse mm-show' : '' ?>">
                        <li><a href="<?= base_url('admin/cancel_transaksi') ?>">Transaksi Cancel</a></li>
                        <li><a href="<?= base_url('admin/cancel_servis') ?>">Servis Cancel</a></li>
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
                        <li><a href="<?= base_url('admin/ref_supplier') ?>">Data Supplier</a></li>
                        <li><a href="<?= base_url('admin/ref_operasional') ?>">Jenis Operasional</a></li>
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
            </ul>
        </div>
        <!-- Sidebar -->
    </div>
</div>
<!-- Left Sidebar End -->