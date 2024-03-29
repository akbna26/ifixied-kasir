<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Kerugian extends MY_controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('cabang/table_kerugian', 'table');
    }

    public function index()
    {
        $data = [
            'index' => 'cabang/kerugian/index',
            'index_js' => 'cabang/kerugian/index_js',
            'title' => 'Data Kerugian',
        ];

        $this->templates->load($data);
    }

    public function table()
    {
        echo $this->table->generate_table();
    }

    public function tambah()
    {
        $data['ref_jenis_pembayaran'] = $this->db->query("SELECT * from ref_jenis_pembayaran where deleted is null")->result();
        $html = $this->load->view('cabang/kerugian/form', $data, true);

        echo json_encode([
            'status' => 'success',
            'html' => $html,
        ]);
    }

    public function ubah()
    {
        $id = decode_id($this->input->post('id'));
        $data['id'] = $id;
        $data['data'] = $this->db->query("SELECT * from kerugian where id='$id' and deleted is null ")->row();
        $data['ref_jenis_pembayaran'] = $this->db->query("SELECT * from ref_jenis_pembayaran where deleted is null")->result();
        $html = $this->load->view('cabang/kerugian/form', $data, true);

        echo json_encode([
            'status' => 'success',
            'html' => $html,
        ]);
    }

    public function do_submit()
    {
        cek_post();
        $id = decode_id($this->input->post('id'));
        $hapus = $this->input->post('hapus');

        $id_pembayaran = $this->input->post('id_pembayaran');
        $tanggal = date('Y-m-d', strtotime($this->input->post('tanggal')));
        $keterangan = $this->input->post('keterangan');
        $jumlah = clear_koma($this->input->post('jumlah'));

        if (!empty($hapus)) {
            $this->db->where('id', $id);
            $this->db->update('kerugian', [
                'deleted' => date('Y-m-d H:i:s'),
            ]);
        } else {
            if (empty($id)) {
                $this->db->insert('kerugian', [
                    'id_cabang' => $this->id_cabang,
                    'id_pembayaran' => $id_pembayaran,
                    'tanggal' => $tanggal,
                    'keterangan' => $keterangan,
                    'jumlah' => $jumlah,
                    'created' => date('Y-m-d H:i:s'),
                ]);
            } else {
                $this->db->where('id', $id);
                $this->db->update('kerugian', [
                    'id_pembayaran' => $id_pembayaran,
                    'tanggal' => $tanggal,
                    'keterangan' => $keterangan,
                    'jumlah' => $jumlah,
                    'updated' => date('Y-m-d H:i:s'),
                ]);
            }
        }

        echo json_encode([
            'status' => 'success'
        ]);
    }
}
