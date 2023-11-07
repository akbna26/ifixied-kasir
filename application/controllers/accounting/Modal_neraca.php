<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Modal_neraca extends MY_controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('accounting/table_modal_neraca', 'table');
    }

    public function index()
    {
        $data = [
            'index' => 'accounting/modal_neraca/index',
            'index_js' => 'accounting/modal_neraca/index_js',
            'title' => 'Modal Neraca Aset Tidak Bergerak',
        ];

        $data['ref_cabang'] = $this->db->query("SELECT * from ref_cabang where deleted is null order by nama")->result();

        $this->templates->load($data);
    }

    public function table()
    {
        echo $this->table->generate_table();
    }

    public function tambah()
    {
        $data['ref_cabang'] = $this->db->query("SELECT * from ref_cabang where deleted is null order by nama")->result();
        $data['ref_jenis_modal'] = $this->db->query("SELECT * from ref_jenis_modal where deleted is null")->result();
        $html = $this->load->view('accounting/modal_neraca/form', $data, true);

        echo json_encode([
            'status' => 'success',
            'html' => $html,
        ]);
    }

    public function ubah()
    {
        $id = decode_id($this->input->post('id'));
        $data['id'] = $id;
        $data['data'] = $this->db->query("SELECT * from modal_neraca where id='$id' and deleted is null ")->row();
        $data['ref_cabang'] = $this->db->query("SELECT * from ref_cabang where deleted is null order by nama")->result();
        $data['ref_jenis_modal'] = $this->db->query("SELECT * from ref_jenis_modal where deleted is null")->result();
        $html = $this->load->view('accounting/modal_neraca/form', $data, true);

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
        $id_jenis = $this->input->post('id_jenis');
        $nama = $this->input->post('nama');
        $tanggal = date('Y-m-d', strtotime($this->input->post('tanggal')));
        $harga = clear_koma($this->input->post('harga'));
        $jumlah = clear_koma($this->input->post('jumlah'));
        $total = clear_koma($this->input->post('total'));

        if (!empty($hapus)) {
            $this->db->where('id', $id);
            $this->db->update('modal_neraca', [
                'deleted' => date('Y-m-d H:i:s'),
            ]);
        } else {
            if (empty($id)) {
                $this->db->insert('modal_neraca', [
                    'id_cabang' => $id_cabang,
                    'id_jenis' => $id_jenis,
                    'nama' => $nama,
                    'tanggal' => $tanggal,
                    'harga' => $harga,
                    'jumlah' => $jumlah,
                    'total' => $total,
                    'created' => date('Y-m-d H:i:s'),
                ]);
            } else {
                $this->db->where('id', $id);
                $this->db->update('modal_neraca', [
                    'id_cabang' => $id_cabang,
                    'id_jenis' => $id_jenis,
                    'nama' => $nama,
                    'tanggal' => $tanggal,
                    'harga' => $harga,
                    'jumlah' => $jumlah,
                    'total' => $total,
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

        $html = $this->load->view('accounting/modal_neraca/form_refund', $data, true);

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
