<?php
function encode_id($id_ = null)
{
    if ($id_ == null) {
        return '';
    } else {
        return substr(md5($id_), 0, 20) . $id_ . substr(md5($id_), 20, 12);
    }
}

function decode_id($id_ = null)
{
    if ($id_ == null) {
        return '';
    } else {
        return substr($id_, 20, strlen($id_) - 32);
    }
}

function dd($arr)
{
    echo json_encode($arr);
    die;
}

function json($arr)
{
    header('Content-Type: application/json; charset=utf-8');
    echo json_encode($arr);
    die;
}

function generateRandomString($length = 5)
{
    $characters = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}

function rupiah($data, $is_koma = false)
{
    if ($data == null) {
        return '';
    } else {
        if ($is_koma == true) {
            return number_format($data, 2, ',', '.');
        } else {
            return number_format($data, 0, ',', '.');
        }
    }
}

function session($name = null)
{

    $CI = &get_instance();
    if (!$name) {
        echo json_encode($_SESSION);
        die;
    } else {
        return $CI->session->userdata($name);
    }
}

function cek_post()
{
    if (!$_POST) {
        echo 'not allowed';
        die;
    }
}

function tgl_indo($tgl = null, $jam = false)
{
    if ($tgl != null) {
        if ($jam) {
            $date = strtotime($tgl);
            $tanggal = strftime('%d %B %Y %H:%M', $date);
            return $tanggal;
        } else {
            $date = strtotime($tgl);
            $tanggal = strftime('%d %B %Y', $date);
            return $tanggal;
        }
    } else {
        return '';
    }
}

function clear_koma($dt)
{
    $data = str_replace('.', '', $dt);
    $data = str_replace(',', '.', $data);
    return $data;
}