<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Barang_sharing_detail extends MY_controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('admin/table_barang_sharing_detail', 'table');
    }

    public function index($id)
    {
        $data = [
            'index' => 'admin/barang_sharing_detail/index',
            'index_js' => 'admin/barang_sharing_detail/index_js',
            'title' => 'Detail Sharing',
        ];

        $id = decode_id($id);
        $data['id'] = $id;
        $data['row'] = $this->db->query("SELECT a.*, b.nama from sharing a 
            left join ref_cabang b on b.id=a.id_cabang
        where a.id='$id' ")->row();

        $this->templates->load($data);
    }

    public function table()
    {
        echo $this->table->generate_table();
    }

    public function tambah()
    {
        $data['ref_kategori'] = $this->db->query("SELECT * from ref_kategori where deleted is null")->result();
        $html = $this->load->view('admin/barang_sharing_detail/form', $data, true);

        echo json_encode([
            'status' => 'success',
            'html' => $html,
        ]);
    }

    public function ubah()
    {
        $id = decode_id($this->input->post('id'));
        $data['id'] = $id;
        $data['data'] = $this->db->query("SELECT * from sharing_detail where id='$id' and deleted is null ")->row();
        $data['ref_kategori'] = $this->db->query("SELECT * from ref_kategori where deleted is null")->result();
        $html = $this->load->view('admin/barang_sharing_detail/form', $data, true);

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

        $id_sharing = decode_id($this->input->post('id_sharing'));
        $id_barang = $this->input->post('id_barang');
        $stock = clear_koma($this->input->post('stock'));

        if (!empty($hapus)) {
            $this->db->where('id', $id);
            $this->db->update('sharing_detail', [
                'deleted' => date('Y-m-d H:i:s'),
            ]);
        } else {
            if (empty($id)) {

                $cek_sudah = $this->db->query("SELECT * from sharing_detail where id_sharing='$id_sharing' and id_barang='$id_barang' ")->row();
                if (!empty($cek_sudah)) {
                    echo json_encode([
                        'status' => 'failed',
                        'msg' => 'barang sudah di input sebelumnya',
                    ]);
                    die;
                }

                $this->db->insert('sharing_detail', [
                    'id_sharing' => $id_sharing,
                    'id_barang' => $id_barang,
                    'stock' => $stock,
                    'created' => date('Y-m-d H:i:s'),
                ]);
            } else {

                $this->db->where('id', $id);
                $this->db->update('sharing_detail', [
                    'stock' => $stock,
                    'updated' => date('Y-m-d H:i:s'),
                ]);
            }
        }

        echo json_encode([
            'status' => 'success'
        ]);
    }
}
