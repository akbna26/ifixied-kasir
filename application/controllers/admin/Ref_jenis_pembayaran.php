<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Ref_jenis_pembayaran extends MY_controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('admin/table_jenis_pembayaran', 'table');
    }

    public function index()
    {
        $data = [
            'index' => 'admin/ref_jenis_pembayaran/index',
            'index_js' => 'admin/ref_jenis_pembayaran/index_js',
            'title' => 'Referensi Jenis Pembayaran',
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
        $html = $this->load->view('admin/ref_jenis_pembayaran/form', $data, true);

        echo json_encode([
            'status' => 'success',
            'html' => $html,
        ]);
    }

    public function ubah()
    {
        $id = decode_id($this->input->post('id'));
        $data['id'] = $id;
        $data['data'] = $this->db->query("SELECT * from ref_jenis_pembayaran where id='$id' and deleted is null ")->row();
        $html = $this->load->view('admin/ref_jenis_pembayaran/form', $data, true);

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
        $no_rek = $this->input->post('no_rek');
        $persen_potongan = clear_koma($this->input->post('persen_potongan'));

        if (!empty($hapus)) {
            $this->db->where('id', $id);
            $this->db->update('ref_jenis_pembayaran', [
                'deleted' => date('Y-m-d H:i:s'),
            ]);
        } else {
            if (empty($id)) {
                $this->db->insert('ref_jenis_pembayaran', [
                    'nama' => $nama,
                    'no_rek' => $no_rek,
                    'persen_potongan' => $persen_potongan,
                    'created' => date('Y-m-d H:i:s'),
                ]);
            } else {
                $this->db->where('id', $id);
                $this->db->update('ref_jenis_pembayaran', [
                    'nama' => $nama,
                    'no_rek' => $no_rek,
                    'persen_potongan' => $persen_potongan,
                    'updated' => date('Y-m-d H:i:s'),
                ]);
            }
        }

        echo json_encode([
            'status' => 'success'
        ]);
    }
}
