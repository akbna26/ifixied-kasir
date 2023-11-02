<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Sirkulasi_acc extends MY_controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('gudang/table_sirkulasi_acc', 'table');
    }

    public function index()
    {
        $data = [
            'index' => 'gudang/sirkulasi_acc/index',
            'index_js' => 'gudang/sirkulasi_acc/index_js',
            'title' => 'Sirkulasi Acc',
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
        $filter_cabang = $this->input->post('filter_cabang');
        $filter_tanggal = $this->input->post('filter_tanggal');

        $query = $this->query_global->acc();

        $where = "";
        if ($filter_cabang != 'all') {
            $where .= "AND a.id_cabang='$filter_cabang' ";
        } else {
            if ($this->type == 'owner_cabang') {
                $row = $this->db->query("SELECT * from data_user where id='$this->id_akun' ")->row();
                $where .= "AND a.id_cabang in ($row->id_cabang_multi) ";
            }
        }

        if ($filter_tanggal == '') $filter_tanggal = date('Y-m-d');

        $sub_query = "SELECT IFNULL(sum(a.kredit-a.debit),0)
        from ($query) as a
        WHERE 1=1 $where and a.tanggal < '$filter_tanggal' ";

        $sub_query_debit = "SELECT IFNULL(sum(a.debit),0)
        from ($query) as a
        WHERE 1=1 $where and a.tanggal = '$filter_tanggal' ";

        $sub_query_kredit = "SELECT IFNULL(sum(a.kredit),0)
        from ($query) as a
        WHERE 1=1 $where and a.tanggal = '$filter_tanggal' ";

        $where .= "AND a.tanggal <= '$filter_tanggal' ";

        $row = $this->db->query("SELECT ($sub_query) as modal, (($sub_query)+($sub_query_kredit)) as kredit, 
            ($sub_query_debit) as debit, sum(a.kredit-a.debit) as total
            from ($query) as a
            WHERE 1=1 $where
        ")->row();

        echo json_encode([
            'status' => 'success',
            'total_modal' => rupiah(@$row->modal),
            'total_kredit' => rupiah(@$row->kredit),
            'total_debit' => rupiah(@$row->debit),
            'total' => rupiah(@$row->total),
        ]);
    }
}
