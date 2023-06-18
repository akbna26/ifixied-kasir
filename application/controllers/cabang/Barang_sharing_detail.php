<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Barang_sharing_detail extends MY_controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('cabang/table_barang_sharing_detail', 'table');
    }

    public function index($id)
    {
        $data = [
            'index' => 'cabang/barang_sharing_detail/index',
            'index_js' => 'cabang/barang_sharing_detail/index_js',
            'title' => 'Detail Sharing',
        ];

        $id = decode_id($id);
        $data['id'] = $id;
        $data['row'] = $this->db->query("SELECT a.*, b.nama from sharing a 
            left join ref_cabang b on b.id=a.id_cabang
        where a.id='$id' ")->row();

        $this->templates->load($data);
    }

    public function table()
    {
        echo $this->table->generate_table();
    }
}
