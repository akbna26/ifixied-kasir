<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nota DP</title>
    <style>
        body {
            font-family: Calibri;
        }
    </style>
</head>

<body>

    <table style="width: 100%;">
        <tr>
            <td style="width: 60px;">
                <img src="<?= base_url('uploads/img/logo.png') ?>" alt="img" style="width: 50px;">
            </td>
            <td>
                <b><?= $row->nm_cabang ?></b>
                <div><?= $row->lokasi ?></div>
                <div><?= $row->kontak ?></div>
            </td>
        </tr>>
    </table>

    <br>

    <table style="width: 100%;">
        <tr>
            <td style="width: 70%;">
                <h3>NOTA DOWN PAYMENT</h3>
            </td>
            <td style="text-align: right;">Waktu : <?= tgl_indo($row->tanggal, true) ?></td>
        </tr>
    </table>
    <hr>

    <table style="width: 100%;">
        <tr>
            <td style="width: 150px;">NO. INVOICE</td>
            <td>: <?= $row->kode ?></td>
            <td style="width: 150px;">ESTIMASI BIAYA</td>
            <td>: <?= rupiah($row->estimasi_biaya) ?></td>
        </tr>
        <tr>
            <td>NAMA</td>
            <td>: <?= $row->nama ?></td>
            <td>TOTAL DP</td>
            <td>: <?= rupiah($row->total) ?> (<?= $row->pembayaran  ?>)</td>
        </tr>
        <tr>
            <td>TELP.</td>
            <td>: <?= $row->no_hp ?></td>
            <td>KETERANGAN DP</td>
            <td>: <?= nl2br($row->keterangan) ?></td>
        </tr>
        <tr>
            <td>
                <b>
                    <u>NOTE</u>
                </b>
            </td>
            <td colspan="3">:</td>
        </tr>
    </table>

    <br>
    <hr>
    <table style="width: 100%;">
        <tr>
            <td style="width: 50%;"></td>
            <td style="text-align: center;">
                <b>PELANGGAN</b>
                <br>
                <br>
                <br>
                <br>
                <u>( <?= $row->nama ?> )</u>
            </td>
            <td style="text-align: center;">
                <b>PEGAWAI</b>
                <br>
                <br>
                <br>
                <br>
                <u>( <?= $row->nm_pegawai ?> )</u>
            </td>
        </tr>
    </table>
</body>

</html>