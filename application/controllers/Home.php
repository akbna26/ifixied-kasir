<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Home extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        insert_visitor();
    }

    public function index()
    {
        echo 'home page';
    }
}
