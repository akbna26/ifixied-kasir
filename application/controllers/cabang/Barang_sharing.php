<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Barang_sharing extends MY_controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('cabang/table_barang_sharing', 'table');
    }

    public function index()
    {
        $data = [
            'index' => 'cabang/barang_sharing/index',
            'index_js' => 'cabang/barang_sharing/index_js',
            'title' => 'Sharing Barang ke Cabang',
        ];

        $this->templates->load($data);
    }

    public function table()
    {
        echo $this->table->generate_table();
    }
}
