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

    public function do_submit()
    {
        cek_post();
        $id = decode_id($this->input->post('id'));
        $hapus = $this->input->post('hapus');

        if (!empty($hapus)) {
            $this->db->where('id', $id);
            $this->db->update('transaksi', [
                'deleted' => date('Y-m-d H:i:s'),
                'tgl_cancel' => date('Y-m-d H:i:s'),
                'is_cancel' => '1',
            ]);

            $row = $this->db->query("SELECT * from transaksi where id='$id' ")->row();
            $list_barang = $this->db->query("SELECT * from transaksi_detail where id_transaksi='$id' and deleted is null ")->result();
            foreach ($list_barang as $key) {
                $penambah = $key->qty;
                $this->db->query("UPDATE barang_cabang set stock=stock+$penambah 
                    where id_barang='$key->id_barang' and id_cabang='$row->id_cabang'
                ");
            }
        }

        echo json_encode([
            'status' => 'success'
        ]);
    }
}
