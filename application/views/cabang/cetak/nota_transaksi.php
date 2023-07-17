<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nota Transaksi</title>
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

        table.list tr th,
        table.list tr td {
            text-align: center;
        }

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
                <h3>FAKTUR PENJUALAN</h3>
            </td>
            <td style="text-align: right;">Waktu : <?= tgl_indo($row->created, true) ?></td>
        </tr>
    </table>
    <hr>

    <table style="width: 100%;">
        <tr>
            <td style="width: 130px;">NO. INVOICE</td>
            <td style="width: 150px;">: <?= $row->no_invoice ?></td>
            <td style="width: 100px;"></td>
            <td style="width: 150px;">KETERANGAN</td>
            <td>: <?= nl2br($row->keterangan) ?></td>
        </tr>
        <tr>
            <td>NAMA</td>
            <td>: <?= $row->pelanggan ?></td>
            <td></td>
            <td>
                <b>
                    <u>NOTE</u>
                </b>
            </td>
            <td>: </td>
        </tr>
        <tr>
            <td>TELP.</td>
            <td>: <?= $row->no_hp ?? '-' ?></td>
            <td></td>
            <td></td>
            <td></td>
        </tr>
    </table>

    <table style="width: 100%;" class="list">
        <thead>
            <tr>
                <th>Barcode</th>
                <th style="width: 200px;">Produk</th>
                <th>Qty/@Harga</th>
                <th>Deskripsi</th>
                <th>Subtotal</th>
            </tr>
        </thead>
        <?php foreach ($detail as $dt) : ?>
            <tbody>
                <tr>
                    <td><?= $dt->barcode ?></td>
                    <td><?= $dt->nm_barang ?></td>
                    <td><?= $dt->qty ?> @<?= rupiah($dt->harga) ?></td>
                    <td><?= $dt->keterangan ?? '-' ?></td>
                    <td style="text-align: right;"><?= rupiah($dt->sub_total) ?></td>
                </tr>
            </tbody>
        <?php endforeach; ?>
        <tfoot>
            <tr>
                <td colspan="5">
                    <br>
                </td>
            </tr>
            <tr>
                <td colspan="3"></td>
                <td class="border" style="text-align: right;">Total :</td>
                <td class="border" style="text-align: right;"><?= rupiah($row->total) ?></td>
            </tr>
            <tr>
                <td colspan="3"></td>
                <td class="border" style="text-align: right;">Payment :</td>
                <td class="border" style="text-align: right;"><?= $row->nm_pembayaran ?></td>
            </tr>
            <tr>
                <td colspan="3"></td>
                <td class="border" style="text-align: right;">Bayar :</td>
                <td class="border" style="text-align: right;"><?= rupiah($row->bayar) ?></td>
            </tr>
            <tr>
                <td colspan="3"></td>
                <td class="border" style="text-align: right;">Split :</td>
                <td class="border" style="text-align: right;"><?= $row->is_split == 1 ? rupiah($row->total_split) : 0 ?></td>
            </tr>
            <tr>
                <td colspan="3"></td>
                <td class="border" style="text-align: right;">DP :</td>
                <td class="border" style="text-align: right;"><?= rupiah($row->dp) ?></td>
            </tr>
            <tr>
                <td colspan="3"></td>
                <td class="border" style="text-align: right;">Kembalian :</td>
                <td class="border" style="text-align: right;"><?= rupiah($row->kembalian) ?></td>
            </tr>
        </tfoot>
    </table>

    <br>
    <br>

    <table style="width: 100%;">
        <tr>
            <td style="width: 25%;"></td>
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
            <td style="width: 25%;"></td>
        </tr>
    </table>

    <br>
    <br>

    <table>
        <tr>
            <td style="vertical-align: top;">
                <table cellspacing="0" class="info">
                    <tr>
                        <th>No.</th>
                        <th>Ketentuan Garansi</th>
                    </tr>
                    <tr>
                        <td>1.</td>
                        <td>Klaim garansi wajib menyertakan bukti pembayaran berupa nota transaksi perbaikan.</td>
                    </tr>
                    <tr>
                        <td>2.</td>
                        <td>Pelanggan yang tidak dapat menunjukkan struk atau nota fisik maka dapat menunjukkannya melalui bentuk foto.</td>
                    </tr>
                    <tr>
                        <td>3.</td>
                        <td>Pelanggan yang kehilangan nota dan tidak memiliki bukti foto akan tetap dilayani proses klaimnya selama nota perbaikan dapat dilakukan tracking untuk dicetak kembali.</td>
                    </tr>
                    <tr>
                        <td>4.</td>
                        <td>Nota pelanggan yang tidak dapat dilakukan tracking maka tidak dapat dilayani proses klaim garansinya.</td>
                    </tr>
                    <tr>
                        <td>5.</td>
                        <td>Pelanggan yang mengalami kendala pada perangkatnya dapat mengonfirmasi terlebih dahulu keluhannya ke nomor Whatsapp yang tertera pada nota jika tidak dapat datang ke store di waktu tersebut.</td>
                    </tr>
                    <tr>
                        <td>6.</td>
                        <td>Garansi berlaku di seluruh cabang iFixied dan terhitung sejak tanggal pengambilan perangkat.</td>
                    </tr>
                    <tr>
                        <td>7.</td>
                        <td>Garansi tidak berlaku pada item diluar perbaikan dari nota transaksi.</td>
                    </tr>
                    <tr>
                        <td>8.</td>
                        <td>Pelanggan diperkenankan melakukan klaim garansi maksimal sebanyak 3 kali selama masa periode garansi.</td>
                    </tr>
                    <tr>
                        <td>9.</td>
                        <td>Garansi tidak berlaku apabila terjadi indikasi human error (kelalaian penggunaan) seperti terjatuh, terhempas, tertekan, kena air, dan over charging.</td>
                    </tr>
                    <tr>
                        <td>10.</td>
                        <td>Garansi tidak berlaku jika segel service rusak.</td>
                    </tr>
                    <tr>
                        <td>11.</td>
                        <td>Segala kerusakan fungsional (LCD, speaker, keyboard, dll) yang ditemukan dan data yang hilang setelah selesai perbaikan untuk unit yang masuk dalam keadaan NO CHECK (Mati total, blank, no touch, stuck logo, disable) adalah diluar tanggung jawab iFixied.</td>
                    </tr>
                    <tr>
                        <td>12.</td>
                        <td>Garansi hanya berlaku untuk barang yang diperbaiki atau diservice. Jika ada kerusakan selain hal yang diperbaiki, bukan tanggung jawab iFixied.</td>
                    </tr>
                </table>
            </td>
            <td style="vertical-align: top;">
                <table cellspacing="0" class="info">
                    <tr>
                        <th>No.</th>
                        <th>Persyaratan Khusus</th>
                        <th>Masa Garansi</th>
                    </tr>
                    <tr>
                        <td>1.</td>
                        <td>Garansi IC/Mesin (Berlaku 1 Bulan)</td>
                        <td>Garansi service mesin hanya berlaku sesuai dengan kendala awal kerusakan dan berada pada jalur ic yang sama.</td>
                    </tr>
                    <tr>
                        <td>2.</td>
                        <td>Garansi LCD (Berlaku 1 Tahun)</td>
                        <td>
                            <ul>
                                <li>Garansi LCD/Touchscreen berlaku jika kondisi fisik LCD seperti baru, hanya pada kendala LCD blank hitam, touchscreen error, dan white spot (factor pemasangan).</li>
                                <li>Garansi LCD tidak berlaku apabila terjadi kerusakan pada fisik (LCD baret atau gores, retak, pecah luar, pecah dalam, Flexible Robek, Korosi).</li>
                                <li>Garansi LCD tidak berlaku apabila tampilan LCD bergaris atau black spot.</li>
                            </ul>
                        </td>
                    </tr>
                    <tr>
                        <td>3.</td>
                        <td>Garansi Battery (Berlaku 1 Tahun)</td>
                        <td>
                            <ul>
                                <li>Garansi battery tidak berlaku apabila terjadi indikasi over charging, battery menggelembung, Flexible tidak robek, tidak terbakar/korsleting.</li>
                            </ul>
                        </td>
                    </tr>
                    <tr>
                        <td>4.</td>
                        <td>Garansi Kamera, Home Button, Connector, Volume (Berlaku 3 bulan)</td>
                        <td>
                            <ul>
                                <li>Garansi kamera tidak berlaku apabila kamera berjamur, Flexible Robek.</li>
                                <li>Home button, Connector, Volume tidak berlaku apabila flexible robek, tidak terbakar/korsleting.</li>
                            </ul>
                        </td>
                    </tr>
                    <tr>
                        <td>5.</td>
                        <td>Garansi Aksesoris</td>
                        <td>Aksesoris berlaku selama 1 minggu, aksesoris tidak terkena air, tidak terjatuh, fisik seperti pertama beli (Garansi MagSafe 1 Bulan).</td>
                    </tr>
                    <tr>
                        <td>6.</td>
                        <td>Barang yang tidak diambil selama 1 bulan, hilang/rusak bukan tanggung jawab dari iFixied.</td>
                        <td>N/A</td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>

</html>