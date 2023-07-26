<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Paylater extends MY_controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('admin/table_paylater', 'table');
    }

    public function index()
    {
        $data = [
            'index' => 'admin/paylater/index',
            'index_js' => 'admin/paylater/index_js',
            'title' => 'Transaksi Paylater',
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

    public function verif()
    {
        $id = decode_id($this->input->post('id'));
        $data['id'] = $id;
        $html = $this->load->view('admin/paylater/verif', $data, true);

        echo json_encode([
            'status' => 'success',
            'html' => $html,
        ]);
    }

    public function do_submit()
    {
        cek_post();
        $id = decode_id($this->input->post('id'));

        $potongan = clear_koma($this->input->post('potongan'));

        $this->db->where('id', $id);
        $this->db->update('transaksi', [
            'potongan' => $potongan,
            'verif_paylater' => '1',
            'updated' => date('Y-m-d H:i:s'),
        ]);

        echo json_encode([
            'status' => 'success'
        ]);
    }
}
