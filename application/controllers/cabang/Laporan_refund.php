<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Laporan_refund extends MY_controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('cabang/table_laporan_refund', 'table');
    }

    public function index()
    {
        $data = [
            'index' => 'cabang/laporan_refund/index',
            'index_js' => 'cabang/laporan_refund/index_js',
            'title' => 'Laporan Refund',
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

    public function detail()
    {
        $id = decode_id($this->input->post('id'));
        $data['id'] = $id;

        $data['transaksi'] = $this->db->query("SELECT a.*, b.no_invoice, b.pelanggan, c.nama as cabang, c.lokasi as cabang_alamat
            from refund a 
            left join transaksi b on b.id=a.id_transaksi
            left join ref_cabang c on c.id=a.id_cabang
            where a.id='$id' and a.deleted is null 
        ")->row();

        $data['detail'] = $this->db->query("SELECT a.*, 
            case when a.pembayaran=1 then 'CASH' when a.pembayaran=2 then 'TRANSFER' end as nm_pembayaran,
            b.nama as barang, c.nama as nm_klaim, d.nama as nm_pengganti
            from refund_detail a 
            left join barang b on b.id=a.id_barang
            left join ref_status_refund c on c.id=a.id_klaim
            left join barang d on d.id=a.id_pengganti
            where a.id_refund='$id' and a.deleted is null 
        ")->result();

        $html = $this->load->view('cabang/laporan_refund/detail', $data, true);

        echo json_encode([
            'status' => 'success',
            'html' => $html,
        ]);
    }
}
