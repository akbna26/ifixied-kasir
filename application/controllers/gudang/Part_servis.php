<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Part_servis extends MY_controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('gudang/table_part_servis', 'table');
    }

    public function index()
    {
        $data = [
            'index' => 'gudang/part_servis/index',
            'index_js' => 'gudang/part_servis/index_js',
            'title' => 'Verifikasi Part Servis',
        ];

        $this->templates->load($data);
    }

    public function verifikasi()
    {
        $id = decode_id($this->input->post('id'));

        $data['data'] = $this->db->query("SELECT b.*, a.tgl_refund, a.alasan_refund, aa.nama as nm_cabang, c.barcode, c.nama as nm_barang
            FROM servis_berat a
            left join ref_cabang aa on aa.id=a.id_cabang
            left join servis_detail_part b on b.id_servis=a.id
            left join barang c on c.id=b.id_barang
            where a.deleted is null and a.is_refund='1' and b.id is not null and b.id='$id'
        ")->row();

        $html = $this->load->view('gudang/part_servis/verifikasi', $data, true);

        echo json_encode([
            'status' => 'success',
            'html' => $html,
        ]);
    }

    public function table()
    {
        echo $this->table->generate_table();
    }

    public function do_verifikasi()
    {
        cek_post();
        $id = decode_id($this->input->post('id'));

        $alasan_tolak = $this->input->post('alasan_tolak');
        $verif_refund = $this->input->post('verif_refund');

        $this->db->where('id', $id);
        $this->db->update('servis_detail_part', [
            'alasan_tolak' => $alasan_tolak,
            'verif_refund' => $verif_refund,
            'tgl_verifikasi' => date('Y-m-d'),
            'updated' => date('Y-m-d H:i:s'),
        ]);

        echo json_encode([
            'status' => 'success'
        ]);
    }
}
