<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Laporan_mutasi extends MY_controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('cabang/table_mutasi', 'table');
    }

    public function index()
    {
        $data = [
            'index' => 'cabang/laporan_mutasi/index',
            'index_js' => 'cabang/laporan_mutasi/index_js',
            'title' => 'Mutasi Servis Ringan',
        ];

        $this->templates->load($data);
    }

    public function table()
    {
        echo $this->table->generate_table();
    }
}
