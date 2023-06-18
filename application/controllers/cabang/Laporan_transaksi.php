<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Laporan_transaksi extends MY_controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('cabang/table_laporan_transaksi', 'table');
    }

    public function index()
    {
        $data = [
            'index' => 'cabang/laporan_transaksi/index',
            'index_js' => 'cabang/laporan_transaksi/index_js',
            'title' => 'Laporan Transaksi Barang',
        ];

        $data['ref_tahun'] = $this->db->query("SELECT * from ref_tahun where deleted is null")->result();
        $data['ref_bulan'] = $this->db->query("SELECT * from ref_bulan where deleted is null")->result();

        $this->templates->load($data);
    }

    public function table()
    {
        echo $this->table->generate_table();
    }

    public function detail()
    {
        $id = decode_id($this->input->post('id'));
        $data['id'] = $id;

        $data['transaksi'] = $this->db->query("SELECT a.*, b.nama as cabang, b.lokasi as cabang_alamat, c.nama as pegawai, d.nama as jenis_bayar, e.nama as jenis_bayar_2
            from transaksi a 
            left join ref_cabang b on b.id=a.id_cabang
            left join pegawai c on c.id=a.id_pegawai
            left join ref_jenis_pembayaran d on d.id=a.id_jenis_pembayaran
            left join ref_jenis_pembayaran e on e.id=a.id_jenis_pembayaran_2
            where a.id='$id' and a.deleted is null 
        ")->row();

        $data['detail'] = $this->db->query("SELECT a.*, b.nama as barang from transaksi_detail a 
            left join barang b on b.id=a.id_barang
            where a.id_transaksi='$id' and a.deleted is null 
        ")->result();

        $html = $this->load->view('cabang/laporan_transaksi/detail', $data, true);

        echo json_encode([
            'status' => 'success',
            'html' => $html,
        ]);
    }
}
