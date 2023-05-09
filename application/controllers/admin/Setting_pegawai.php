<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Setting_pegawai extends MY_controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('admin/table_setting_pegawai', 'table');
    }

    public function index()
    {
        $data = [
            'index' => 'admin/setting_pegawai/index',
            'index_js' => 'admin/setting_pegawai/index_js',
            'title' => 'Setting Profit Pegawai',
        ];

        $data['ref_cabang'] = $this->db->query("SELECT * from ref_cabang where deleted is null")->result();

        $this->templates->load($data);
    }

    public function table()
    {
        echo $this->table->generate_table();
    }

    public function tambah()
    {
        $data['ref_cabang'] = $this->db->query("SELECT * from ref_cabang where deleted is null")->result();
        $data['ref_tindakan'] = $this->db->query("SELECT * from ref_tindakan where deleted is null")->result();
        $html = $this->load->view('admin/setting_pegawai/form', $data, true);

        echo json_encode([
            'status' => 'success',
            'html' => $html,
        ]);
    }

    public function ubah()
    {
        $id = decode_id($this->input->post('id'));
        
        $row = $this->db->query("SELECT a.*, b.id_cabang
            from setting_pegawai a 
            left join pegawai b on b.id=a.id_pegawai 
            where a.id='$id' and a.deleted is null 
        ")->row();

        $data['id'] = $id;
        $data['ref_cabang'] = $this->db->query("SELECT * from ref_cabang where deleted is null")->result();
        $data['ref_tindakan'] = $this->db->query("SELECT * from ref_tindakan where deleted is null")->result();
        $data['pegawai'] = $this->db->query("SELECT * from pegawai where id_cabang='$row->id_cabang' and deleted is null")->result();
        $data['data'] = $row;
        $html = $this->load->view('admin/setting_pegawai/form', $data, true);

        echo json_encode([
            'status' => 'success',
            'html' => $html,
        ]);
    }

    public function do_submit()
    {
        cek_post();
        $id = decode_id($this->input->post('id'));
        $hapus = $this->input->post('hapus');

        $id_pegawai = $this->input->post('id_pegawai');
        $id_tindakan = $this->input->post('id_tindakan');
        $prosentase = clear_koma($this->input->post('prosentase'));

        if (!empty($hapus)) {
            $this->db->where('id', $id);
            $this->db->update('setting_pegawai', [
                'deleted' => date('Y-m-d H:i:s'),
            ]);
        } else {
            if (empty($id)) {
                $this->db->insert('setting_pegawai', [
                    'id_pegawai' => $id_pegawai,
                    'id_tindakan' => $id_tindakan,
                    'prosentase' => $prosentase,
                    'created' => date('Y-m-d H:i:s'),
                ]);
            } else {
                $this->db->where('id', $id);
                $this->db->update('setting_pegawai', [
                    'id_pegawai' => $id_pegawai,
                    'id_tindakan' => $id_tindakan,
                    'prosentase' => $prosentase,
                    'updated' => date('Y-m-d H:i:s'),
                ]);
            }
        }

        echo json_encode([
            'status' => 'success'
        ]);
    }
}
