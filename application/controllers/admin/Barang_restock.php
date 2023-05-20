<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Barang_restock extends MY_controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('admin/table_barang_restock', 'table');
    }

    public function index()
    {
        $data = [
            'index' => 'admin/barang_restock/index',
            'index_js' => 'admin/barang_restock/index_js',
            'title' => 'Data Restock',
        ];

        $this->templates->load($data);
    }

    public function table()
    {
        echo $this->table->generate_table();
    }

    public function tambah()
    {
        $data['ref_kategori'] = $this->db->query("SELECT * from ref_kategori where deleted is null")->result();
        $html = $this->load->view('admin/barang_restock/form', $data, true);

        echo json_encode([
            'status' => 'success',
            'html' => $html,
        ]);
    }

    public function ubah()
    {
        $id = decode_id($this->input->post('id'));
        $data['id'] = $id;
        $data['data'] = $this->db->query("SELECT a.* from barang_stock a where a.id='$id' and a.deleted is null ")->row();
        $data['ref_kategori'] = $this->db->query("SELECT * from ref_kategori where deleted is null")->result();
        $html = $this->load->view('admin/barang_restock/form', $data, true);

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

        $id_barang = $this->input->post('id_barang');
        $stock = clear_koma($this->input->post('stock'));
        $tanggal_restock = date('Y-m-d', strtotime($this->input->post('tanggal_restock')));

        if (!empty($hapus)) {
            $this->db->where('id', $id);
            $this->db->update('barang_stock', [
                'deleted' => date('Y-m-d H:i:s'),
            ]);
        } else {
            $barang = $this->db->query("SELECT * from barang where id='$id_barang' and deleted is null ")->row();

            if (empty($id)) {
                $this->db->insert('barang_stock', [
                    'id_barang' => $id_barang,
                    'stock' => $stock,
                    'tanggal_restock' => $tanggal_restock,
                    'created' => date('Y-m-d H:i:s'),
                ]);

                $this->db->where('id', $id_barang);
                $this->db->update('barang', [
                    'stock' => $barang->stock + $stock,
                    'tanggal_restock' => $tanggal_restock,
                ]);

                insert_log('tambah restock', $stock);
            } else {
                $stock_lama = $this->db->query("SELECT * from barang_stock where id='$id' and deleted is null ")->row();      
                
                $this->db->where('id', $id);
                $this->db->update('barang_stock', [
                    'stock' => $stock,
                    'tanggal_restock' => $tanggal_restock,
                    'updated' => date('Y-m-d H:i:s'),
                ]);
                
                $this->db->where('id', $id_barang);
                $this->db->update('barang', [
                    'stock' => ($barang->stock - $stock_lama->stock) + $stock,
                    'tanggal_restock' => $tanggal_restock,
                ]);

                insert_log('ubah restock', $stock);
            }
        }

        echo json_encode([
            'status' => 'success'
        ]);
    }
}
