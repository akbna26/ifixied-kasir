<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Barang extends MY_controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('cabang/table_stock_cabang', 'table_stock_cabang');
    }

    public function index()
    {
        $data = [
            'index' => 'cabang/stock_cabang/index',
            'index_js' => 'cabang/stock_cabang/index_js',
            'title' => 'Stock Cabang',
        ];

        $data['ref_kategori'] = $this->db->query("SELECT * from ref_kategori where deleted is null")->result();

        $this->templates->load($data);
    }

    public function table_stock_cabang()
    {
        echo $this->table_stock_cabang->generate_table();
    }
}
