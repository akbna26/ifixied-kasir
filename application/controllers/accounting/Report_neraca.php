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
        $modal_one = $this->db->query("SELECT * from modal_one where id_cabang='$id_cabang' ")->result();
        $modal_one_fix = [];
        foreach ($modal_one as $key) {
            $modal_one_fix[$key->jenis] = $key;
        }
        $data['modal_one'] = $modal_one_fix;
        $data['modal_awal'] = $this->db->query("SELECT * from modal_awal where id_cabang='$id_cabang' order by id desc ")->row();

        $this->templates->load($data);
    }

    public function save_one()
    {
        cek_post();

        $id_cabang = $this->input->post('id_cabang');
        $jenis = $this->input->post('jenis');
        $value = clear_koma($this->input->post('value'));

        $cek_input = $this->db->get_where('modal_one', [
            'id_cabang' => $id_cabang,
            'jenis' => $jenis,
        ])->row();

        if (!empty($cek_input)) {
            $this->db->where('id', $cek_input->id);
            $this->db->update('modal_one', [
                'nominal' => $value,
                'updated' => date('Y-m-d H:i:s'),
            ]);
        } else {
            $this->db->insert('modal_one', [
                'id_cabang' => $id_cabang,
                'nominal' => $value,
                'jenis' => $jenis,
                'created' => date('Y-m-d H:i:s'),
            ]);
        }

        echo json_encode([
            'status' => 'success',
        ]);
    }
}

/* End of file Dashboard.php */
