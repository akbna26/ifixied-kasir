<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Operasional extends MY_controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('cabang/table_operasional', 'table');
    }

    public function index()
    {
        $data = [
            'index' => 'cabang/operasional/index',
            'index_js' => 'cabang/operasional/index_js',
            'title' => 'Data Operasional',
        ];

        $this->templates->load($data);
    }

    public function table()
    {
        echo $this->table->generate_table();
    }

    public function tambah()
    {
        $data['ref_operasional'] = $this->db->query("SELECT * from ref_operasional where deleted is null")->result();
        $data['ref_jenis_pembayaran'] = $this->db->query("SELECT * from ref_jenis_pembayaran where deleted is null")->result();
        $html = $this->load->view('cabang/operasional/form', $data, true);

        echo json_encode([
            'status' => 'success',
            'html' => $html,
        ]);
    }

    public function ubah()
    {
        $id = decode_id($this->input->post('id'));
        $data['id'] = $id;
        $data['data'] = $this->db->query("SELECT * from operasional where id='$id' and deleted is null ")->row();
        $data['ref_operasional'] = $this->db->query("SELECT * from ref_operasional where deleted is null")->result();
        $data['ref_jenis_pembayaran'] = $this->db->query("SELECT * from ref_jenis_pembayaran where deleted is null")->result();
        $html = $this->load->view('cabang/operasional/form', $data, true);

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

        $id_operasional = $this->input->post('id_operasional');
        $id_pembayaran = $this->input->post('id_pembayaran');
        $tanggal = date('Y-m-d', strtotime($this->input->post('tanggal')));
        $keterangan = $this->input->post('keterangan');
        $jumlah = clear_koma($this->input->post('jumlah'));

        if (!empty($hapus)) {
            $this->db->where('id', $id);
            $this->db->update('operasional', [
                'deleted' => date('Y-m-d H:i:s'),
            ]);
        } else {
            if (empty($id)) {
                $this->db->insert('operasional', [
                    'id_cabang' => $this->id_cabang,
                    'id_operasional' => $id_operasional,
                    'id_pembayaran' => $id_pembayaran,
                    'tanggal' => $tanggal,
                    'keterangan' => $keterangan,
                    'jumlah' => $jumlah,
                    'created' => date('Y-m-d H:i:s'),
                ]);
            } else {
                $this->db->where('id', $id);
                $this->db->update('operasional', [
                    'id_operasional' => $id_operasional,
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

    public function form_refund()
    {
        $id = decode_id($this->input->post('id'));
        $data['id'] = $id;
        $data['data'] = $this->db->query("SELECT * from operasional where id='$id' and deleted is null ")->row();

        $html = $this->load->view('cabang/operasional/form_refund', $data, true);

        echo json_encode([
            'status' => 'success',
            'html' => $html,
        ]);
    }

    public function do_refund()
    {
        cek_post();
        $id = decode_id($this->input->post('id'));
        $keterangan = $this->input->post('keterangan');

        $this->db->where('id', $id);
        $this->db->update('operasional', [
            'updated' => date('Y-m-d H:i:s'),
            'tgl_refund' => date('Y-m-d'),
            'is_refund' => '1',
            'keterangan_refund' => $keterangan,
        ]);

        echo json_encode([
            'status' => 'success'
        ]);
    }
}
