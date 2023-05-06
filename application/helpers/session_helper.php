<?php

function data_sistem($get = 'nama')
{
    $data = [
        'nama' => 'Sistem Informasi Kasir Ifixied',
        'deskripsi' => 'CV. iFixied Global Indonesia',
        'pemilik' => 'IFIXIED',
    ];

    return $data[$get];
}
