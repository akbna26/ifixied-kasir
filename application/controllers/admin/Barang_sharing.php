<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Barang_sharing extends MY_controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('admin/table_barang_sharing', 'table');
    }

    public function index()
    {
        $data = [
            'index' => 'admin/barang_sharing/index',
            'index_js' => 'admin/barang_sharing/index_js',
            'title' => 'Sharing Barang ke Cabang',
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
        $html = $this->load->view('admin/barang_sharing/form', $data, true);

        echo json_encode([
            'status' => 'success',
            'html' => $html,
        ]);
    }

    public function ubah()
    {
        $id = decode_id($this->input->post('id'));
        $data['id'] = $id;
        $data['data'] = $this->db->query("SELECT * from sharing where id='$id' and deleted is null ")->row();
        $data['ref_cabang'] = $this->db->query("SELECT * from ref_cabang where deleted is null")->result();
        $html = $this->load->view('admin/barang_sharing/form', $data, true);

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
        $tanggal = date('Y-m-d', strtotime($this->input->post('tanggal')));

        if (!empty($hapus)) {
            $cek = $this->db->query("SELECT * from sharing_detail where id_sharing='$id' and is_transfer='1' ")->result();
            if (!empty($cek)) {
                echo json_encode([
                    'status' => 'failed',
                    'msg' => 'Silahkan hapus detail sharing terlebih dahulu',
                ]);
                die;
            } else {
                $this->db->where('id', $id);
                $this->db->update('sharing', [
                    'deleted' => date('Y-m-d H:i:s'),
                ]);
            }
        } else {
            if (empty($id)) {
                $this->db->insert('sharing', [
                    'id_cabang' => $id_cabang,
                    'tanggal' => $tanggal,
                    'created' => date('Y-m-d H:i:s'),
                ]);
            } else {
                $this->db->where('id', $id);
                $this->db->update('sharing', [
                    'id_cabang' => $id_cabang,
                    'tanggal' => $tanggal,
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

        $cek = $this->db->query("SELECT * from sharing_detail where id_sharing='$id' and deleted is null ")->row();
        if (empty($cek)) {
            echo json_encode([
                'status' => 'failed',
                'msg' => 'data masih kosong, isi terlebih dahulu',
            ]);
        } else {

            $cek_stock = $this->db->query("SELECT c.stock as stock_barang, c.nama, b.* from sharing a 
                left join sharing_detail b on b.id_sharing=a.id and b.deleted is null 
                left join barang c on c.id=b.id_barang
                where a.id='$id' and a.deleted is null and b.stock > c.stock and b.is_transfer != '1'
            ")->row();

            if (!empty($cek_stock)) {
                echo json_encode([
                    'status' => 'failed',
                    'msg' => 'Stock dari Produk ' . $cek_stock->nama . ' hanya tersedia : ' . $cek_stock->stock_barang,
                ]);
                die;
            }

            $cek_cabang = $this->db->query("SELECT a.id_cabang, b.*, c.id as cek_ada, c.stock as stock_cabang, c.id as id_barang_cabang, d.stock as stock_real 
                from sharing a 
                left join sharing_detail b on b.id_sharing=a.id and b.deleted is null
                left join (select * from barang_cabang where deleted is null group by id_cabang, id_barang) c on c.id_cabang=a.id_cabang and c.id_barang=b.id_barang
                left join barang d on d.id=b.id_barang
                where a.id='$id' and a.deleted is null 
            ")->result();

            foreach ($cek_cabang as $dt) {
                if ($dt->cek_ada === null) {
                    $this->db->insert('barang_cabang', [
                        'id_cabang' => $dt->id_cabang,
                        'id_barang' => $dt->id_barang,
                        'stock' => $dt->stock,
                        'created' => date('Y-m-d H:i:s'),
                    ]);
                } else {
                    $this->db->where('id', $dt->id_barang_cabang);
                    $this->db->update('barang_cabang', [
                        'stock' => $dt->stock_cabang + $dt->stock,
                        'updated' => date('Y-m-d H:i:s'),
                    ]);
                }

                if (@$cek_cabang->is_transfer != '1') {
                    $this->db->where('id', $dt->id_barang);
                    $this->db->update('barang', [
                        'stock' => $dt->stock_real - $dt->stock,
                        'updated' => date('Y-m-d H:i:s'),
                    ]);
                }
            }

            $this->db->where('id', $id);
            $this->db->update('sharing', [
                'is_konfirmasi' => '1',
                'updated' => date('Y-m-d H:i:s'),
            ]);

            echo json_encode([
                'status' => 'success',
            ]);
        }
    }
}
