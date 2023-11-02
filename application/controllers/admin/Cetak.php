<?php

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Color;

defined('BASEPATH') or exit('No direct script access allowed');

class Cetak extends MY_controller
{

    public function __construct()
    {
        parent::__construct();
    }

    public function detail_sharing($id = null)
    {
        if (!$id) {
            dd('not allowed');
        }

        $id = decode_id($id);

        $mpdf = new \Mpdf\Mpdf(['mode' => 'utf-8', 'format' => 'A4']); //lebar x tinggi kertas // jika custom [120,75]
        $mpdf->AddPage('P', '', '', '', '', 10, 10, 10, 10); // L, R, T, B
        $mpdf->SetDisplayMode('fullpage');
        $mpdf->SetDisplayPreferences('FullScreen');

        $data['detail'] = $this->db->query("SELECT a.*, b.nama from sharing a 
            left join ref_cabang b on b.id=a.id_cabang
        where a.id='$id' ")->row();

        $data['row'] = $this->db->query("SELECT
            a.*,
            b.nama AS barang,
            b.barcode,
            c.nama AS kategori,
            d.is_konfirmasi,
            ( a.stock * b.harga_modal ) AS modal,
            e.nama as nm_cabang
        FROM
            sharing_detail a
            LEFT JOIN barang b ON b.id = a.id_barang AND b.deleted
            IS NULL LEFT JOIN ref_kategori c ON c.id = b.id_kategori
            LEFT JOIN sharing d ON d.id = a.id_sharing 
            LEFT JOIN ref_cabang e on e.id=d.id_cabang
        WHERE
            a.deleted IS NULL 
            AND a.id_sharing = '$id'
        ")->result();

        $data['user'] = $this->db->query("SELECT * from data_user where id='$this->id_akun' ")->row();
        $html = $this->load->view('admin/cetak/sharing', $data, true);
        $mpdf->WriteHTML($html);
        $cetak = 'detail-sharing.pdf';
        $mpdf->Output($cetak, 'I'); // opens in browser 
    }

    public function detail_sharing_excel($id = null)
    {
        if (!$id) {
            dd('not allowed');
        }

        $id = decode_id($id);

        $data = $this->db->query("SELECT
            a.*,
            b.nama AS barang,
            b.barcode,
            c.nama AS kategori,
            d.is_konfirmasi,
            ( a.stock * b.harga_modal ) AS modal,
            e.nama as nm_cabang
        FROM
            sharing_detail a
            LEFT JOIN barang b ON b.id = a.id_barang AND b.deleted
            IS NULL LEFT JOIN ref_kategori c ON c.id = b.id_kategori
            LEFT JOIN sharing d ON d.id = a.id_sharing 
            LEFT JOIN ref_cabang e on e.id=d.id_cabang
        WHERE
            a.deleted IS NULL 
            AND a.id_sharing = '$id'
        ")->result();

        $spreadsheet = new Spreadsheet();
        $spreadsheet->setActiveSheetIndex(0);
        $spreadsheet->setActiveSheetIndex(0)->setCellValue('A1', 'Detail Sharing');
        $spreadsheet->setActiveSheetIndex(0)->getStyle('A1')->getFont()->setBold(true);

        $judul = [
            'NO',
            'CABANG',
            'KATEGORI',
            'BARCODE',
            'BARANG',
            'STOCK',
            'MODAL',
        ];
        $alphabet = generateAlphabetArray($judul);

        foreach ($alphabet as $key => $value) {
            $spreadsheet->setActiveSheetIndex(0)->setCellValue($value . '3', $judul[$key]);
        }
        $spreadsheet->setActiveSheetIndex(0)->getStyle('A3:G3')->getFont()->setBold(true);

        $awal = 4;
        $no = 1;
        foreach ($data as $row) {

            $spreadsheet->setActiveSheetIndex(0)
                ->setCellValue('A' . $awal, $no++)
                ->setCellValue('B' . $awal, $row->nm_cabang)
                ->setCellValue('C' . $awal, $row->kategori)
                ->setCellValue('D' . $awal, $row->barcode)
                ->setCellValue('E' . $awal, $row->barang)
                ->setCellValue('F' . $awal, $row->stock)
                ->setCellValue('G' . $awal, $row->modal);
            $awal++;
        }
        $awal--;

        $spreadsheet->setActiveSheetIndex(0)->getStyle('A3:G' . $awal)->getBorders()->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        foreach ($alphabet as $key => $value) {
            if (!in_array($value, ['A'])) $spreadsheet->setActiveSheetIndex(0)->getColumnDimension($value)->setAutoSize(true);
        }

        // $spreadsheet->setActiveSheetIndex(0)->getStyle('C4:C' . $awal)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
        // $spreadsheet->setActiveSheetIndex(0)->getStyle('T4:X' . $awal)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="Export_sharing_barang_' . date('d-m-Y H:i:s') . '.xlsx"');
        header('Cache-Control: max-age=0');
        header('Cache-Control: max-age=1');

        header('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
        header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT'); // always modified
        header('Cache-Control: cache, must-revalidate'); // HTTP/1.1
        header('Pragma: public'); // HTTP/1.0

        $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
        $writer->save('php://output');
        exit;
    }

    public function barang_cabang()
    {
        $id_cabang = $this->input->get('id_cabang');

        if (!$id_cabang) {
            dd('not allowed');
        }

        $data = $this->db->query("SELECT
            b.barcode, b.nama as nm_barang, a.stock, c.nama as nm_kategori
        FROM
            barang_cabang a
            LEFT JOIN barang b ON b.id = a.id_barang
            LEFT JOIN ref_kategori c ON c.id = b.id_kategori
        WHERE
            a.deleted IS NULL AND a.id_cabang='$id_cabang'
            order by c.nama asc, b.nama asc
        ")->result();

        $row_cabang = $this->db->query("SELECT * from ref_cabang where id='$id_cabang' and deleted is null ")->row();
        $spreadsheet = new Spreadsheet();

        $sheet = $spreadsheet->createSheet(0);
        $sheet->setTitle('BARANG CABANG');
        // judul
        $sheet->setCellValue('A1', 'BARCODE');
        $sheet->setCellValue('B1', 'NAMA BARANG');
        $sheet->setCellValue('C1', 'STOCK');
        $sheet->setCellValue('D1', 'KATEGORI');
        // end judul
        $sheet->getStyle('A1:D1')->getBorders()->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);

        $sheet->getStyle('A1:D1')->applyFromArray([
            'fill' => [
                'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                'startColor' => [
                    'argb' => 'FF9902',
                ],
            ],
        ]);

        $sheet->getStyle('A1:D1')->getAlignment()->setHorizontal('center');

        foreach (['A', 'B', 'C', 'D'] as $column) $sheet->getColumnDimension($column)->setAutoSize(true);

        $awal = 2;
        $no = 1;

        foreach ($data as $row) {

            $sheet
                ->setCellValue('A' . $awal, $row->barcode)
                ->setCellValue('B' . $awal, $row->nm_barang)
                ->setCellValue('C' . $awal, $row->stock)
                ->setCellValue('D' . $awal, $row->nm_kategori);

            $sheet->getStyle('A' . $awal . ':D' . $awal)->getBorders()->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
            $awal++;
        }

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="Barang Cabang ' . $row_cabang->nama . ' ' . date('d-F-Y') . '.xlsx"');
        header('Cache-Control: max-age=0');
        header('Cache-Control: max-age=1');

        header('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
        header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT'); // always modified
        header('Cache-Control: cache, must-revalidate'); // HTTP/1.1
        header('Pragma: public'); // HTTP/1.0

        $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
        $writer->save('php://output');
        exit;
    }
}

/* End of file Dashboard.php */
