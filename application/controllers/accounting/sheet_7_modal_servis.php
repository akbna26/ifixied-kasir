<?php

$sheet = $spreadsheet->createSheet(6);
$sheet->setTitle('MODAL SERVIS');
$sheet->setCellValue('A1', 'MODAL SERVIS IFIXIED ' . $row_cabang->nama . ' ' . date('d-m-Y', strtotime($tgl)));
$sheet->mergeCells('A1:E1');

$sheet->setCellValue('B2', 'TEKNISI ADNAN');
// judul
$sheet->setCellValue('A3', 'NO');
$sheet->setCellValue('B3', 'TANGGAL');
$sheet->setCellValue('C3', 'INFORMASI');
$sheet->setCellValue('D3', 'HARGA JUAL');
$sheet->setCellValue('E3', 'MODAL PART');
$sheet->setCellValue('F3', 'MODAL TEKNISI');
$sheet->setCellValue('G3', 'TINDAKAN');
// end judul
$sheet->getStyle('A3:G3')->getBorders()->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
$sheet->getStyle('A3:G3')->applyFromArray([
    'fill' => [
        'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
        'startColor' => [
            'argb' => 'FF9902',
        ],
    ],
]);
$sheet->getStyle('A3:G3')->getAlignment()->setHorizontal('center');

$awal = 4;
$no = 1;

$bulan = date('m', strtotime($tgl));
$tahun = date('Y', strtotime($tgl));

$data = $this->db->query("SELECT a.*, b.pelanggan, b.tipe_unit, b.no_hp, b.kerusakan, b.invoice, d.nama as nm_teknisi, e.nama as nm_tindakan,
    case when b.id_jenis_pembayaran_2=0 then f.nama else concat(f.nama,' (',b.bayar,') & ',g.nama,' (',b.bayar_split,')') end as metode_bayar,
    b.prosen_teknisi
    from profit_servis a
    left join servis_berat b on b.id=a.id
    left join setting_pegawai c on c.id=b.id_teknisi_setting
    left join pegawai d on d.id=c.id_pegawai
    left join ref_tindakan e on e.id=b.id_tindakan
    left join ref_jenis_pembayaran f on f.id=b.id_jenis_pembayaran
    left join ref_jenis_pembayaran g on g.id=b.id_jenis_pembayaran_2
    where a.id_cabang='$id_cabang' and MONTH(a.tgl_keluar)='$bulan' and YEAR(a.tgl_keluar)='$tahun'
")->result();

$total = 0;

foreach ($data as $row) {

    $hitung_fix = (($row->biaya - $row->harga_part) * ($row->prosen_teknisi / 100));
    $total += $hitung_fix;

    $sheet
        ->setCellValue('A' . $awal, $no++)
        ->setCellValue('B' . $awal, $row->tgl_keluar)
        ->setCellValue('C' . $awal, $row->pelanggan . ' / ' . $row->no_hp . ' - ' . $row->tipe_unit . ' (' . $row->kerusakan . ')')
        ->setCellValue('D' . $awal, $row->biaya)
        ->setCellValue('E' . $awal, $row->harga_part)
        ->setCellValue('F' . $awal, $hitung_fix)
        ->setCellValue('G' . $awal, $row->nm_tindakan . ' (' . $row->prosen_teknisi . '%)');
    $awal++;

    $sheet->getStyle('A' . $awal . ':G' . $awal)->getBorders()->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
}

$sheet
    ->setCellValue('E' . $awal, "TOTAL")
    ->setCellValue('F' . $awal, $total);

$sheet->getStyle('A' . $awal . ':G' . $awal)->applyFromArray([
    'fill' => [
        'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
        'startColor' => [
            'argb' => 'FF9902',
        ],
    ],
]);

foreach (['B', 'C', 'D', 'E', 'F', 'G'] as $column) $sheet->getColumnDimension($column)->setAutoSize(true);

$currencyFormat = '#,##';
$lastRow = $sheet->getHighestRow();
$sheet->getStyle('D1:F' . $lastRow)->getNumberFormat()->setFormatCode($currencyFormat);
