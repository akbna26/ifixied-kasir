<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Report_harian extends MY_controller
{

    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        $data = [
            'index' => 'accounting/report_harian/index',
            'index_js' => 'accounting/report_harian/index_js',
            'title' => 'Report Harian Cabang',
        ];

        $where = '';
        if (session('type') == 'owner_cabang') {
            $row = $this->db->query("SELECT * from data_user where id='$this->id_akun' ")->row();
            $where .= "AND id in ($row->id_cabang_multi)";
        }
        $data['cabang'] = $this->db->query("SELECT * from ref_cabang where deleted is null $where order by nama")->result();
        $this->templates->load($data);
    }
}

/* End of file Dashboard.php */
