<?php

$sheet->setCellValue('B2', 'PART RETUR');

// judul
$sheet->setCellValue('G3', 'NO');
$sheet->setCellValue('H3', 'NAMA BARANG');
$sheet->setCellValue('I3', 'QTY');
$sheet->setCellValue('J3', 'TANGGAL');
$sheet->setCellValue('K3', 'MODAL');
$sheet->setCellValue('L3', 'INVOICE');
$sheet->setCellValue('M3', 'JENIS KLAIM');
$sheet->setCellValue('N3', 'STATUS');
// end judul
$sheet->getStyle('G3:N3')->getBorders()->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
$sheet->getStyle('G4:N4')->getBorders()->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);

$sheet->getStyle('G3:N3')->applyFromArray([
    'fill' => [
        'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
        'startColor' => [
            'argb' => 'FF9902',
        ],
    ],
]);

$sheet->getStyle('G3:N3')->getAlignment()->setHorizontal('center');

foreach (['G', 'H', 'I', 'J', 'K', 'L', 'M', 'N'] as $column) $sheet->getColumnDimension($column)->setAutoSize(true);

$awal = 4;
$no = 1;

$bulan = date('m', strtotime($tgl));
$tahun = date('Y', strtotime($tgl));

$data = $this->db->query("SELECT a.*, DATE(a.created) AS tanggal, CONCAT(b.barcode, ' - ', b.nama) AS nm_barang, c.no_invoice, 
    CASE WHEN a.id_klaim = 5 THEN f.nama ELSE d.nama END AS nm_cabang,
    e.nama AS nm_klaim, b.harga_modal
    FROM refund_detail a
    LEFT JOIN refund aa ON aa.id = a.id_refund
    LEFT JOIN barang b ON b.id = a.id_barang
    LEFT JOIN transaksi c ON c.id = aa.id_transaksi AND c.deleted IS NULL
    LEFT JOIN ref_cabang d ON d.id = aa.id_cabang
    LEFT JOIN ref_status_refund e ON e.id = a.id_klaim
    LEFT JOIN ref_cabang f ON f.id = a.id_cabang
    WHERE a.id_klaim IN (1, 3, 5) AND a.deleted IS NULL AND aa.deleted IS NULL 
    and (a.id_cabang = $id_cabang OR aa.id_cabang=$id_cabang ) and (MONTH(a.created)='$bulan' and YEAR(a.created)='$tahun' or a.status_retur is null)
    and a.status_retur is null
    order by a.created asc
")->result();

$total_modal = 0;

foreach ($data as $row) {    

    $retur = '';

    if (empty($row->status_retur) && empty($row->is_sampai)) $retur = 'Barang Dicabang';
    elseif ($row->is_sampai == 1 && empty($row->status_retur)) $retur = 'Barang tiba digudang, Menunggu konfirmasi'; 
    elseif ($row->status_retur == 1) $retur = 'Kerugian';
    elseif ($row->status_retur == 2) $retur = 'Disetujui';

    $total_modal += $row->harga_modal;

    $sheet
        ->setCellValue('G' . $awal, $no++)
        ->setCellValue('H' . $awal, $row->nm_barang)
        ->setCellValue('I' . $awal, $row->qty)
        ->setCellValue('J' . $awal, $row->tanggal)
        ->setCellValue('K' . $awal, $row->harga_modal)
        ->setCellValue('L' . $awal, $row->no_invoice)
        ->setCellValue('M' . $awal, $row->nm_klaim)
        ->setCellValue('N' . $awal, $retur);
    $awal++;

    $sheet->getStyle('G' . $awal . ':N' . $awal)->getBorders()->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
}

$sheet
    ->setCellValue('J' . $awal, "TOTAL")
    ->setCellValue('K' . $awal, $total_modal);

$sheet->getStyle('G' . $awal . ':N' . $awal)->applyFromArray([
    'fill' => [
        'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
        'startColor' => [
            'argb' => 'FF9902',
        ],
    ],
]);

$currencyFormat = '#,##';
$lastRow = $sheet->getHighestRow();
$sheet->getStyle('C1:E' . $lastRow)->getNumberFormat()->setFormatCode($currencyFormat);
$sheet->getStyle('H1:N' . $lastRow)->getNumberFormat()->setFormatCode($currencyFormat);
