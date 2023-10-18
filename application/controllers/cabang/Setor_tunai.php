<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Setor_tunai extends MY_controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('cabang/table_setor_tunai', 'table');
    }

    public function index()
    {
        $data = [
            'index' => 'cabang/setor_tunai/index',
            'index_js' => 'cabang/setor_tunai/index_js',
            'title' => 'Data Setor Tunai',
        ];

        $this->templates->load($data);
    }

    public function table()
    {
        echo $this->table->generate_table();
    }

    public function tambah()
    {
        $data['ref_jenis_pembayaran'] = $this->db->query("SELECT * from ref_jenis_pembayaran where deleted is null and id in (8,9)")->result();
        $html = $this->load->view('cabang/setor_tunai/form', $data, true);

        echo json_encode([
            'status' => 'success',
            'html' => $html,
        ]);
    }

    public function ubah()
    {
        $id = decode_id($this->input->post('id'));
        $data['id'] = $id;
        $data['ref_jenis_pembayaran'] = $this->db->query("SELECT * from ref_jenis_pembayaran where deleted is null and id in (8,9)")->result();
        $data['data'] = $this->db->query("SELECT * from kasbon where id='$id' and deleted is null ")->row();
        $html = $this->load->view('cabang/setor_tunai/form', $data, true);

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
        $jumlah = clear_koma($this->input->post('jumlah'));

        if (!empty($hapus)) {
            $this->db->where('id', $id);
            $this->db->update('setor_tunai', [
                'deleted' => date('Y-m-d H:i:s'),
            ]);
        } else {
            if (empty($id)) {
                $this->db->insert('setor_tunai', [
                    'id_cabang' => $this->id_cabang,
                    'id_pembayaran' => $id_pembayaran,
                    'tanggal' => $tanggal,
                    'nominal' => $jumlah,
                    'created' => date('Y-m-d H:i:s'),
                ]);
            } else {
                $this->db->where('id', $id);
                $this->db->update('setor_tunai', [
                    'id_pembayaran' => $id_pembayaran,
                    'tanggal' => $tanggal,
                    'nominal' => $jumlah,
                    'updated' => date('Y-m-d H:i:s'),
                ]);
            }
        }

        echo json_encode([
            'status' => 'success'
        ]);
    }

    public function do_konfirmasi()
    {
        cek_post();
        $id = decode_id($this->input->post('id'));

        $this->db->where('id', $id);
        $this->db->update('setor_tunai', [
            'updated' => date('Y-m-d H:i:s'),
            'is_konfirmasi' => '1',
        ]);

        echo json_encode([
            'status' => 'success'
        ]);
    }

}
