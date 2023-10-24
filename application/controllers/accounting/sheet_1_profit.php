<?php

$sheet->setCellValue('I2', 'PROFIT');

// judul
$sheet->setCellValue('H3', 'NO');
$sheet->setCellValue('I3', 'NAMA BARANG');
$sheet->setCellValue('J3', 'MODAL');
$sheet->setCellValue('K3', 'HARGA SATUAN');
$sheet->setCellValue('L3', 'QTY');
$sheet->setCellValue('M3', "SUB TOTAL\n(dikurangi potongan)");
$sheet->setCellValue('N3', 'PROFIT');
$sheet->setCellValue('O3', 'METODE PEMBAYARAN');
$sheet->setCellValue('P3', 'KETERANGAN');
// end judul
$sheet->getStyle('H3:P3')->getBorders()->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);

$sheet->getStyle('H3:P3')->applyFromArray([
    'fill' => [
        'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
        'startColor' => [
            'argb' => '01FF00',
        ],
    ],
]);

$sheet->getStyle('H3:P3')->getAlignment()->setHorizontal('center');

foreach (['H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P'] as $column) $sheet->getColumnDimension($column)->setAutoSize(true);

$awal = 4;
$no = 1;

$data = $this->db->query("SELECT a.*, b.pelanggan, b.tipe_unit, b.no_hp, b.kerusakan, b.invoice, d.nama as nm_teknisi, e.nama as nm_tindakan,
    case when b.id_jenis_pembayaran_2=0 then f.nama else concat(f.nama,' (',b.bayar,') & ',g.nama,' (',b.bayar_split,')') end as metode_bayar
    from profit_servis a
    left join servis_berat b on b.id=a.id
    left join setting_pegawai c on c.id=b.id_teknisi_setting
    left join pegawai d on d.id=c.id_pegawai
    left join ref_tindakan e on e.id=b.id_tindakan
    left join ref_jenis_pembayaran f on f.id=b.id_jenis_pembayaran
    left join ref_jenis_pembayaran g on g.id=b.id_jenis_pembayaran_2
    where a.id_cabang='$id_cabang' AND DATE(a.tgl_keluar)='$tgl' 
")->result();

$total_profit = 0;

foreach ($data as $row) {
    $sheet
        ->setCellValue('H' . $awal, $no)
        ->setCellValue('I' . $awal, $row->pelanggan . '/' . $row->no_hp . ' - ' . $row->tipe_unit . ' (' . $row->kerusakan . ')')
        ->setCellValue('J' . $awal, $row->modal)
        ->setCellValue('K' . $awal, $row->biaya)
        ->setCellValue('L' . $awal, 1)
        ->setCellValue('M' . $awal, $row->sub_total)
        ->setCellValue('N' . $awal, $row->profit)
        ->setCellValue('O' . $awal, $row->metode_bayar)
        ->setCellValue('P' . $awal, $row->invoice);

    $total_profit += $row->profit;
    $sheet->getStyle('H' . $awal . ':P' . $awal)->getBorders()->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);

    $sheet->getStyle('H' . $awal . ':P' . $awal)->applyFromArray([
        'fill' => [
            'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
            'startColor' => [
                'argb' => 'FFDFDF',
            ],
        ],
    ]);
    $awal++;
    $no++;
}

$data = $this->db->query("SELECT a.*, b.pelanggan, b.no_hp, b.no_invoice,
    case when b.id_jenis_pembayaran_2=0 then c.nama else concat(c.nama,' (',b.bayar,') & ',d.nama,' (',b.total_split,')') end as metode_bayar
    from profit a
    left join transaksi b on b.id=a.id
    left join ref_jenis_pembayaran c on c.id=b.id_jenis_pembayaran
    left join ref_jenis_pembayaran d on d.id=b.id_jenis_pembayaran_2
    where a.id_cabang='$id_cabang' AND DATE(a.created)='$tgl'
")->result();

foreach ($data as $row) {
    $sheet
        ->setCellValue('H' . $awal, $no)
        ->setCellValue('I' . $awal, $row->nm_barang .  ' (' . $row->pelanggan . ' - ' . $row->no_hp . ')')
        ->setCellValue('J' . $awal, $row->harga_modal)
        ->setCellValue('K' . $awal, $row->harga)
        ->setCellValue('L' . $awal, $row->qty)
        ->setCellValue('M' . $awal, $row->sub_total)
        ->setCellValue('N' . $awal, $row->total_profit)
        ->setCellValue('O' . $awal, $row->metode_bayar)
        ->setCellValue('P' . $awal, $row->no_invoice);

    $total_profit += $row->total_profit;
    $sheet->getStyle('H' . $awal . ':P' . $awal)->getBorders()->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
    $awal++;
    $no++;
}

$sheet->setCellValue('M' . $awal, 'TOTAL PROFIT');
$sheet->setCellValue('N' . $awal, $total_profit);
$sheet->getStyle('H' . $awal . ':P' . $awal)->getBorders()->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
$sheet->getStyle('H' . $awal . ':P' . $awal)->applyFromArray([
    'fill' => [
        'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
        'startColor' => [
            'argb' => '01FF00',
        ],
    ],
]);
