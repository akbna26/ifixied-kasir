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

        $data['cabang'] = $this->db->query("SELECT * from ref_cabang where deleted is null order by nama")->result();
        $this->templates->load($data);
    }
}

/* End of file Dashboard.php */
