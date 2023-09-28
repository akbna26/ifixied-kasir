<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Cancel_servis extends MY_controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('admin/table_cancel_servis', 'table');
    }

    public function index()
    {
        $data = [
            'index' => 'admin/cancel_servis/index',
            'index_js' => 'admin/cancel_servis/index_js',
            'title' => 'Laporan Cancel Servis',
        ];

        $data['ref_cabang'] = $this->db->query("SELECT * from ref_cabang where deleted is null")->result();
        
        $this->templates->load($data);
    }

    public function table()
    {
        echo $this->table->generate_table();
    }
}
