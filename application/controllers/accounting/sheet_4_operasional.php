<?php

$sheet = $spreadsheet->createSheet(3);
$sheet->setTitle('OPERASIONAL');
$sheet->setCellValue('A1', 'OPERASIONAL IFIXIED ' . $row_cabang->nama . ' ' . date('d-m-Y', strtotime($tgl)));
$sheet->mergeCells('A1:E1');
$sheet->setCellValue('B2', 'OPERASIONAL');

// judul
$sheet->setCellValue('A3', 'NO');
$sheet->setCellValue('B3', 'TANGGAL');
$sheet->setCellValue('C3', 'JENIS OPERASIONAL');
$sheet->setCellValue('D3', 'JUMLAH');
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

$sheet->getStyle('A3:F3')->getAlignment()->setHorizontal('center');

foreach (['B', 'C', 'D', 'E'] as $column) $sheet->getColumnDimension($column)->setAutoSize(true);

$awal = 4;
$no = 1;

$bulan = date('m', strtotime($tgl));
$tahun = date('Y', strtotime($tgl));

$data = $this->db->query("SELECT a.*, b.nama AS nm_operasional, c.nama AS nm_pembayaran, d.nama AS nm_cabang
    FROM operasional a
    LEFT JOIN ref_operasional b ON b.id = a.id_operasional
    LEFT JOIN ref_jenis_pembayaran c ON c.id = a.id_pembayaran
    LEFT JOIN ref_cabang d ON d.id = a.id_cabang
    WHERE a.deleted IS NULL AND a.id_cabang='$id_cabang' and MONTH(a.tanggal)='$bulan' and YEAR(a.tanggal)='$tahun'
    order by a.tanggal asc
")->result();

$total = 0;

foreach ($data as $row) {

    $total += $row->jumlah;

    $sheet
        ->setCellValue('A' . $awal, $no++)
        ->setCellValue('B' . $awal, $row->tanggal)
        ->setCellValue('C' . $awal, $row->nm_operasional . ' - ' . $row->nm_pembayaran)
        ->setCellValue('D' . $awal, $row->jumlah)
        ->setCellValue('E' . $awal, $row->keterangan);
    $awal++;

    $sheet->getStyle('A' . $awal . ':E' . $awal)->getBorders()->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
}

$sheet
    ->setCellValue('C' . $awal, "TOTAL")
    ->setCellValue('D' . $awal, $total);

$sheet->getStyle('A' . $awal . ':E' . $awal)->applyFromArray([
    'fill' => [
        'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
        'startColor' => [
            'argb' => 'FF9902',
        ],
    ],
]);

$currencyFormat = '#,##';
$lastRow = $sheet->getHighestRow();
$sheet->getStyle('D1:D' . $lastRow)->getNumberFormat()->setFormatCode($currencyFormat);
