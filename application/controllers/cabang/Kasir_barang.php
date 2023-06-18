<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Kasir_barang extends MY_controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('cabang/table_kasir_cari_produk', 'table');
    }

    public function index()
    {
        $cabang = $this->db->query("SELECT * from ref_cabang where id='$this->id_cabang' ")->row();
        $data['cabang'] = $cabang;
        $data['pegawai'] = $this->db->query("SELECT * from pegawai where id_cabang='$this->id_cabang' and deleted is null ")->result();
        $data['ref_jenis_pembayaran'] = $this->db->query("SELECT * from ref_jenis_pembayaran where deleted is null ")->result();

        $tahun = date('Y');
        $bulan = date('m');
        $total_transaksi = $this->db->query("SELECT count(1)+1 as total from transaksi where month(created)='$bulan' and year(created)='$tahun' ")->row();
        $data['no_invoice'] = 'INV' . $cabang->id . '-' . date('Ym') . '-' . sprintf("%04d", $total_transaksi->total);

        $this->load->view('cabang/kasir_barang/index', $data);
    }

    public function cari_produk()
    {
        $data = [];
        $html = $this->load->view('cabang/kasir_barang/cari_produk', $data, true);

        echo json_encode([
            'status' => 'success',
            'html' => $html,
        ]);
    }

    public function table_cari_produk()
    {
        echo $this->table->generate_table();
    }

    public function get_one()
    {
        $barcode = $this->input->post('barcode');
        $row = $this->db->query("SELECT * from barang where barcode='$barcode' and deleted is null ")->row();
        echo json_encode([
            'status' => 'success',
            'data' => $row,
        ]);
    }

    public function do_submit()
    {
        $tahun = date('Y');
        $bulan = date('m');
        $total_transaksi = $this->db->query("SELECT count(1)+1 as total from transaksi where id_cabang='$this->id_cabang' and month(created)='$bulan' and year(created)='$tahun' ")->row();
        $no_invoice = 'INV' . $this->id_cabang . '-' . date('Ym') . '-' . sprintf("%04d", $total_transaksi->total);

        $cek_split = $this->input->post('cek_split');
        $jenis_bayar_1 = $this->input->post('jenis_bayar_1');
        $jenis_bayar_2 = $this->input->post('jenis_bayar_2');
        $kembalian = $this->input->post('kembalian');
        $keterangan = $this->input->post('keterangan');
        $nama_pelanggan = $this->input->post('nama_pelanggan');
        $no_hp = $this->input->post('no_hp');
        $nominal_bayar = $this->input->post('nominal_bayar');
        $select_pegawai = $this->input->post('select_pegawai');
        $total_bayar_split = $this->input->post('total_bayar_split');
        $total_dp = $this->input->post('total_dp');
        $total_nilai = $this->input->post('total_nilai');

        $produk_hargajual = explode(',', $this->input->post('produk_hargajual'));
        $produk_hargamodal = explode(',', $this->input->post('produk_hargamodal'));
        $produk_id = explode(',', $this->input->post('produk_id'));
        $produk_qty = explode(',', $this->input->post('produk_qty'));
        $produk_sub_total = explode(',', $this->input->post('produk_sub_total'));

        $get_prosen_bayar_1 = $this->db->query("SELECT * from ref_jenis_pembayaran where id='$jenis_bayar_1' and deleted is null ")->row();
        $get_prosen_bayar_2 = $this->db->query("SELECT * from ref_jenis_pembayaran where id='$jenis_bayar_2' and deleted is null ")->row();

        $potongan = $nominal_bayar * ($get_prosen_bayar_1->persen_potongan / 100);

        if ($cek_split == 1) $potongan_split = $total_bayar_split * ($get_prosen_bayar_2->persen_potongan / 100);
        else $potongan_split = 0;

        $this->db->insert('transaksi', [
            'id_cabang' => $this->id_cabang,
            'id_jenis_pembayaran' => $jenis_bayar_1,
            'id_pegawai' => $select_pegawai,
            'no_invoice' => $no_invoice,
            'pelanggan' => $nama_pelanggan,
            'no_hp' => $no_hp,
            'keterangan' => $keterangan,
            'bayar' => $nominal_bayar,
            'dp' => $total_dp,
            'total' => $total_nilai,
            'potongan' => $potongan,
            'is_split' => $cek_split,
            'id_jenis_pembayaran_2' => $jenis_bayar_2,
            'total_split' => $total_bayar_split,
            'potongan_split' => $potongan_split,
            'kembalian' => $kembalian,
            'created' => date('Y-m-d H:i:s'),
        ]);

        $id_transaksi = $this->db->insert_id();

        for ($i = 0; $i < count($produk_id); $i++) {
            $arr_insert[] = [
                'id_transaksi' => $id_transaksi,
                'id_barang' => $produk_id[$i],
                'harga_modal' => $produk_hargamodal[$i],
                'qty' => $produk_qty[$i],
                'harga' => $produk_hargajual[$i],
                'sub_total' => $produk_sub_total[$i],
                'created' => date('Y-m-d H:i:s'),
            ];
        }

        if (!empty($arr_insert)) {
            $this->db->insert_batch('transaksi_detail', $arr_insert);
        }

        echo json_encode([
            'status' => 'success',
            // 'data' => $_POST,
        ]);
    }
}
