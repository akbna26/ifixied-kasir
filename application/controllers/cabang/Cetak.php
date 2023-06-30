<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Cetak extends MY_controller
{

    public function __construct()
    {
        parent::__construct();
    }

    public function nota_dp($id = null)
    {
        if (!$id) {
            dd('not allowed');
        }

        $id = decode_id($id);

        $mpdf = new \Mpdf\Mpdf(['mode' => 'utf-8', 'format' => 'A4']); //lebar x tinggi kertas // jika custom [120,75]
        $mpdf->AddPage('P', '', '', '', '', 10, 10, 10, 10, 25, 25); // L, R, T, B
        $mpdf->SetDisplayMode('fullpage');
        $mpdf->SetDisplayPreferences('FullScreen');

        $data['row'] = $this->db->query("SELECT a.*, b.nama as nm_cabang, b.lokasi, b.kontak, c.nama as nm_pegawai
            from dp a 
            left join ref_cabang b on b.id=a.id_cabang
            left join pegawai c on c.id=a.id_pegawai
            where a.id='$id' 
        ")->row();

        $html = $this->load->view('cabang/cetak/nota_dp', $data, true);
        $mpdf->WriteHTML($html);
        $cetak = 'Laporan.pdf';
        $mpdf->Output($cetak, 'I'); // opens in browser 
    }

    public function nota_transaksi($id = null)
    {
        if (!$id) {
            dd('not allowed');
        }

        $id = decode_id($id);

        $mpdf = new \Mpdf\Mpdf(['mode' => 'utf-8', 'format' => 'A4']); //lebar x tinggi kertas // jika custom [120,75]
        $mpdf->AddPage('P', '', '', '', '', 10, 10, 10, 10, 25, 25); // L, R, T, B
        $mpdf->SetDisplayMode('fullpage');
        $mpdf->SetDisplayPreferences('FullScreen');

        $data['row'] = $this->db->query("SELECT a.*, b.nama as nm_cabang, b.lokasi, b.kontak, c.nama as nm_pegawai, d.nama as nm_pembayaran
            from transaksi a 
            left join ref_cabang b on b.id=a.id_cabang
            left join pegawai c on c.id=a.id_pegawai
            left join ref_jenis_pembayaran d on d.id=a.id_jenis_pembayaran
            where a.id='$id' and a.deleted is null
        ")->row();

        $data['detail'] = $this->db->query("SELECT a.*, b.nama as nm_barang, b.barcode
            from transaksi_detail a 
            left join barang b on b.id=a.id_barang
            where a.id_transaksi='$id' and a.deleted is null
        ")->result();

        $html = $this->load->view('cabang/cetak/nota_transaksi', $data, true);
        $mpdf->WriteHTML($html);
        $cetak = 'Laporan.pdf';
        $mpdf->Output($cetak, 'I'); // opens in browser 
    }

    public function nota_refund($id = null)
    {
        if (!$id) {
            dd('not allowed');
        }

        $id = decode_id($id);
        error_reporting(0);

        $mpdf = new \Mpdf\Mpdf(['mode' => 'utf-8', 'format' => 'A4']); //lebar x tinggi kertas // jika custom [120,75]
        $mpdf->AddPage('P', '', '', '', '', 10, 10, 10, 10, 25, 25); // L, R, T, B
        $mpdf->SetDisplayMode('fullpage');
        $mpdf->SetDisplayPreferences('FullScreen');

        $data['row'] = $this->db->query("SELECT a.*, b.nama as nm_cabang, b.lokasi, b.kontak, c.nama as nm_pegawai, d.no_invoice, d.pelanggan, d.no_hp, d.keterangan
            from refund a 
            left join ref_cabang b on b.id=a.id_cabang
            left join pegawai c on c.id=a.id_pegawai
            left join transaksi d on d.id=a.id_transaksi
            where a.id='$id' 
        ")->row();

        $data['detail'] = $this->db->query("SELECT a.*, 
            case when a.pembayaran=1 then 'CASH' when a.pembayaran=2 then 'TRANSFER' end as nm_pembayaran,
            b.nama as barang, c.nama as nm_klaim, d.nama as nm_pengganti
            from refund_detail a 
            left join barang b on b.id=a.id_barang
            left join ref_status_refund c on c.id=a.id_klaim
            left join barang d on d.id=a.id_pengganti
            where a.id_refund='$id' and a.deleted is null 
        ")->result();

        $html = $this->load->view('cabang/cetak/nota_refund', $data, true);
        $mpdf->WriteHTML($html);
        $cetak = 'Laporan.pdf';
        $mpdf->Output($cetak, 'I'); // opens in browser 
    }
}

/* End of file Dashboard.php */
