<?php

function data_sistem($get = 'nama')
{
    $data = [
        'nama' => 'Sistem Informasi Kasir Ifixied',
        'deskripsi' => 'IFixied Global Indonesia',
        'pemilik' => 'IFIXIED',
    ];

    return $data[$get];
}
