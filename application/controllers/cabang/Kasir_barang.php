<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Kasir_barang extends MY_controller
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        $data['cabang'] = $this->db->query("SELECT * from ref_cabang where id='$this->id_cabang' ")->row();
        $this->load->view('cabang/kasir_barang/index', $data);
    }
}
