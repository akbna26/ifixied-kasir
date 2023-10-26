<?php

$nm_bulan = date('F', strtotime($tgl));
$bulan = date('m', strtotime($tgl));
$tahun = date('Y', strtotime($tgl));

$sheet = $spreadsheet->createSheet(2);
$sheet->setTitle('RINCIAN PROFIT');
$sheet->setCellValue('A1', 'RINCIAN PROFIT IFIXIED ' . $row_cabang->nama . ' ' . $nm_bulan . ' ' . $tahun);
$sheet->mergeCells('A1:F1');
$sheet->setCellValue('B2', 'RINCIAN PROFIT');

// judul
$sheet->setCellValue('A3', 'NO');
$sheet->setCellValue('B3', 'TANGGAL');
$sheet->setCellValue('C3', 'TOTAL');
// end judul
$sheet->getStyle('A3:C3')->getBorders()->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);

$sheet->getStyle('A3:C3')->applyFromArray([
    'fill' => [
        'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
        'startColor' => [
            'argb' => 'FF9902',
        ],
    ],
]);

$sheet->getStyle('A3:C3')->getAlignment()->setHorizontal('center');

foreach (['B', 'C'] as $column) $sheet->getColumnDimension($column)->setAutoSize(true);

$awal = 4;
$no = 1;

$data = $this->db->query("SELECT
    sum(profit) as profit, tanggal
    FROM
    (
        ( SELECT a.profit, a.tgl_keluar AS tanggal FROM profit_servis a WHERE a.id_cabang = '$id_cabang' ) 
        UNION ALL
        ( SELECT a.total_profit AS profit, DATE( a.created ) AS tanggal FROM profit a WHERE a.id_cabang = '$id_cabang' ) 
    ) as a	
    WHERE MONTH(a.tanggal)='$bulan' and YEAR(a.tanggal)='$tahun'
    GROUP BY tanggal
    ORDER BY tanggal asc
")->result();

$data_fix_tgl = [];
foreach ($data as $dt) $data_fix_tgl[$dt->tanggal] = $dt;

$total_profit = 0;
$total_data = 0;

$max_hari = date('t', strtotime($tahun . '-' . $bulan . '-01'));

for ($i = 1; $i <= $max_hari; $i++) {
    $tgl_fill = zerofill($i, 2);

    $waktu = "$tahun-$bulan-$tgl_fill";
    if (empty($data_fix_tgl[$waktu])) {
        $profit = 0;
    } else {
        $profit = $data_fix_tgl[$waktu]->profit;
    }

    $total_data += 1;
    $total_profit += $profit;

    $sheet
        ->setCellValue('A' . $awal, $no++)
        ->setCellValue('B' . $awal, $waktu)
        ->setCellValue('C' . $awal, $profit);

    $sheet->getStyle('A' . $awal . ':C' . $awal)->getBorders()->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
    $awal++;
}

$sheet
    ->setCellValue('B' . $awal, "JUMLAH")
    ->setCellValue('C' . $awal, $total_profit);

$sheet->getStyle('A' . $awal . ':C' . $awal)->getBorders()->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);

$sheet->getStyle('A' . $awal . ':C' . $awal)->applyFromArray([
    'fill' => [
        'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
        'startColor' => [
            'argb' => 'FF9902',
        ],
    ],
]);

$awal += 1;
$sheet
    ->setCellValue('B' . $awal, "RATA-RATA")
    ->setCellValue('C' . $awal, ($total_profit / $total_data));

$sheet->getStyle('A' . $awal . ':C' . $awal)->getBorders()->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);

$sheet->getStyle('A' . $awal . ':C' . $awal)->applyFromArray([
    'fill' => [
        'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
        'startColor' => [
            'argb' => 'FF9902',
        ],
    ],
]);

$currencyFormat = '#,##';
$lastRow = $sheet->getHighestRow();
$sheet->getStyle('C1:C' . $lastRow)->getNumberFormat()->setFormatCode($currencyFormat);
