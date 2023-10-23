<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Pilih_servis_berat extends MY_controller
{

    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        $data = [
            'index' => 'servis/pilih_servis_berat/index',
            'index_js' => 'servis/pilih_servis_berat/index_js',
            'title' => 'Daftar Cabang',
        ];

        $user = $this->db->query("SELECT * from data_user where id='$this->id_akun' ")->row();
        $where = '';
        $where .= "AND id in ($user->id_cabang_multi) ";
        $data['cabang'] = $this->db->query("SELECT * from ref_cabang where deleted is null $where ")->result();

        $this->templates->load($data);
    }
}

/* End of file Dashboard.php */
