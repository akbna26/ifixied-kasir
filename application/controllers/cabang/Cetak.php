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

        $mpdf = new \Mpdf\Mpdf(['mode' => 'utf-8', 'format' => 'A4']); //lebar x tinggi kertas // jika custom [120,75]
        $mpdf->AddPage('P', '', '', '', '', 10, 10, 10, 10, 25, 25); // L, R, T, B
        $mpdf->SetDisplayMode('fullpage');
        $mpdf->SetDisplayPreferences('FullScreen');

        $data = [];
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

        $mpdf = new \Mpdf\Mpdf(['mode' => 'utf-8', 'format' => 'A4']); //lebar x tinggi kertas // jika custom [120,75]
        $mpdf->AddPage('P', '', '', '', '', 10, 10, 10, 10, 25, 25); // L, R, T, B
        $mpdf->SetDisplayMode('fullpage');
        $mpdf->SetDisplayPreferences('FullScreen');

        $data = [];
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

        $mpdf = new \Mpdf\Mpdf(['mode' => 'utf-8', 'format' => 'A4']); //lebar x tinggi kertas // jika custom [120,75]
        $mpdf->AddPage('P', '', '', '', '', 10, 10, 10, 10, 25, 25); // L, R, T, B
        $mpdf->SetDisplayMode('fullpage');
        $mpdf->SetDisplayPreferences('FullScreen');

        $data = [];
        $html = $this->load->view('cabang/cetak/nota_refund', $data, true);
        $mpdf->WriteHTML($html);
        $cetak = 'Laporan.pdf';
        $mpdf->Output($cetak, 'I'); // opens in browser 
    }
}

/* End of file Dashboard.php */
