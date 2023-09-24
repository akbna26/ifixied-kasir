<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nota Part Kirim</title>
    <style>
        table {
            border-collapse: collapse;
            width: 100%;
        }

        table.data tr th,
        table.data tr td {
            border: 1px solid #34495e;
        }
    </style>
</head>

<body>
    <table>
        <tr>
            <td style="width: 60px;">
                <img src="<?= base_url('uploads/img/logo.png') ?>" alt="image" style="width: 50px;">
            </td>
            <td>
                <h3>NOTA PART KIRIM</h3>
                <div><?= $detail->nama ?>, <?= tgl_indo($detail->tanggal) ?></div>
            </td>
            <td style="text-align: right;font-size: 10px;vertical-align: bottom;">Admin yang bertugas : <?= $user->nama ?></td>
        </tr>
    </table>

    <div style="border-bottom: 3px double #000;"></div>
    <br>
    <br>

    <table class="data">
        <thead>
            <tr>
                <th>NO</th>
                <th>CABANG</th>
                <th>KATEGORI</th>
                <th>BARCODE</th>
                <th>BARANG</th>
                <th>QUANTITY</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($row as $i => $dt) : ?>
                <tr>
                    <td><?= $i + 1 ?></td>
                    <td><?= $dt->nm_cabang ?></td>
                    <td><?= $dt->kategori ?></td>
                    <td><?= $dt->barcode ?></td>
                    <td><?= $dt->barang ?></td>
                    <td><?= $dt->stock ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</body>

</html>