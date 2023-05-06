<?php

defined('BASEPATH') or exit('No direct script access allowed');

class API_controller extends CI_Controller
{
    public function set_success($data)
    {
        $data = array("status" => true) + $data;
        $this->output
            ->set_content_type('application/json', 'utf-8')
            ->set_status_header(200)
            ->set_output(json_encode($data));
    }

    public function set_failed($data)
    {
        $data = array("status" => false) + $data;
        $this->output
            ->set_content_type('application/json', 'utf-8')
            ->set_status_header(200)
            ->set_output(json_encode($data));
    }
}

/* End of file API_controller.php */
