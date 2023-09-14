<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Laporan_kerugian extends MY_controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('cabang/table_laporan_kerugian', 'table');
    }

    public function index()
    {
        $data = [
            'index' => 'cabang/laporan_kerugian/index',
            'index_js' => 'cabang/laporan_kerugian/index_js',
            'title' => 'Laporan Kerugian',
        ];

        $this->templates->load($data);
    }

    public function table()
    {
        echo $this->table->generate_table();
    }
}
