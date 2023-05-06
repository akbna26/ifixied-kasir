<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Informasi extends MY_controller
{

    public function all()
    {
        $data = [
            'index' => 'informasi/index',
            'index_js' => 'informasi/index_js',
            'title' => 'Semua Informasi',
            'list_data' => $this->db->query("SELECT * from informasi where deleted is null order by id desc")->result(),
        ];

        $this->templates->load($data);
    }
}
