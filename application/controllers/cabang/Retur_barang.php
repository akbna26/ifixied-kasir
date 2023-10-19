<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Retur_barang extends MY_controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('cabang/table_retur_barang', 'table');
    }

    public function index()
    {
        $data = [
            'index' => 'cabang/retur_barang/index',
            'index_js' => 'cabang/retur_barang/index_js',
            'title' => 'Retur Barang',
        ];

        $this->templates->load($data);
    }

    public function table()
    {
        echo $this->table->generate_table();
    }

    public function tambah()
    {
        $data['barang'] = $this->db->query("SELECT a.id, a.barcode, a.harga_modal, a.nama as nm_barang from barang a 
            join barang_cabang b on b.id_barang=a.id and b.id_cabang='$this->id_cabang' and b.deleted is null
            where a.deleted is null
        ")->result();
        $html = $this->load->view('cabang/retur_barang/form', $data, true);

        echo json_encode([
            'status' => 'success',
            'html' => $html,
        ]);
    }

    public function ubah()
    {
        $id = decode_id($this->input->post('id'));
        $data['id'] = $id;
        $data['data'] = $this->db->query("SELECT * from refund_detail where id='$id' and deleted is null ")->row();
        $data['barang'] = $this->db->query("SELECT a.id, a.barcode, a.harga_modal, a.nama as nm_barang from barang a 
            join barang_cabang b on b.id_barang=a.id and b.id_cabang='$this->id_cabang' and b.deleted is null
            where a.deleted is null
        ")->result();
        $html = $this->load->view('cabang/retur_barang/form', $data, true);

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
        $keterangan = $this->input->post('keterangan');
        $harga_modal = clear_koma($this->input->post('harga_modal'));
        $total = clear_koma($this->input->post('total'));

        if (!empty($hapus)) {
            $this->db->where('id', $id);
            $this->db->update('refund_detail', [
                'deleted' => date('Y-m-d H:i:s'),
            ]);
        } else {
            if (empty($id)) {
                $this->db->insert('refund_detail', [
                    'id_refund' => 0,
                    'id_klaim' => 5,
                    'id_cabang' => $this->id_cabang,
                    'id_barang' => $id_barang,
                    'alasan_refund' => $keterangan,
                    'harga_modal' => $harga_modal,
                    'qty' => $total,
                    'created' => date('Y-m-d H:i:s'),
                ]);
            } else {
                $this->db->where('id', $id);
                $this->db->update('refund_detail', [
                    'id_barang' => $id_barang,
                    'alasan_refund' => $keterangan,
                    'harga_modal' => $harga_modal,
                    'qty' => $total,
                    'updated' => date('Y-m-d H:i:s'),
                ]);
            }
        }

        echo json_encode([
            'status' => 'success'
        ]);
    }

    public function detail()
    {
        $id = decode_id($this->input->post('id'));
        $data['id'] = $id;

        $data['detail'] = $this->db->query("SELECT
            a.*,
            a.created AS tanggal,
            b.nama AS nm_barang,
            b.barcode,
            c.no_invoice,
        CASE                
            WHEN a.id_klaim = 5 THEN
            f.nama ELSE d.nama 
        END AS nm_cabang,
        CASE                
            WHEN a.id_klaim = 5 THEN
            f.lokasi ELSE d.lokasi 
        END AS cabang_alamat,
        e.nama AS nm_klaim 
        FROM
            refund_detail a
            LEFT JOIN refund aa ON aa.id = a.id_refund
            LEFT JOIN barang b ON b.id = a.id_barang
            LEFT JOIN transaksi c ON c.id = aa.id_transaksi 
            AND c.deleted
            IS NULL LEFT JOIN ref_cabang d ON d.id = aa.id_cabang
            LEFT JOIN ref_status_refund e ON e.id = a.id_klaim
            LEFT JOIN ref_cabang f ON f.id = a.id_cabang 
        WHERE
            a.id_klaim IN ( 1, 3, 5 ) 
            AND a.deleted IS NULL 
            AND aa.deleted IS NULL and a.id='$id'
        ")->row();

        $html = $this->load->view('cabang/retur_barang/detail', $data, true);

        echo json_encode([
            'status' => 'success',
            'html' => $html,
        ]);
    }

    public function verifikasi()
    {
        $id = decode_id($this->input->post('id'));
        $data['id'] = $id;
        $data['data'] = $this->db->query("SELECT
            a.*,
            a.created AS tanggal,
            b.nama AS nm_barang,
            b.barcode,
            c.no_invoice,
        CASE                
            WHEN a.id_klaim = 5 THEN
            f.nama ELSE d.nama 
        END AS nm_cabang,
        CASE                
            WHEN a.id_klaim = 5 THEN
            f.lokasi ELSE d.lokasi 
        END AS cabang_alamat,
        e.nama AS nm_klaim 
        FROM
            refund_detail a
            LEFT JOIN refund aa ON aa.id = a.id_refund
            LEFT JOIN barang b ON b.id = a.id_barang
            LEFT JOIN transaksi c ON c.id = aa.id_transaksi 
            AND c.deleted
            IS NULL LEFT JOIN ref_cabang d ON d.id = aa.id_cabang
            LEFT JOIN ref_status_refund e ON e.id = a.id_klaim
            LEFT JOIN ref_cabang f ON f.id = a.id_cabang 
        WHERE
            a.id_klaim IN ( 1, 3, 5 ) 
            AND a.deleted IS NULL 
            AND aa.deleted IS NULL and a.id='$id'
        ")->row();
        $html = $this->load->view('cabang/retur_barang/verifikasi', $data, true);

        echo json_encode([
            'status' => 'success',
            'html' => $html,
        ]);
    }

    public function do_verifikasi()
    {
        $id = decode_id($this->input->post('id'));
        $status_retur = $this->input->post('status_retur');
        $alasan_tolak = $this->input->post('alasan_tolak');
        $qty = clear_koma($this->input->post('qty'));
        $harga_modal = clear_koma($this->input->post('harga_modal'));

        $potong_profit = null;
        if ($status_retur == 1) $potong_profit = $qty * $harga_modal;

        $this->db->where('id', $id);
        $this->db->update('refund_detail', [
            'status_retur' => $status_retur,
            'alasan_tolak' => $alasan_tolak,
            'potong_profit' => $potong_profit,
            'tanggal_konfirmasi' => date('Y-m-d'),
            'updated' => date('Y-m-d H:i:s'),
        ]);

        echo json_encode([
            'status' => 'success',
        ]);
    }

    public function do_konfirmasi_tiba()
    {
        cek_post();
        $id = decode_id($this->input->post('id'));

        $this->db->where('id', $id);
        $this->db->update('refund_detail', [
            'is_sampai' => '1',
            'tgl_sampai' => date('Y-m-d'),
            'updated' => date('Y-m-d H:i:s'),
        ]);

        echo json_encode([
            'status' => 'success',
        ]);
    }
}
