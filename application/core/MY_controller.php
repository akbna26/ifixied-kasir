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
        } elseif (session('type') != $url && $url != 'global') {
            if (!session('is_super')) {
                redirect('login/logout');
            } else {
                if ($url != 'super_admin') {
                    redirect('login/logout');
                }
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

    public function list_bulan()
    {
        $data = [
            'Januari' => 1,
            'Februari' => 2,
            'Maret' => 3,
            'April' => 4,
            'Mei' => 5,
            'Juni' => 6,
            'Juli' => 7,
            'Agustus' => 8,
            'September' => 9,
            'Oktober' => 10,
            'November' => 11,
            'Desember' => 12,
        ];

        return $data;
    }

    public function list_tahun()
    {
        $data = [2023, 2024, 2025];
        return $data;
    }
}

/* End of file MY_controller.php */
