<?php

$sheet = $spreadsheet->createSheet(1);
$sheet->setTitle('PART IN OUT');
$sheet->setCellValue('A1', 'PART IN OUT IFIXIED ' . $row_cabang->nama . ' ' . date('d-m-Y', strtotime($tgl)));
$sheet->mergeCells('A1:E1');
$sheet->setCellValue('B2', 'PART IN OUT');

// judul
$sheet->setCellValue('A3', 'NO');
$sheet->setCellValue('B3', 'JENIS TRANSAKSI');
$sheet->setCellValue('C3', 'KREDIT');
$sheet->setCellValue('D3', 'DEBIT');
$sheet->setCellValue('E3', 'KETERANGAN');
// end judul
$sheet->getStyle('A3:E3')->getBorders()->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
$sheet->getStyle('A4:E4')->getBorders()->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);

$sheet->getStyle('A3:E3')->applyFromArray([
    'fill' => [
        'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
        'startColor' => [
            'argb' => 'FF9902',
        ],
    ],
]);
$sheet->getStyle('A4:E4')->applyFromArray([
    'fill' => [
        'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
        'startColor' => [
            'argb' => 'FFDFDF',
        ],
    ],
]);

$modal = $this->get_modal_part($id_cabang, $tgl);
// modal awal
$sheet->setCellValue('B4', 'MODAL AWAL PART');
$sheet->setCellValue('C4', $modal);
$sheet->setCellValue('D4', 0);
// end modal awal

$sheet->getStyle('A3:F3')->getAlignment()->setHorizontal('center');

foreach (['B', 'C', 'D', 'E'] as $column) $sheet->getColumnDimension($column)->setAutoSize(true);

$awal = 5;
$no = 1;
$query = $this->query_global->part($id_cabang, $tgl);

$data = $this->db->query("SELECT * 
            from ($query) as a 
            where a.id_cabang='$id_cabang' and a.tanggal='$tgl'
        ")->result();

$total_kredit = 0;
$total_debit = 0;

foreach ($data as $row) {

    $total_kredit += $row->kredit;
    $total_debit += $row->debit;

    $keterangan = $row->keterangan . " ($row->qty x $row->harga_modal)";
    $jenis_transaksi = $row->jenis_transaksi;
    if (in_array($jenis_transaksi, ['TRANSFER STOCK MASUK'])) {
        $jenis_transaksi .= ' (Cabang asal :' . $row->nm_cabang_asal . ')';
    }
    if (in_array($jenis_transaksi, ['TRANSFER STOCK KELUAR'])) {
        $jenis_transaksi .= ' (' . $row->nm_cabang_asal . ')';
    }

    $sheet
        ->setCellValue('A' . $awal, $no++)
        ->setCellValue('B' . $awal, $keterangan)
        ->setCellValue('C' . $awal, $row->kredit)
        ->setCellValue('D' . $awal, $row->debit)
        ->setCellValue('E' . $awal, $jenis_transaksi);
    $awal++;

    $sheet->getStyle('A' . $awal . ':E' . $awal)->getBorders()->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
}

$sheet
    ->setCellValue('C' . $awal, ($modal + $total_kredit))
    ->setCellValue('D' . $awal, $total_debit)
    ->setCellValue('E' . $awal, (($modal + $total_kredit) - $total_debit));

$sheet->getStyle('A' . $awal . ':E' . $awal)->applyFromArray([
    'fill' => [
        'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
        'startColor' => [
            'argb' => 'FF9902',
        ],
    ],
]);