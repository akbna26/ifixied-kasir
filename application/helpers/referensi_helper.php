<?php

function total_informasi()
{
    $ci = &get_instance();
    $data = $ci->db->query("SELECT * from informasi where deleted is null order by id desc")->result();
    return $data;
}


function getUserIP()
{
    // Get real visitor IP behind CloudFlare network
    if (isset($_SERVER["HTTP_CF_CONNECTING_IP"])) {
        $_SERVER['REMOTE_ADDR'] = $_SERVER["HTTP_CF_CONNECTING_IP"];
        $_SERVER['HTTP_CLIENT_IP'] = $_SERVER["HTTP_CF_CONNECTING_IP"];
    }
    $client  = @$_SERVER['HTTP_CLIENT_IP'];
    $forward = @$_SERVER['HTTP_X_FORWARDED_FOR'];
    $remote  = $_SERVER['REMOTE_ADDR'];

    if (filter_var($client, FILTER_VALIDATE_IP)) {
        $ip = $client;
    } elseif (filter_var($forward, FILTER_VALIDATE_IP)) {
        $ip = $forward;
    } else {
        $ip = $remote;
    }
    return $ip;
}

function insert_visitor()
{
    $ip = getUserIP();
    $CI = &get_instance();
    $cek_ada = $CI->db->get_where('visitor', [
        'waktu' => date('Y-m-d'),
        'ip' => $ip
    ])->row();

    if (empty($cek_ada)) {
        $CI->db->insert('visitor', [
            'waktu' => date('Y-m-d'),
            'ip' => $ip,
            'created' => date('Y-m-d H:i:s'),
        ]);
    }
}
