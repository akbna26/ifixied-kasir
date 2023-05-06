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
        $this->id_pemilik = session('id_pemilik');
        $this->nama = session('nama');
        $this->username = session('username');
        $this->foto = session('foto');
    }
}

/* End of file MY_controller.php */
