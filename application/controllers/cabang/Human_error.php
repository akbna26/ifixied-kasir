<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Human_error extends MY_controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('cabang/table_human_error', 'table');
    }

    public function index()
    {
        $data = [
            'index' => 'cabang/human_error/index',
            'index_js' => 'cabang/human_error/index_js',
            'title' => 'Human Error',
        ];

        $this->templates->load($data);
    }

    public function table()
    {
        echo $this->table->generate_table();
    }

    public function tambah()
    {
        $data['barang'] = $this->db->query("SELECT a.id, a.barcode, a.harga_modal, a.nama as nm_barang from barang a 
            join barang_cabang b on b.id_barang=a.id and b.id_cabang='$this->id_cabang' and b.deleted is null
            where a.deleted is null
        ")->result();
        $data['pegawai'] = $this->db->query("SELECT * from pegawai where id_cabang='$this->id_cabang' and deleted is null")->result();
        $html = $this->load->view('cabang/human_error/form', $data, true);

        echo json_encode([
            'status' => 'success',
            'html' => $html,
        ]);
    }

    public function ubah()
    {
        $id = decode_id($this->input->post('id'));
        $data['id'] = $id;
        $data['data'] = $this->db->query("SELECT * from human_error where id='$id' and deleted is null ")->row();
        $data['pegawai'] = $this->db->query("SELECT * from pegawai where id_cabang='$this->id_cabang' and deleted is null")->result();
        $data['barang'] = $this->db->query("SELECT a.id, a.barcode, a.harga_modal, a.nama as nm_barang from barang a 
            join barang_cabang b on b.id_barang=a.id and b.id_cabang='$this->id_cabang' and b.deleted is null
            where a.deleted is null
        ")->result();
        $html = $this->load->view('cabang/human_error/form', $data, true);

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

        $id_barang = $this->input->post('id_barang');
        $id_pegawai = $this->input->post('id_pegawai');
        $harga_modal = clear_koma($this->input->post('harga_modal'));
        $keterangan = $this->input->post('keterangan');
        $tanggal = date('Y-m-d', strtotime($this->input->post('tanggal')));

        if (!empty($hapus)) {
            $this->db->where('id', $id);
            $this->db->update('human_error', [
                'deleted' => date('Y-m-d H:i:s'),
            ]);
        } else {
            if (empty($id)) {
                $this->db->insert('human_error', [
                    'id_cabang' => $this->id_cabang,
                    'id_pegawai' => $id_pegawai,
                    'id_barang' => $id_barang,
                    'keterangan' => $keterangan,
                    'tanggal' => $tanggal,
                    'modal' => $harga_modal,
                    'created' => date('Y-m-d H:i:s'),
                ]);
            } else {
                $this->db->where('id', $id);
                $this->db->update('human_error', [
                    'id_pegawai' => $id_pegawai,
                    'id_barang' => $id_barang,
                    'keterangan' => $keterangan,
                    'tanggal' => $tanggal,
                    'modal' => $harga_modal,
                    'updated' => date('Y-m-d H:i:s'),
                ]);
            }
        }

        echo json_encode([
            'status' => 'success'
        ]);
    }
}
