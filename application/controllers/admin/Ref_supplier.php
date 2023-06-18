<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Ref_supplier extends MY_controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('admin/table_supplier', 'table');
    }

    public function index()
    {
        $data = [
            'index' => 'admin/ref_supplier/index',
            'index_js' => 'admin/ref_supplier/index_js',
            'title' => 'Referensi Data Supplier',
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
        $html = $this->load->view('admin/ref_supplier/form', $data, true);

        echo json_encode([
            'status' => 'success',
            'html' => $html,
        ]);
    }

    public function ubah()
    {
        $id = decode_id($this->input->post('id'));
        $data['id'] = $id;
        $data['data'] = $this->db->query("SELECT * from ref_supplier where id='$id' and deleted is null ")->row();
        $html = $this->load->view('admin/ref_supplier/form', $data, true);

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

        if (!empty($hapus)) {
            $this->db->where('id', $id);
            $this->db->update('ref_supplier', [
                'deleted' => date('Y-m-d H:i:s'),
            ]);
        } else {
            if (empty($id)) {
                $this->db->insert('ref_supplier', [
                    'nama' => $nama,
                    'created' => date('Y-m-d H:i:s'),
                ]);
            } else {
                $this->db->where('id', $id);
                $this->db->update('ref_supplier', [
                    'nama' => $nama,
                    'updated' => date('Y-m-d H:i:s'),
                ]);
            }
        }

        echo json_encode([
            'status' => 'success'
        ]);
    }
}
