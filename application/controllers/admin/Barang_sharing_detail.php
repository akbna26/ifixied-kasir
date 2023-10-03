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

        $barang_id = explode(',', $this->input->post('barang_id'));
        $barang_qty = explode(',', $this->input->post('barang_qty'));

        $barang_in = '';
        if (!empty($barang_id)) {
            for ($i = 0; $i < count($barang_id); $i++) {
                $arr_insert[] = [
                    'id_sharing' => $id_sharing,
                    'id_barang' => $barang_id[$i],
                    'stock' => $barang_qty[$i],
                    'created' => date('Y-m-d H:i:s'),
                ];
                if ($i + 1 == count($barang_id)) {
                    $barang_in .= $barang_id[$i];
                } else {
                    $barang_in .= $barang_id[$i] . ',';
                }
            }
        }

        if (!empty($hapus)) {
            $this->db->where('id', $id);
            $this->db->update('sharing_detail', [
                'deleted' => date('Y-m-d H:i:s'),
            ]);
            $row = $this->db->query("SELECT * from sharing_detail where id='$id' ")->row();
            if ($row->is_transfer == 1) {
                $this->db->query("UPDATE barang_cabang set stock=(stock + $row->stock) where id='$row->id_asal' ");
            }
        } else {
            if (empty($id)) {

                $cek_sudah = $this->db->query("SELECT * from sharing_detail where id_sharing='$id_sharing' and id_barang in ($barang_in) and deleted is null ")->row();
                if (!empty($cek_sudah)) {
                    echo json_encode([
                        'status' => 'failed',
                        'msg' => 'barang sudah di input sebelumnya',
                    ]);
                    die;
                }

                if (count($arr_insert) > 0) {
                    $this->db->insert_batch('sharing_detail', $arr_insert);
                }
            }
        }

        echo json_encode([
            'status' => 'success'
        ]);
    }
}
