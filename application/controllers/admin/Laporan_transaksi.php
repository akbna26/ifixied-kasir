<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Laporan_transaksi extends MY_controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('admin/table_laporan_transaksi', 'table');
    }

    public function index()
    {
        $data = [
            'index' => 'admin/laporan_transaksi/index',
            'index_js' => 'admin/laporan_transaksi/index_js',
            'title' => 'Laporan Transaksi Barang',
        ];

        $data['ref_cabang'] = $this->db->query("SELECT * from ref_cabang where deleted is null")->result();
        $data['ref_tahun'] = $this->db->query("SELECT * from ref_tahun where deleted is null")->result();
        $data['ref_bulan'] = $this->db->query("SELECT * from ref_bulan where deleted is null")->result();

        $this->templates->load($data);
    }

    public function table()
    {
        echo $this->table->generate_table();
    }
}
