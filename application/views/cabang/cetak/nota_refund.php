<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nota Refund</title>
    <style>
        table.list thead tr th,
        table.list tbody tr td {
            border: 1px solid #34495e;
        }

        .border {
            font-size: 11px;
            font-weight: bold;
        }

        table.info tr th,
        table.info tr td {
            font-size: 11px;
            border: 1px solid #34495e;
        }

        table.info,
        table.list {
            border-collapse: collapse;
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
                <h3>NOTA REFUND</h3>
            </td>
            <td style="text-align: right;">Waktu : <?= tgl_indo($row->tanggal) ?></td>
        </tr>
    </table>
    <hr>

    <table style="width: 100%;" class="list">
        <tr>
            <td style="width: 150px;">NO. INVOICE</td>
            <td style="width: 200px;">: <?= $row->no_invoice ?></td>
            <td style="width: 150px;">TELP.</td>
            <td>: <?= $row->no_hp ?></td>            
        </tr>
        <tr>
            <td>NAMA</td>
            <td>: <?= $row->pelanggan ?></td>
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
    

    <table style="width: 100%;" class="list">
        <thead>
            <tr>
                <th>PRODUK</th>
                <th>QTY/HARGA</th>
                <th style="width: 150px;">STATUS KLAIM</th>
                <th>NILAI REFUND</th>
                <th>BARANG<br>PENGGANTI</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($detail as $i => $dt) : ?>
                <tr>
                    <td><?= $dt->barang ?></td>
                    <td><?= $dt->qty ?> @<?= rupiah($dt->harga_modal) ?></td>
                    <td><?= $dt->nm_klaim ?></td>
                    <td><?= in_array($dt->id_klaim, [3, 4]) ? rupiah($dt->nilai_refund) : '-' ?> <?= in_array($dt->id_klaim, [3, 4]) ? '<small>(' . ($dt->nm_pembayaran) . ')</small>' : '' ?></td>
                    <td><?= $dt->nm_pengganti ?? '-' ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <br>
    <br>
    
    <table style="width: 100%;">
        <tr>
            <td style="width: 50%;"></td>
            <td style="text-align: center;">
                <b>PELANGGAN</b>
                <br>
                <br>
                <br>
                <br>
                <u>( <?= $row->pelanggan ?> )</u>
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