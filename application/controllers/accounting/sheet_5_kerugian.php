<?php

$sheet = $spreadsheet->createSheet(4);
$sheet->setTitle('KERUGIAN');
$sheet->setCellValue('A1', 'KERUGIAN IFIXIED ' . $row_cabang->nama . ' ' . date('d-m-Y', strtotime($tgl)));
$sheet->mergeCells('A1:E1');
$sheet->setCellValue('B2', 'KERUGIAN');

// judul
$sheet->setCellValue('A3', 'NO');
$sheet->setCellValue('B3', 'TANGGAL');
$sheet->setCellValue('C3', 'JENIS');
$sheet->setCellValue('D3', 'KETERANGAN');
$sheet->setCellValue('E3', 'JUMLAH');
// end judul
$sheet->getStyle('A3:E3')->getBorders()->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);

$sheet->getStyle('A3:E3')->applyFromArray([
    'fill' => [
        'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
        'startColor' => [
            'argb' => 'FF9902',
        ],
    ],
]);

$sheet->getStyle('A3:E3')->getAlignment()->setHorizontal('center');

foreach (['B', 'C', 'D', 'E'] as $column) $sheet->getColumnDimension($column)->setAutoSize(true);

$awal = 4;
$no = 1;

$bulan = date('m', strtotime($tgl));
$tahun = date('Y', strtotime($tgl));

$query = $this->query_global->data_kerugian();

$data = $this->db->query("SELECT a.*
    FROM ($query) a
    left join servis_berat b on b.id=a.id_asal
    left join human_error c on c.id=a.id_asal
    left join barang d on d.id=c.id_barang
    left join pegawai e on e.id=c.id_pegawai
    WHERE a.id_cabang='$id_cabang' and MONTH(a.tanggal)='$bulan' and YEAR(a.tanggal)='$tahun'
    order by a.tanggal asc
")->result();

$total = 0;

foreach ($data as $row) {

    $total += $row->jumlah;

    $sheet
        ->setCellValue('A' . $awal, $no++)
        ->setCellValue('B' . $awal, $row->tanggal)
        ->setCellValue('C' . $awal, strtoupper(str_replace('_', ' ', $row->jenis)))
        ->setCellValue('D' . $awal, $row->keterangan)
        ->setCellValue('E' . $awal, $row->jumlah);
    $awal++;

    $sheet->getStyle('A' . $awal . ':E' . $awal)->getBorders()->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
}

$sheet
    ->setCellValue('D' . $awal, "TOTAL")
    ->setCellValue('E' . $awal, $total);

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
$sheet->getStyle('E1:E' . $lastRow)->getNumberFormat()->setFormatCode($currencyFormat);
