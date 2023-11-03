<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Report_neraca extends MY_controller
{

    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        $data = [
            'index' => 'accounting/report_neraca/index',
            'index_js' => 'accounting/report_neraca/index_js',
            'title' => 'Report Neraca Harian',
        ];

        $where = '';
        if (session('type') == 'owner_cabang') {
            $row = $this->db->query("SELECT * from data_user where id='$this->id_akun' ")->row();
            $where .= "AND id in ($row->id_cabang_multi)";
        }
        $data['cabang'] = $this->db->query("SELECT * from ref_cabang where deleted is null $where order by nama")->result();
        $this->templates->load($data);
    }

    public function detail()
    {
        $data = [
            'index' => 'accounting/report_neraca/detail',
            'index_js' => 'accounting/report_neraca/detail_js',
            'title' => 'Detail - Report Neraca Harian',
        ];

        $id_cabang = decode_id($this->input->get('id_cabang'));
        $tanggal = $this->input->get('tanggal');

        if (!$id_cabang || !$tanggal) {
            dd('now allowed');
        }

        $data['id_cabang'] = $id_cabang;
        $data['tanggal'] = $tanggal;
        $data['cabang'] = $this->db->query("SELECT * from ref_cabang where deleted is null and id='$id_cabang' ")->row();

        $ref_jenis_modal  = $this->db->query("SELECT * from ref_jenis_modal where deleted is null")->result();

        $modal_neraca = $this->db->query("SELECT a.*
            from modal_neraca a
            where a.id_cabang='$id_cabang' and a.tanggal='$tanggal'
        ")->result();

        $fix_modal_neraca = [];
        foreach ($ref_jenis_modal as $key) {
            $fix_modal_neraca[$key->nama] = [];
            foreach ($modal_neraca as $dt) {
                if ($key->id == $dt->id_jenis) $fix_modal_neraca[$key->nama][] = $dt;
            }
        }

        $data['modal_neraca'] = $fix_modal_neraca;

        $this->templates->load($data);
    }
}

/* End of file Dashboard.php */
