<?php

$sheet = $spreadsheet->createSheet(5);
$sheet->setTitle('KASBON');
$sheet->setCellValue('A1', 'KASBON IFIXIED ' . $row_cabang->nama . ' ' . date('d-m-Y', strtotime($tgl)));
$sheet->mergeCells('A1:E1');
$sheet->setCellValue('B2', 'KASBON');

// judul
$sheet->setCellValue('A3', 'NO');
$sheet->setCellValue('B3', 'TANGGAL');
$sheet->setCellValue('C3', 'NAMA PEGAWAI');
$sheet->setCellValue('D3', 'SUMBER DANA');
$sheet->setCellValue('E3', 'JUMLAH');
$sheet->setCellValue('F3', 'KETERANGAN');
// end judul
$sheet->getStyle('A3:F3')->getBorders()->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);

$sheet->getStyle('A3:F3')->applyFromArray([
    'fill' => [
        'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
        'startColor' => [
            'argb' => 'FF9902',
        ],
    ],
]);

$sheet->getStyle('A3:F3')->getAlignment()->setHorizontal('center');

foreach (['B', 'C', 'D', 'E', 'F'] as $column) $sheet->getColumnDimension($column)->setAutoSize(true);

$awal = 4;
$no = 1;

$bulan = date('m', strtotime($tgl));
$tahun = date('Y', strtotime($tgl));

$data = $this->db->query("SELECT a.*, b.nama as nm_pegawai, c.nama as nm_pembayaran, d.nama as nm_cabang 
    from kasbon a 
    left join pegawai b on b.id=a.id_pegawai
    left join ref_jenis_pembayaran c on c.id=a.id_pembayaran
    left join ref_cabang d on d.id=a.id_cabang
    WHERE a.deleted IS NULL AND a.id_cabang='$id_cabang' and MONTH(a.tanggal)='$bulan' and YEAR(a.tanggal)='$tahun'
    order by a.tanggal asc
")->result();

$total = 0;

foreach ($data as $row) {

    $total += $row->jumlah;

    $sheet
        ->setCellValue('A' . $awal, $no++)
        ->setCellValue('B' . $awal, $row->tanggal)
        ->setCellValue('C' . $awal, $row->nm_pegawai)
        ->setCellValue('D' . $awal, $row->nm_pembayaran)
        ->setCellValue('E' . $awal, $row->jumlah)
        ->setCellValue('F' . $awal, $row->keterangan);
    $awal++;

    $sheet->getStyle('A' . $awal . ':F' . $awal)->getBorders()->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
}

$sheet
    ->setCellValue('D' . $awal, "TOTAL")
    ->setCellValue('E' . $awal, $total);

$sheet->getStyle('A' . $awal . ':F' . $awal)->applyFromArray([
    'fill' => [
        'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
        'startColor' => [
            'argb' => 'FF9902',
        ],
    ],
]);

$currencyFormat = '#,##';
$lastRow = $sheet->getHighestRow();
$sheet->getStyle('E1:E' . $lastRow)->getNumberFormat()->setFormatCode($currencyFormat);
