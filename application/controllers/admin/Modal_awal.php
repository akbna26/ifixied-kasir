<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Modal_awal extends MY_controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('admin/table_modal_awal', 'table');
    }

    public function index()
    {
        $data = [
            'index' => 'admin/modal_awal/index',
            'index_js' => 'admin/modal_awal/index_js',
            'title' => 'Modal Awal',
        ];

        $this->templates->load($data);
    }

    public function table()
    {
        echo $this->table->generate_table();
    }

    public function tambah()
    {
        $data['ref_cabang'] = $this->db->query("SELECT * from ref_cabang where deleted is null")->result();
        $data['ref_jenis_pembayaran'] = $this->db->query("SELECT * from ref_jenis_pembayaran where deleted is null")->result();
        $html = $this->load->view('admin/modal_awal/form', $data, true);

        echo json_encode([
            'status' => 'success',
            'html' => $html,
        ]);
    }

    public function ubah()
    {
        $id = decode_id($this->input->post('id'));
        $data['id'] = $id;
        $data['data'] = $this->db->query("SELECT * from modal_awal where id='$id' and deleted is null ")->row();
        $data['ref_cabang'] = $this->db->query("SELECT * from ref_cabang where deleted is null")->result();
        $data['ref_jenis_pembayaran'] = $this->db->query("SELECT * from ref_jenis_pembayaran where deleted is null")->result();
        $html = $this->load->view('admin/modal_awal/form', $data, true);

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

        $id_cabang = $this->input->post('id_cabang');
        $id_pembayaran = $this->input->post('id_pembayaran');
        $modal = clear_koma($this->input->post('modal'));
        $tanggal = date('Y-m-d', strtotime($this->input->post('tanggal')));

        if (!empty($hapus)) {
            $this->db->where('id', $id);
            $this->db->update('modal_awal', [
                'deleted' => date('Y-m-d H:i:s'),
            ]);
        } else {
            if (empty($id)) {
                $this->db->insert('modal_awal', [
                    'id_cabang' => $id_cabang,
                    'id_pembayaran' => $id_pembayaran,
                    'modal' => $modal,
                    'tanggal' => $tanggal,
                    'created' => date('Y-m-d H:i:s'),
                ]);
            } else {
                $this->db->where('id', $id);
                $this->db->update('modal_awal', [
                    'id_cabang' => $id_cabang,
                    'id_pembayaran' => $id_pembayaran,
                    'modal' => $modal,
                    'tanggal' => $tanggal,
                    'updated' => date('Y-m-d H:i:s'),
                ]);
            }
        }

        echo json_encode([
            'status' => 'success'
        ]);
    }
}
