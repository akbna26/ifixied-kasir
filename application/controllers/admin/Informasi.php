<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Informasi extends MY_controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('admin/table_informasi', 'table');
    }

    public function index()
    {
        $data = [
            'index' => 'admin/informasi/index',
            'index_js' => 'admin/informasi/index_js',
            'title' => 'Informasi untuk pengguna',
        ];

        $this->templates->load($data);
    }

    public function table()
    {
        echo $this->table->generate_table();
    }

    public function tambah()
    {
        $data = [];
        $html = $this->load->view('admin/informasi/form', $data, true);

        echo json_encode([
            'status' => 'success',
            'html' => $html,
        ]);
    }

    public function ubah()
    {
        $id = decode_id($this->input->post('id'));
        $data['id'] = $id;
        $data['data'] = $this->db->query("SELECT * from informasi where id='$id' and deleted is null ")->row();
        $html = $this->load->view('admin/informasi/form', $data, true);

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

        $judul = $this->input->post('judul');
        $tanggal = date('Y-m-d', strtotime($this->input->post('tanggal')));
        $keterangan = $this->input->post('keterangan');

        if (!empty($hapus)) {
            $this->db->where('id', $id);
            $this->db->update('informasi', [
                'deleted' => date('Y-m-d H:i:s'),
            ]);
        } else {
            if (empty($id)) {
                $this->db->insert('informasi', [
                    'judul' => $judul,
                    'tanggal' => $tanggal,
                    'keterangan' => $keterangan,
                    'created' => date('Y-m-d H:i:s'),
                ]);
            } else {
                $this->db->where('id', $id);
                $this->db->update('informasi', [
                    'judul' => $judul,
                    'tanggal' => $tanggal,
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
