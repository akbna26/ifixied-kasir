<?php

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Color;
use PhpOffice\PhpSpreadsheet\Style\Alignment;

defined('BASEPATH') or exit('No direct script access allowed');

class Cetak extends MY_controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('query_global');
    }

    public function laporan_harian()
    {
        $tgl = $this->input->get('tanggal');
        $id_cabang = $this->input->get('id_cabang');
        if (empty($tgl) || empty($id_cabang)) {
            dd('not allowed');
        }

        $id_cabang = decode_id($id_cabang);
        $row_cabang = $this->db->query("SELECT * from ref_cabang where id='$id_cabang' and deleted is null ")->row();

        $spreadsheet = new Spreadsheet();

        include('sheet_1_cash.php');
        include('sheet_1_bca.php');
        include('sheet_1_bni.php');
        include('sheet_1_mandiri.php');
        include('sheet_1_profit.php');
        include('sheet_2_part.php');
        include('sheet_2_acc.php');
        include('sheet_2_retur.php');
        include('sheet_3_profit.php');
        include('sheet_4_operasional.php');
        include('sheet_5_kerugian.php');
        include('sheet_6_kasbon.php');
        include('sheet_7_modal_servis.php');

        // $spreadsheet->setActiveSheetIndex(0);
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="Laporan_harian_' . $row_cabang->nama . '_' . date('d-F-Y ', strtotime($tgl)) . '.xlsx"');
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

    private function get_modal($filter_cabang, $filter_tanggal)
    {
        $query = $this->query_global->modal();

        $where = "";
        $where .= "AND b.nm_jenis='cash' ";
        $where .= "AND a.id_cabang='$filter_cabang' ";

        $sub_query = "SELECT sum(a.kredit-a.debit)
            from ($query) as a
            left join ref_jenis_pembayaran b on b.id=a.id_pembayaran
            WHERE 1=1 $where and a.tanggal < '$filter_tanggal' ";

        $where .= "AND a.tanggal <= '$filter_tanggal' ";

        $row = $this->db->query("SELECT ($sub_query) as modal
                from ($query) as a
                left join ref_jenis_pembayaran b on b.id=a.id_pembayaran
                WHERE 1=1 $where
            ")->row();

        return empty($row->modal) ? 0 : $row->modal;
    }

    private function get_modal_part($filter_cabang, $filter_tanggal)
    {
        $query = $this->query_global->part();

        $where = "";
        if ($filter_cabang != 'all') $where .= "AND a.id_cabang='$filter_cabang' ";

        $sub_query = "SELECT IFNULL(sum(a.kredit-a.debit),0)
        from ($query) as a
        WHERE 1=1 $where and a.tanggal < '$filter_tanggal' ";

        $where .= "AND a.tanggal <= '$filter_tanggal' ";

        $row = $this->db->query("SELECT ($sub_query) as modal
            from ($query) as a
            WHERE 1=1 $where
        ")->row();

        return empty($row->modal) ? 0 : $row->modal;
    }

    private function get_modal_acc($filter_cabang, $filter_tanggal)
    {
        $query = $this->query_global->acc();

        $where = "";
        if ($filter_cabang != 'all') $where .= "AND a.id_cabang='$filter_cabang' ";

        $sub_query = "SELECT IFNULL(sum(a.kredit-a.debit),0)
        from ($query) as a
        WHERE 1=1 $where and a.tanggal < '$filter_tanggal' ";

        $where .= "AND a.tanggal <= '$filter_tanggal' ";

        $row = $this->db->query("SELECT ($sub_query) as modal
            from ($query) as a
            WHERE 1=1 $where
        ")->row();

        return empty($row->modal) ? 0 : $row->modal;
    }
}

/* End of file Dashboard.php */
