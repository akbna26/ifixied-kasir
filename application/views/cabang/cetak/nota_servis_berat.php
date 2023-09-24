<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nota Servis</title>
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
            /* letter-spacing: 2 !important; */
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
                <b style="font-size: 16px;">IFIXIED | <?= $row->nm_cabang ?></b>
                <div><?= $row->lokasi ?></div>
                <div><?= $row->kontak ?></div>
            </td>
            <td style="text-align: right;">
                <b style="font-size: 16px;">NOTA SERVICE</b>
                <div style="text-align: right;">NO. INVOICE : <b style="font-size: 10px;"><?= $row->invoice ?></b></div>
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
    </table>

    <br>

    <table style="width: 100%;" class="list">
        <thead>
            <tr>
                <th style="width: 120px;">Unit</th>
                <th style="width: 120px;">Serial Number</th>
                <th>Kerusakan</th>
                <th>Tindakan</th>
                <?php if (!empty($row->biaya)) : ?>
                    <th>Total Biaya</th>
                <?php else : ?>
                    <th>Estimasi Biaya</th>
                <?php endif; ?>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td><?= $row->tipe_unit ?></td>
                <td><?= $row->serial_number ?></td>
                <td><?= $row->kerusakan ?></td>
                <td><?= $row->nm_tindakan ?></td>
                <?php if (!empty($row->biaya)) : ?>
                    <td><?= rupiah($row->biaya) ?></td>
                <?php else : ?>
                    <td><?= rupiah($row->estimasi_biaya) ?></td>
                <?php endif; ?>
            </tr>
        </tbody>
    </table>

    <br>

    <table style="width: 100%;" class="font-12">
        <tbody>
            <tr>
                <td rowspan="4">
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
                </td>
                <td style="text-align: right;width: 100px;">Total :</td>
                <td style="text-align: right;width: 100px;" class="border-bottom"><?= rupiah($row->biaya) ?></td>
            </tr>
            <tr>
                <td colspan="1" style="text-align: right;">Bayar :</td>
                <td style="text-align: right;" class="border-bottom"><?= rupiah($row->bayar) ?> <div style="font-size: 10px;">(<?= $row->pembayaran_1  ?>)</div>
                </td>
            </tr>
            <tr>
                <td colspan="1" style="text-align: right;">Split :</td>
                <td style="text-align: right;" class="border-bottom"><?= empty($row->bayar_split) ? 0 : rupiah($row->bayar_split) ?>
                    <?php if ($row->pembayaran_2) : ?>
                        <div style="font-size: 10px;">(<?= $row->pembayaran_2  ?>)</div>
                    <?php endif ?>
                </td>
            </tr>
            <tr>
                <td colspan="1" style="text-align: right;">Kembalian :</td>
                <td style="text-align: right;" class="border-bottom"><?= (($row->bayar + $row->bayar_split) - $row->biaya) == 0 ? 0 : rupiah(($row->bayar + $row->bayar_split) - $row->biaya) ?></td>
            </tr>
    </table>

    <?php if (empty($row->biaya)) : ?>
        <br>
        <br>
        <div>NB: <span style="color: red;">lorem ipsum dolor sit amet</span></div>
    <?php endif; ?>
</body>

</html>