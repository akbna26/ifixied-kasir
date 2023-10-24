<?php

$sheet = $spreadsheet->createSheet(0);
$sheet->setTitle('REPORT');
$sheet->setCellValue('A1', 'REPORT HARIAN IFIXIED ' . $row_cabang->nama . ' ' . date('d-m-Y', strtotime($tgl)));
$sheet->mergeCells('A1:B1');
$sheet->setCellValue('B2', 'CASH');

// judul
$sheet->setCellValue('A3', 'NO');
$sheet->setCellValue('B3', 'JENIS TRANSAKSI');
$sheet->setCellValue('C3', 'KREDIT');
$sheet->setCellValue('D3', 'DEBIT');
$sheet->setCellValue('E3', 'JENIS PEMBAYARAN');
$sheet->setCellValue('F3', 'KETERANGAN');
// end judul
$sheet->getStyle('A3:F3')->getBorders()->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
$sheet->getStyle('A4:F4')->getBorders()->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);

$sheet->getStyle('A3:F3')->applyFromArray([
    'fill' => [
        'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
        'startColor' => [
            'argb' => '01FF00',
        ],
    ],
]);
$sheet->getStyle('A4:F4')->applyFromArray([
    'fill' => [
        'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
        'startColor' => [
            'argb' => 'FFDFDF',
        ],
    ],
]);

$modal = $this->get_modal($id_cabang, $tgl);
// modal awal
$sheet->setCellValue('B4', 'MODAL AWAL CASH');
$sheet->setCellValue('C4', $modal);
$sheet->setCellValue('D4', 0);
// end modal awal

$sheet->getStyle('A3:F3')->getAlignment()->setHorizontal('center');

foreach (['B', 'C', 'D', 'E', 'F'] as $column) $sheet->getColumnDimension($column)->setAutoSize(true);

$awal = 5;
$no = 1;
$query = $this->query_global->modal();

$data = $this->db->query("SELECT * 
            from ($query) as a 
            left join ref_jenis_pembayaran b on b.id=a.id_pembayaran
            where a.id_cabang='$id_cabang' and b.nm_jenis='cash' and a.tanggal='$tgl'
            order by case when a.jenis_transaksi='SETOR TUNAI' then 0 else tanggal end
        ")->result();

$total_kredit = 0;
$total_debit = 0;

foreach ($data as $row) {

    $jenis_transaksi = $row->jenis_transaksi;
    if (in_array($row->jenis_transaksi, ['PENJUALAN', 'PENJUALAN SPLIT', 'DP', 'REFUND DP', 'SERVIS IC', 'SERVIS IC SPLIT', 'REFUND SERVIS IC', 'REFUND PENJUALAN'])) {
        $jenis_transaksi .= " ($row->nama_user - $row->no_hp)";
    }

    $keterangan = str_replace('<br>', ' ', $row->keterangan);
    if (in_array($row->jenis_transaksi, ['PENJUALAN'])) {
        $keterangan .= ' DP ' . $row->dp . ' - ' . 'Tgl : ' . tgl_indo($row->tgl_dp);
    }

    if ($row->jenis_transaksi == 'SETOR TUNAI') {
        $cek_no = '';
        $sheet->getStyle('A' . $awal . ':F' . $awal)->applyFromArray([
            'fill' => [
                'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                'startColor' => [
                    'argb' => 'AEDEFC',
                ],
            ],
        ]);
    } else {
        $cek_no = $no++;
    }

    $total_kredit += $row->kredit;
    $total_debit += $row->debit;

    $sheet
        ->setCellValue('A' . $awal, $cek_no)
        ->setCellValue('B' . $awal, $jenis_transaksi)
        ->setCellValue('C' . $awal, $row->kredit)
        ->setCellValue('D' . $awal, $row->debit)
        ->setCellValue('E' . $awal, $row->jenis_pembayaran)
        ->setCellValue('F' . $awal, $keterangan);
    $awal++;

    $sheet->getStyle('A' . $awal . ':F' . $awal)->getBorders()->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
}

$sheet
    ->setCellValue('C' . $awal, ($modal + $total_kredit))
    ->setCellValue('D' . $awal, $total_debit)
    ->setCellValue('E' . $awal, (($modal + $total_kredit) - $total_debit));

$sheet->getStyle('A' . $awal . ':F' . $awal)->applyFromArray([
    'fill' => [
        'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
        'startColor' => [
            'argb' => '01FF00',
        ],
    ],
]);