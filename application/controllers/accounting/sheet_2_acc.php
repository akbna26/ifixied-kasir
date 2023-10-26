<?php

$awal += 2;
$sheet->setCellValue('B' . $awal, 'ACC IN OUT');

$awal += 1;
// judul
$sheet->setCellValue('A' . $awal, 'NO');
$sheet->setCellValue('B' . $awal, 'JENIS TRANSAKSI');
$sheet->setCellValue('C' . $awal, 'KREDIT');
$sheet->setCellValue('D' . $awal, 'DEBIT');
$sheet->setCellValue('E' . $awal, 'KETERANGAN');
// end judul
$sheet->getStyle('A' . $awal . ':E' . $awal)->getBorders()->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
$sheet->getStyle('A' . $awal . ':E' . $awal)->applyFromArray([
    'fill' => [
        'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
        'startColor' => [
            'argb' => 'FF9902',
        ],
    ],
]);
$sheet->getStyle('A' . $awal . ':F' . $awal)->getAlignment()->setHorizontal('center');

$awal += 1;
$sheet->getStyle('A' . $awal . ':E' . $awal)->getBorders()->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);

$sheet->getStyle('A' . $awal . ':E' . $awal)->applyFromArray([
    'fill' => [
        'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
        'startColor' => [
            'argb' => 'FFDFDF',
        ],
    ],
]);

$modal = $this->get_modal_acc($id_cabang, $tgl);
// modal awal
$sheet->setCellValue('B' . $awal, 'MODAL AWAL ACC');
$sheet->setCellValue('C' . $awal, $modal);
$sheet->setCellValue('D' . $awal, 0);
// end modal awal
$awal += 1;
foreach (['B', 'C', 'D', 'E'] as $column) $sheet->getColumnDimension($column)->setAutoSize(true);

$no = 1;
$query = $this->query_global->acc($id_cabang, $tgl);

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
