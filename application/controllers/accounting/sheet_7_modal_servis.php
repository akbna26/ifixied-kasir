<?php

$sheet = $spreadsheet->createSheet(6);
$sheet->setTitle('MODAL SERVIS');
$sheet->setCellValue('A1', 'MODAL SERVIS IFIXIED ' . $row_cabang->nama . ' ' . date('d-m-Y', strtotime($tgl)));
$sheet->mergeCells('A1:E1');

$bulan = date('m', strtotime($tgl));
$tahun = date('Y', strtotime($tgl));

$data = $this->db->query("SELECT * FROM (
    (SELECT a.*, 'kredit' as jenis, b.is_refund, b.pelanggan, b.tipe_unit, b.no_hp, b.kerusakan, b.invoice, d.nama as nm_teknisi, e.nama as nm_tindakan,
    case when b.id_jenis_pembayaran_2=0 then f.nama else concat(f.nama,' (',b.bayar,') & ',g.nama,' (',b.bayar_split,')') end as metode_bayar,
    b.prosen_teknisi
    from profit_servis a
    left join servis_berat b on b.id=a.id
    left join setting_pegawai c on c.id=b.id_teknisi_setting
    left join pegawai d on d.id=c.id_pegawai
    left join ref_tindakan e on e.id=b.id_tindakan
    left join ref_jenis_pembayaran f on f.id=b.id_jenis_pembayaran
    left join ref_jenis_pembayaran g on g.id=b.id_jenis_pembayaran_2
    where a.id_cabang='$id_cabang' and MONTH(a.tgl_keluar)='$bulan' and YEAR(a.tgl_keluar)='$tahun') 
    UNION ALL
    (SELECT a.*, 'debit' as jenis, b.is_refund, b.pelanggan, b.tipe_unit, b.no_hp, b.kerusakan, b.invoice, d.nama as nm_teknisi, e.nama as nm_tindakan,
    case when b.id_jenis_pembayaran_2=0 then f.nama else concat(f.nama,' (',b.bayar,') & ',g.nama,' (',b.bayar_split,')') end as metode_bayar,
    b.prosen_teknisi
    from profit_servis a
    left join servis_berat b on b.id=a.id
    left join setting_pegawai c on c.id=b.id_teknisi_setting
    left join pegawai d on d.id=c.id_pegawai
    left join ref_tindakan e on e.id=b.id_tindakan
    left join ref_jenis_pembayaran f on f.id=b.id_jenis_pembayaran
    left join ref_jenis_pembayaran g on g.id=b.id_jenis_pembayaran_2
    where a.id_cabang='$id_cabang' and MONTH(a.tgl_keluar)='$bulan' and YEAR(a.tgl_keluar)='$tahun' and b.is_refund='1')
) a order by a.tgl_keluar asc
")->result();

$fix_data = [];
foreach ($data as $dt) {
    $fix_data[$dt->nm_teknisi][] = $dt;
}

$awal = 3;

foreach ($fix_data as $index => $dt) {
    $sheet->setCellValue('B' . $awal, 'TEKNISI ' . $index);
    $awal += 1;
    // judul
    $sheet->setCellValue('A' . $awal, 'NO');
    $sheet->setCellValue('B' . $awal, 'TANGGAL');
    $sheet->setCellValue('C' . $awal, 'INFORMASI');
    $sheet->setCellValue('D' . $awal, 'KREDIT');
    $sheet->setCellValue('E' . $awal, 'DEBIT');
    $sheet->setCellValue('F' . $awal, 'TINDAKAN');
    // end judul
    $sheet->getStyle('A' . $awal . ':F' . $awal)->getBorders()->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
    $sheet->getStyle('A' . $awal . ':F' . $awal)->applyFromArray([
        'fill' => [
            'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
            'startColor' => [
                'argb' => 'FF9902',
            ],
        ],
    ]);
    $sheet->getStyle('A' . $awal . ':F' . $awal)->getAlignment()->setHorizontal('center');

    $awal += 1;
    $no = 1;

    $total_kredit = 0;
    $total_debit = 0;

    foreach ($dt as $row) {
        $hitung_kredit = 0;
        $hitung_debit = 0;
        if ($row->jenis == 'debit') {
            $hitung_debit = $row->modal - $row->harga_part;
            $total_debit += $hitung_debit;
        } else {
            $hitung_kredit = $row->modal - $row->harga_part;
            $total_kredit += $hitung_kredit;
        }

        $sheet
            ->setCellValue('A' . $awal, $no++)
            ->setCellValue('B' . $awal, $row->tgl_keluar)
            ->setCellValue('C' . $awal, $row->pelanggan . ' / ' . $row->no_hp . ' - ' . $row->tipe_unit . ' (' . $row->kerusakan . ')')
            ->setCellValue('D' . $awal, $hitung_kredit)
            ->setCellValue('E' . $awal, $hitung_debit)
            ->setCellValue('F' . $awal, $row->nm_tindakan . ' (' . $row->prosen_teknisi . '%)');

        $sheet->getStyle('A' . $awal . ':F' . $awal)->getBorders()->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        $awal++;
    }

    $sheet
        ->setCellValue('C' . $awal, "TOTAL")
        ->setCellValue('D' . $awal, $total_kredit)
        ->setCellValue('E' . $awal, $total_debit)
        ->setCellValue('F' . $awal, ($total_kredit - $total_debit));

    $sheet->getStyle('F' . $awal)->getAlignment()->setHorizontal('left');
    $sheet->getStyle('A' . $awal . ':F' . $awal)->applyFromArray([
        'fill' => [
            'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
            'startColor' => [
                'argb' => 'FF9902',
            ],
        ],
    ]);

    $awal += 3;
}

foreach (['B', 'C', 'D', 'E', 'F', 'G'] as $column) $sheet->getColumnDimension($column)->setAutoSize(true);

$currencyFormat = '#,##';
$lastRow = $sheet->getHighestRow();
$sheet->getStyle('D1:F' . $lastRow)->getNumberFormat()->setFormatCode($currencyFormat);
