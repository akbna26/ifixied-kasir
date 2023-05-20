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

    public function tambah()
    {
        $data['ref_cabang'] = $this->db->query("SELECT * from ref_cabang where deleted is null")->result();
        $data['ref_jabatan'] = $this->db->query("SELECT * from ref_jabatan where deleted is null")->result();
        $html = $this->load->view('admin/laporan_transaksi/form', $data, true);

        echo json_encode([
            'status' => 'success',
            'html' => $html,
        ]);
    }

    public function ubah()
    {
        $id = decode_id($this->input->post('id'));
        $data['id'] = $id;
        $data['data'] = $this->db->query("SELECT * from pegawai where id='$id' and deleted is null ")->row();
        $data['ref_cabang'] = $this->db->query("SELECT * from ref_cabang where deleted is null")->result();
        $data['ref_jabatan'] = $this->db->query("SELECT * from ref_jabatan where deleted is null")->result();
        $html = $this->load->view('admin/laporan_transaksi/form', $data, true);

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

        $nama = $this->input->post('nama');
        $id_cabang = $this->input->post('id_cabang');
        $id_jabatan = $this->input->post('id_jabatan');

        if (!empty($hapus)) {
            $this->db->where('id', $id);
            $this->db->update('pegawai', [
                'deleted' => date('Y-m-d H:i:s'),
            ]);
        } else {
            if (empty($id)) {
                $this->db->insert('pegawai', [
                    'nama' => $nama,
                    'id_cabang' => $id_cabang,
                    'id_jabatan' => $id_jabatan,
                    'created' => date('Y-m-d H:i:s'),
                ]);
            } else {
                $this->db->where('id', $id);
                $this->db->update('pegawai', [
                    'nama' => $nama,
                    'id_cabang' => $id_cabang,
                    'id_jabatan' => $id_jabatan,
                    'updated' => date('Y-m-d H:i:s'),
                ]);
            }
        }

        echo json_encode([
            'status' => 'success'
        ]);
    }
}
