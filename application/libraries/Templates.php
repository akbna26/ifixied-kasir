<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Templates
{
    protected $ci;

    public function __construct()
    {
        $this->ci = &get_instance();
    }

    public function load($data)
    {
        if ($_SESSION['id_otoritas'] == 1) $inc = 'template/sidebar_super_admin';
        if ($_SESSION['id_otoritas'] == 2) $inc = 'template/sidebar_admin';
        if ($_SESSION['id_otoritas'] == 3) $inc = 'template/sidebar_cabang';

        $data['include_sidebar'] = $inc;

        $this->ci->load->view('template/main', $data);
    }
    
}

/* End of file LibraryName.php */