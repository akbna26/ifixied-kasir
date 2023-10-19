<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nota Delivery Order</title>
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
                <h3>IFIXIED GLOBAL INDONESIA</h3>
                <div style="font-size: 10px;">Jl. Asem Gede No.33, Sanggrahan, Condongcatur, Kec. Depok, Kabupaten Sleman, Daerah Istimewa Yogyakarta 55281</div>
            </td>
            <td style="text-align: right;vertical-align: bottom;">
                <!-- <h3>DELIVERY ORDER</h3>
                <div style="text-align: right;"><?= tgl_indo($detail->tanggal) ?></div>
                <div style="font-size: 10px;">Admin yang bertugas : <?= $user->nama ?></div> -->
            </td>
        </tr>
    </table>

    <div style="border-bottom: 3px double #000;"></div>
    <div style="text-align: right;">
        <h3 style="margin-bottom: 0;">DELIVERY ORDER</h3>
        <div style="text-align: right;font-size: 11px;"><?= tgl_indo($detail->tanggal) ?></div>
        <div style="font-size: 10px;">Admin yang bertugas : <?= $user->nama ?></div>
    </div>
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

    <br>
    <br>
    <br>
    <br>
    <br>

    <table style="text-align: center;">
        <tr>
            <td>
                <b>PENANGGUNG JAWAB 1</b>
                <br>
                <br>
                <br>
                <br>
                <br>
                (...................................)
            </td>
            <td>
                <b>PENANGGUNG JAWAB 2</b>
                <br>
                <br>
                <br>
                <br>
                <br>
                (...................................)
            </td>
            <td>
                <b>PENERIMA</b>
                <br>
                <br>
                <br>
                <br>
                <br>
                (...................................)
            </td>
        </tr>
    </table>
</body>

</html>