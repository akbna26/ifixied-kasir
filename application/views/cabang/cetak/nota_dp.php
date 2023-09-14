<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nota DP</title>
    <style>
        .border {
            border: 1px solid #34495e;
            padding: 5px;
        }

        table.info tr th,
        table.info tr td {
            border: 1px solid #34495e;
        }

        table.info,
        table.list {
            border-collapse: collapse;
        }

        body {
            font-size: 12px !important;
        }

        .border-bottom {
            border-bottom: 1px solid #34495e;
        }

        .font-12 {
            font-size: 12px;
        }

        .bold {
            font-weight: bold;
        }
    </style>
</head>

<body>

    <table style="width: 100%;" class="font-12">
        <tr>
            <td>
                <b>IFIXIED | <?= $row->nm_cabang ?></b>
                <div><?= $row->lokasi ?></div>
                <div><?= $row->kontak ?></div>
            </td>
            <td style="text-align: right;">
                <b>NOTA DOWN PAYMENT</b>
                <div style="text-align: right;">NO. INVOICE : <b style="font-size: 10px;"><?= $row->kode ?></b></div>
                <div style="text-align: right;"><?= tgl_indo($row->tanggal, true) ?></div>
            </td>
        </tr>>
    </table>

    <hr style="margin-top: 2px;margin-bottom: 2px;">

    <br>
    <br>

    <table style="width: 100%;" class="font-12">
        <tbody>
            <tr>
                <td class="border">
                    <table>
                        <tr>
                            <td class="bold" style="width: 130px;">NAMA</td>
                            <td style="width: 150px;">: <?= $row->nama ?></td>
                        </tr>
                        <tr>
                            <td class="bold">ESTIMASI BIAYA</td>
                            <td>: <?= rupiah($row->estimasi_biaya) ?></td>
                        </tr>
                        <tr>
                            <td class="bold">TOTAL DP</td>
                            <td>: <?= rupiah($row->total) ?> (<?= $row->pembayaran  ?>)</td>
                        </tr>
                    </table>
                </td>
                <td class="border">
                    <table>
                        <tr>
                            <td class="bold">NO HP</td>
                            <td>: <?= $row->no_hp ?></td>
                        </tr>
                        <tr>
                            <td class="bold" style="width: 150px;">KETERANGAN</td>
                            <td>: <?= nl2br($row->keterangan) ?></td>
                        </tr>
                        <tr>
                            <td>
                                <b>
                                    <u>NOTE</u>
                                </b>
                            </td>
                            <td>: </td>
                        </tr>
                    </table>
                </td>
            </tr>
        </tbody>
    </table>

    <br>
    <br>

    <table style="width: 100%;">
        <tbody>
            <tr>
                <td style="text-align: center;width: 150px;" class="border">
                    <b>PELANGGAN</b>
                    <br>
                    <br>
                    <br>
                    <br>
                    <u>( <?= $row->nama ?> )</u>
                </td>
                <td style="text-align: center;width: 150px;" class="border">
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