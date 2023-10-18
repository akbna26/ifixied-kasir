<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Refund_barang extends MY_controller
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        $data = [
            'index' => 'cabang/refund_barang/index',
            'index_js' => 'cabang/refund_barang/index_js',
            'title' => 'Refund/Klaim Garansi',
        ];

        $data['ref_cabang'] = $this->db->query("SELECT * from ref_cabang where id='$this->id_cabang' ")->row();;
        $data['ref_jenis_pembayaran'] = $this->db->query("SELECT * from ref_jenis_pembayaran where deleted is null ")->result();

        $data['ref_status_refund'] = $this->db->query("SELECT * from ref_status_refund where id !=5 and deleted is null")->result();
        $data['list_barang'] = $this->db->query("SELECT
            a.*
        FROM
            barang a
            LEFT JOIN ref_kategori c ON c.id = a.id_kategori
            LEFT JOIN barang_cabang d ON d.id_barang = a.id 
            AND d.deleted IS NULL AND d.id_cabang = '$this->id_cabang'
        WHERE
            a.deleted IS NULL 
        ")->result();

        $data['ref_pegawai'] = $this->db->query("SELECT * from pegawai where id_cabang='$this->id_cabang' and deleted is null ")->result();
        $this->templates->load($data);
    }

    public function cari_invoice()
    {
        cek_post();
        $invoice = str_replace(' ', '', $this->input->post('invoice'));

        $cek_sudah_klaim = $this->db->query("SELECT * 
            from transaksi a 
            join refund b on b.id_transaksi=a.id and b.deleted is null
            where a.no_invoice='$invoice' 
        ")->row();

        if (!empty($cek_sudah_klaim)) {
            echo json_encode([
                'status' => 'failed',
                'msg' => 'invoice sudah diklaim sebelumnya',
            ]);
            die;
        }

        $list = $this->db->query("SELECT c.id, c.barcode, c.nama, c.harga_modal, c.harga_jual 
            from transaksi a 
            left join transaksi_detail b on b.id_transaksi=a.id and b.deleted is null
            left join barang c on c.id=b.id_barang
            where a.deleted is null AND a.no_invoice='$invoice'
        ")->result();

        $row = $this->db->query("SELECT a.id_cabang, b.nama as nm_cabang
            from transaksi a 
            left join ref_cabang b on b.id=a.id_cabang
            where a.deleted is null AND a.no_invoice='$invoice'
        ")->row();

        echo json_encode([
            'status' => 'success',
            'data' => $list,
            'data_row' => $row,
        ]);
    }

    public function do_submit()
    {
        cek_post();
        $invoice = $this->input->post('invoice');
        $id_pegawai = $this->input->post('id_pegawai');
        $id_cabang_asal = $this->input->post('id_cabang_asal');

        $transaksi = $this->db->query("SELECT * from transaksi where no_invoice='$invoice' and deleted is null ")->row();

        $id_barang = explode(',', $this->input->post('id_barang'));
        $harga_modal = explode(',', $this->input->post('harga_modal'));
        $harga_jual = explode(',', $this->input->post('harga_jual'));
        $id_klaim = explode(',', $this->input->post('id_klaim'));
        $id_pengganti = explode(',', $this->input->post('id_pengganti'));
        $nilai_refund = explode(',', $this->input->post('nilai_refund'));
        $qty = explode(',', $this->input->post('qty'));
        $pembayaran = explode(',', $this->input->post('pembayaran'));

        $this->db->insert('refund', [
            'id_cabang' => $this->id_cabang,
            'id_cabang_asal' => $id_cabang_asal,
            'id_transaksi' => $transaksi->id,
            'id_pegawai' => $id_pegawai,
            'tanggal' => date('Y-m-d'),
            'created' => date('Y-m-d H:i:s'),
        ]);

        $id_insert = $this->db->insert_id();

        for ($i = 0; $i < count($id_barang); $i++) {
            $arr_insert[] = [
                'id_refund' => $id_insert,
                'id_barang' => $id_barang[$i],
                'id_klaim' => $id_klaim[$i],
                'id_pengganti' => $id_pengganti[$i],
                'nilai_refund' => $nilai_refund[$i],
                'qty' => $qty[$i],
                'harga_modal' => $harga_modal[$i],
                'harga_jual' => $harga_jual[$i],
                'pembayaran' => $pembayaran[$i],
                'created' => date('Y-m-d H:i:s'),
            ];
        }

        if (!empty($arr_insert)) {
            $this->db->insert_batch('refund_detail', $arr_insert);
        }

        echo json_encode([
            'status' => 'success',
            'link' => base_url('cabang/cetak/nota_refund/') . encode_id($id_insert),
        ]);
    }
}
