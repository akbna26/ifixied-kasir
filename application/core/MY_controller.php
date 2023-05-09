<?php

defined('BASEPATH') or exit('No direct script access allowed');

class MY_controller extends CI_Controller
{

    function __construct()
    {
        parent::__construct();

        $url = $this->uri->segment(1);
        if (!session('is_login')) {
            redirect('login/logout');
        } elseif (session('type') != $url && $url !='global' ) {
            if (!session('is_super')) {
                redirect('login/logout');
            }
        }

        $this->id_akun = session('id_akun');
        $this->id_otoritas = session('id_otoritas');
        $this->id_cabang = session('id_cabang');
        $this->nama = session('nama');
        $this->foto = session('foto');
        $this->provinsi = session('provinsi');
        $this->kabupaten = session('kabupaten');
        $this->kecamatan = session('kecamatan');
        $this->kelurahan = session('kelurahan');
        $this->username = session('username');
        $this->type = session('type');

        $this->foto = session('foto');
    }
}

/* End of file MY_controller.php */
