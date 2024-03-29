<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Kasbon extends MY_controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('cabang/table_kasbon', 'table');
    }

    public function index()
    {
        $data = [
            'index' => 'cabang/kasbon/index',
            'index_js' => 'cabang/kasbon/index_js',
            'title' => 'Data Kasbon',
        ];

        $this->templates->load($data);
    }

    public function table()
    {
        echo $this->table->generate_table();
    }

    public function tambah()
    {
        $data['pegawai'] = $this->db->query("SELECT * from pegawai where id_cabang='$this->id_cabang' and deleted is null")->result();
        $data['ref_jenis_pembayaran'] = $this->db->query("SELECT * from ref_jenis_pembayaran where deleted is null")->result();
        $html = $this->load->view('cabang/kasbon/form', $data, true);

        echo json_encode([
            'status' => 'success',
            'html' => $html,
        ]);
    }

    public function ubah()
    {
        $id = decode_id($this->input->post('id'));
        $data['id'] = $id;
        $row = $this->db->query("SELECT * from kasbon where id='$id' and deleted is null ")->row();
        $data['data'] = $row;
        $data['pegawai'] = $this->db->query("SELECT * from pegawai where id_cabang='$row->id_cabang' and deleted is null")->result();
        $data['ref_jenis_pembayaran'] = $this->db->query("SELECT * from ref_jenis_pembayaran where deleted is null")->result();
        $html = $this->load->view('cabang/kasbon/form', $data, true);

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

        $id_pegawai = $this->input->post('id_pegawai');
        $id_pembayaran = $this->input->post('id_pembayaran');
        $tanggal = date('Y-m-d', strtotime($this->input->post('tanggal')));
        $keterangan = $this->input->post('keterangan');
        $jumlah = clear_koma($this->input->post('jumlah'));

        if (!empty($hapus)) {
            $this->db->where('id', $id);
            $this->db->update('kasbon', [
                'deleted' => date('Y-m-d H:i:s'),
            ]);
        } else {
            if (empty($id)) {
                $this->db->insert('kasbon', [
                    'id_cabang' => $this->id_cabang,
                    'id_pegawai' => $id_pegawai,
                    'id_pembayaran' => $id_pembayaran,
                    'tanggal' => $tanggal,
                    'jumlah' => $jumlah,
                    'keterangan' => $keterangan,
                    'created' => date('Y-m-d H:i:s'),
                ]);
            } else {
                $this->db->where('id', $id);
                $this->db->update('kasbon', [
                    'id_cabang' => $this->id_cabang,
                    'id_pegawai' => $id_pegawai,
                    'id_pembayaran' => $id_pembayaran,
                    'tanggal' => $tanggal,
                    'jumlah' => $jumlah,
                    'keterangan' => $keterangan,
                    'updated' => date('Y-m-d H:i:s'),
                ]);
            }
        }

        echo json_encode([
            'status' => 'success'
        ]);
    }
}
