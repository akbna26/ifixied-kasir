<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Barang extends MY_controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('admin/table_barang', 'table');
        $this->load->model('admin/table_stock_cabang', 'table_stock_cabang');
    }

    public function index()
    {
        $data = [
            'index' => 'admin/barang/index',
            'index_js' => 'admin/barang/index_js',
            'title' => 'Daftar Barang',
        ];

        $data['ref_kategori'] = $this->db->query("SELECT * from ref_kategori where deleted is null")->result();

        $this->templates->load($data);
    }

    public function stock_cabang()
    {
        $data = [
            'index' => 'admin/barang/stock_cabang',
            'index_js' => 'admin/barang/stock_cabang_js',
            'title' => 'Stock Cabang',
        ];

        $data['ref_cabang'] = $this->db->query("SELECT * from ref_cabang where deleted is null")->result();
        $data['ref_kategori'] = $this->db->query("SELECT * from ref_kategori where deleted is null")->result();

        $this->templates->load($data);
    }

    public function table()
    {
        echo $this->table->generate_table();
    }

    public function table_stock_cabang()
    {
        echo $this->table_stock_cabang->generate_table();
    }

    public function tambah()
    {
        $data['ref_cabang'] = $this->db->query("SELECT * from ref_cabang where deleted is null")->result();
        $data['ref_kategori'] = $this->db->query("SELECT * from ref_kategori where deleted is null")->result();
        $data['ref_supplier'] = $this->db->query("SELECT * from ref_supplier where deleted is null")->result();
        $html = $this->load->view('admin/barang/form', $data, true);

        echo json_encode([
            'status' => 'success',
            'html' => $html,
        ]);
    }

    public function ubah()
    {
        $id = decode_id($this->input->post('id'));
        $data['id'] = $id;
        $data['data'] = $this->db->query("SELECT * from barang where id='$id' and deleted is null ")->row();
        $data['ref_cabang'] = $this->db->query("SELECT * from ref_cabang where deleted is null")->result();
        $data['ref_kategori'] = $this->db->query("SELECT * from ref_kategori where deleted is null")->result();
        $data['ref_supplier'] = $this->db->query("SELECT * from ref_supplier where deleted is null")->result();
        $html = $this->load->view('admin/barang/form', $data, true);

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

        $id_kategori = $this->input->post('id_kategori');
        $id_supplier = $this->input->post('id_supplier');
        $barcode = $this->input->post('barcode');
        $nama = $this->input->post('nama');
        $harga_modal = clear_koma($this->input->post('harga_modal'));
        $harga_jual = clear_koma($this->input->post('harga_jual'));
        $stock = clear_koma($this->input->post('stock'));
        $keterangan = $this->input->post('keterangan');
        $tanggal_restock = date('Y-m-d', strtotime($this->input->post('tanggal_restock')));

        if (!empty($hapus)) {
            $this->db->where('id', $id);
            $this->db->update('barang', [
                'deleted' => date('Y-m-d H:i:s'),
            ]);
        } else {

            if ($_FILES['gambar']['name']) {
                $path = 'uploads/foto_produk/';
                if (!file_exists(FCPATH . $path)) mkdir($path, 0777, TRUE);
                $config['upload_path'] = $path;
                $config['allowed_types'] = 'jpg|png|jpeg';
                $config['max_size'] = 5000; // 0 = no limit || default max 2048 kb
                $config['overwrite'] = false;
                $config['remove_space'] = true;
                $config['encrypt_name'] = true;
                $this->load->library('upload', $config);
                $this->upload->initialize($config);
                $run = $this->upload->do_upload('gambar'); // name inputnya

                if (!$run) {
                    echo json_encode([
                        'status' => 'failed',
                        'msg' => $this->upload->display_errors()
                    ]);
                    die;
                }

                $zdata = ['upload_data' => $this->upload->data()]; // get data
                $zfile = $zdata['upload_data']['full_path']; // get file path
                chmod($zfile, 0777); // linux wajib
                $gambar = $path . $zdata['upload_data']['file_name']; // nama file
                $this->db->set('gambar', $gambar);
            }

            if (empty($id)) {
                $this->db->insert('barang', [
                    'id_kategori' => $id_kategori,
                    'id_supplier' => $id_supplier,
                    'barcode' => $barcode,
                    'nama' => $nama,
                    'harga_modal' => $harga_modal,
                    'harga_jual' => $harga_jual,
                    'stock' => $stock,
                    'keterangan' => $keterangan,
                    'tanggal_restock' => $tanggal_restock,
                    'created' => date('Y-m-d H:i:s'),
                ]);

                $id_barang = $this->db->insert_id();
                $this->db->insert('barang_stock', [
                    'id_barang' => $id_barang,
                    'stock' => $stock,
                    'is_baru' => '1',
                    'tanggal_restock' => $tanggal_restock,
                    'created' => date('Y-m-d H:i:s'),
                ]);
            } else {
                $this->db->where('id', $id);
                $this->db->update('barang', [
                    'id_kategori' => $id_kategori,
                    'id_supplier' => $id_supplier,
                    'barcode' => $barcode,
                    'nama' => $nama,
                    'harga_modal' => $harga_modal,
                    'harga_jual' => $harga_jual,
                    'keterangan' => $keterangan,
                    'updated' => date('Y-m-d H:i:s'),
                ]);
            }
        }

        echo json_encode([
            'status' => 'success'
        ]);
    }

    public function sharing()
    {
        $id = decode_id($this->input->post('id'));
        $data['id'] = $id;
        $data['ref_cabang'] = $this->db->query("SELECT * from ref_cabang where deleted is null")->result();
        $html = $this->load->view('admin/barang/form_sharing', $data, true);

        echo json_encode([
            'status' => 'success',
            'html' => $html,
        ]);
    }

    public function do_sharing()
    {
        $id = decode_id($this->input->post('id'));
        $id_cabang = $this->input->post('id_cabang');
        $tanggal = date('Y-m-d', strtotime($this->input->post('tanggal')));
        $qty = $this->input->post('qty');

        $barang_cabang = $this->db->query("SELECT * from barang_cabang where id='$id' ")->row();

        if ($qty > $barang_cabang->stock) {
            dd([
                'status' => 'failed',
                'msg' => 'stock tersedia ' . $barang_cabang->stock,
            ]);
        }

        $cek_data = $this->db->query("SELECT * from sharing where id_cabang='$id_cabang' and tanggal='$tanggal' and is_konfirmasi='0' and deleted is null ")->row();
        if (!empty($cek_data)) {
            $id_sharing = $cek_data->id;
        } else {
            $this->db->insert('sharing', [
                'id_cabang' => $id_cabang,
                'tanggal' => $tanggal,
                'created' => date('Y-m-d H:i:s'),
            ]);
            $id_sharing = $this->db->insert_id();
        }

        $this->db->insert('sharing_detail', [
            'id_sharing' => $id_sharing,
            'id_barang' => $barang_cabang->id_barang,
            'stock' => $qty,
            'is_transfer' => '1',
            'id_asal' => $barang_cabang->id_cabang,
            'created' => date('Y-m-d H:i:s'),
        ]);

        $updated = date('Y-m-d H:i:s');
        $this->db->query("UPDATE barang_cabang set stock=(stock - $qty), updated='$updated' where id='$id' ");

        echo json_encode([
            'status' => 'success',
        ]);
    }
}
