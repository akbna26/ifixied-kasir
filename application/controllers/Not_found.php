<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Not_found extends CI_Controller
{

    public function index()
    {
        $data = [];
        $this->load->view('404', $data, FALSE);
    }
}

/* End of file Not_found.php */
