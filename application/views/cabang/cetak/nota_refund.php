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

        table.info tr th,
        table.info tr td {
            border: 1px solid #34495e;
        }

        table.info,
        table.list {
            border-collapse: collapse;
        }

        table.list tr th,
        table.list tr td {
            text-align: center;
        }

        body {
            font-size: 12px !important;
            letter-spacing: 2 !important;
        }

        .border-bottom {
            border-bottom: 1px solid #34495e;
        }

        .font-12 {
            font-size: 12px;
        }
    </style>
</head>

<body>

    <table style="width: 100%;" class="font-12">
        <tr>
            <td>
                <b style="font-size: 10px;">IFIXIED | <?= $row->nm_cabang ?></b>
                <div><?= $row->lokasi ?></div>
                <div><?= $row->kontak ?></div>
            </td>
            <td style="text-align: right;">
                <b>NOTA REFUND</b>
                <div style="text-align: right;">NO. INVOICE : <b style="font-size: 10px;"><?= $row->no_invoice ?></b></div>
                <div style="text-align: right;"><?= tgl_indo($row->created, true) ?></div>
            </td>
        </tr>>
    </table>

    <hr style="margin-top: 2px;margin-bottom: 2px;">

    <table style="width: 100%;" class="font-12">
        <tr>
            <td style="width: 50px;">NAMA</td>
            <td style="width: 150px;">: <?= $row->pelanggan ?></td>
            <td style="width: 50px;">KETERANGAN</td>
            <td>: <?= nl2br($row->keterangan) ?></td>
        </tr>
        <tr>
            <td>TELP.</td>
            <td>: <?= $row->no_hp ?? '-' ?></td>
            <td>
                <b>
                    <u>NOTE</u>
                </b>
            </td>
            <td>: </td>
        </tr>
        <tr>
            <td>PIC</td>
            <td>: <?= $row->nm_pegawai ?></td>
            <td></td>
            <td></td>
        </tr>
    </table>

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

    <table style="width: 100%;" class="list">
        <tbody>
            <tr>
                <td style="text-align: center;width: 150px;">
                    <b>PELANGGAN</b>
                    <br>
                    <br>
                    <br>
                    <br>
                    <u>( <?= $row->pelanggan ?> )</u>
                </td>
                <td style="text-align: center;width: 150px;">
                    <b>ADMIN</b>
                    <br>
                    <br>
                    <br>
                    <br>
                    <u>( <?= $this->nama ?> )</u>
                </td>
                <td style="border: 0;"></td>
            </tr>
        </tbody>
    </table>
</body>

</html>