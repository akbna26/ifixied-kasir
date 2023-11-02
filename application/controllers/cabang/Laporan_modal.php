<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Laporan_modal extends MY_controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('cabang/table_laporan_modal', 'table');
        $this->load->model('query_global');
    }

    public function index()
    {
        $data = [
            'index' => 'cabang/laporan_modal/index',
            'index_js' => 'cabang/laporan_modal/index_js',
            'title' => 'Laporan Sirkulasi Transaksi',
        ];

        $where = '';
        if (session('type') == 'owner_cabang') {
            $row = $this->db->query("SELECT * from data_user where id='$this->id_akun' ")->row();
            $where .= "AND id in ($row->id_cabang_multi)";
        }
        $data['ref_cabang'] = $this->db->query("SELECT * from ref_cabang where deleted is null $where")->result();

        $this->templates->load($data);
    }

    public function table()
    {
        echo $this->table->generate_table();
    }

    public function generate_total()
    {
        cek_post();
        $filter_rekening = $this->input->post('filter_rekening');
        $filter_cabang = $this->input->post('filter_cabang');
        $filter_tanggal = $this->input->post('filter_tanggal');

        $query = $this->query_global->modal();

        $where = "";
        if ($filter_rekening != 'all') $where .= "AND b.nm_jenis='$filter_rekening' ";
        if ($filter_cabang != 'all') $where .= "AND a.id_cabang='$filter_cabang' ";
        if ($filter_tanggal == '') $filter_tanggal = date('Y-m-d');

        if ($filter_rekening == 'cash') {

            $sub_query = "SELECT sum(a.kredit-a.debit)
            from ($query) as a
            left join ref_jenis_pembayaran b on b.id=a.id_pembayaran
            WHERE 1=1 $where and a.tanggal < '$filter_tanggal' ";

            $sub_query_debit = "SELECT sum(a.debit)
            from ($query) as a
            left join ref_jenis_pembayaran b on b.id=a.id_pembayaran
            WHERE 1=1 $where and a.tanggal = '$filter_tanggal' ";

            $sub_query_kredit = "SELECT sum(a.kredit)
            from ($query) as a
            left join ref_jenis_pembayaran b on b.id=a.id_pembayaran
            WHERE 1=1 $where and a.tanggal = '$filter_tanggal' ";

            $where .= "AND a.tanggal <= '$filter_tanggal' ";

            $row = $this->db->query("SELECT ($sub_query) as modal, ($sub_query)+IFNULL(($sub_query_kredit),0) as kredit, 
                ($sub_query_debit) as debit, sum(a.kredit-a.debit) as total
                from ($query) as a
                left join ref_jenis_pembayaran b on b.id=a.id_pembayaran
                WHERE 1=1 $where
            ")->row();
        } else {
            if ($filter_tanggal != '') $where .= "AND a.tanggal='$filter_tanggal' ";

            $row = $this->db->query("SELECT sum(a.kredit) as kredit, sum(a.debit) as debit, sum(a.kredit-a.debit) as total, 0 as modal
                from ($query) as a
                left join ref_jenis_pembayaran b on b.id=a.id_pembayaran
                WHERE 1=1 $where
            ")->row();
        }

        echo json_encode([
            'status' => 'success',
            'total_modal' => rupiah(@$row->modal),
            'total_kredit' => rupiah(@$row->kredit),
            'total_debit' => rupiah(@$row->debit),
            'total' => rupiah(@$row->total),
        ]);
    }
}
