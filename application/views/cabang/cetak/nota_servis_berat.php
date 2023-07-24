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
            font-size: 8px !important;
            letter-spacing: 2 !important;
        }

        .border-bottom {
            border-bottom: 1px solid #34495e;
        }

        .font-9 {
            font-size: 9px;
        }
    </style>
</head>

<body>

    <table style="width: 100%;" class="font-9">
        <tr>
            <td>
                <b style="font-size: 10px;">IFIXIED | <?= $row->nm_cabang ?></b>
                <div><?= $row->lokasi ?></div>
                <div><?= $row->kontak ?></div>
            </td>
            <td style="text-align: right;">
                <b>NOTA SERVIS</b>
                <div style="text-align: right;">NO. INVOICE : <b style="font-size: 10px;"><?= $row->invoice ?></b></div>
                <div style="text-align: right;"><?= tgl_indo($row->created, true) ?></div>
            </td>
        </tr>>
    </table>

    <hr style="margin-top: 2px;margin-bottom: 2px;">

    <table style="width: 100%;" class="font-9">
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

    <table style="width: 100%;" class="list">
        <thead>
            <tr>
                <th style="width: 120px;">Unit</th>
                <th style="width: 120px;">Serial Number</th>
                <th>Kerusakan</th>
                <th>Tindakan</th>
                <th>Estimasi Biaya</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td><?= $row->tipe_unit ?></td>
                <td><?= $row->serial_number ?></td>
                <td><?= $row->kerusakan ?></td>
                <td><?= $row->nm_tindakan ?></td>
                <td><?= rupiah($row->estimasi_biaya) ?></td>
            </tr>
        </tbody>
    </table>

    <br>

    <table style="width: 100%;" class="font-9">
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
                <td style="text-align: right;" class="border-bottom"><?= rupiah($row->bayar) ?></td>
            </tr>
            <tr>
                <td colspan="1" style="text-align: right;">Split :</td>
                <td style="text-align: right;" class="border-bottom"><?= empty($row->bayar_split) ? 0 : rupiah($row->bayar_split) ?></td>
            </tr>
            <tr>
                <td colspan="1" style="text-align: right;">Kembalian :</td>
                <td style="text-align: right;" class="border-bottom"><?= (($row->bayar + $row->bayar_split) - $row->biaya) == 0 ? 0 : rupiah(($row->bayar + $row->bayar_split) - $row->biaya) ?></td>
            </tr>
    </table>

    <hr>

    <table>
        <tr>
            <td style="vertical-align: top;width: 60%;">
                <table cellspacing="0">
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
                <table cellspacing="0">
                    <tr>
                        <th>No.</th>
                        <th>Persyaratan Khusus & Masa Garansi</th>
                    </tr>
                    <tr>
                        <td>1.</td>
                        <td>Garansi IC/Mesin (Berlaku 1 Bulan) : Garansi service mesin hanya berlaku sesuai dengan kendala awal kerusakan dan berada pada jalur ic yang sama.</td>
                    </tr>
                    <tr>
                        <td>2.</td>
                        <td>Garansi LCD (Berlaku 1 Tahun) : Garansi LCD/Touchscreen berlaku jika kondisi fisik LCD seperti baru, hanya pada kendala LCD blank hitam, touchscreen error, dan white spot (factor pemasangan). Garansi LCD tidak berlaku apabila terjadi kerusakan pada fisik (LCD baret atau gores, retak, pecah luar, pecah dalam, Flexible Robek, Korosi). Garansi LCD tidak berlaku apabila tampilan LCD bergaris atau black spot.</td>
                    </tr>
                    <tr>
                        <td>3.</td>
                        <td>Garansi Battery (Berlaku 1 Tahun) : Garansi battery tidak berlaku apabila terjadi indikasi over charging, battery menggelembung, Flexible tidak robek, tidak terbakar/korsleting.</td>
                    </tr>
                    <tr>
                        <td>4.</td>
                        <td>Garansi Kamera, Home Button, Connector, Volume (Berlaku 3 bulan) : Garansi kamera tidak berlaku apabila kamera berjamur, Flexible Robek. Home button, Connector, Volume tidak berlaku apabila flexible robek, tidak terbakar/korsleting.</td>
                    </tr>
                    <tr>
                        <td>5.</td>
                        <td>Garansi Aksesoris : Aksesoris berlaku selama 1 minggu, aksesoris tidak terkena air, tidak terjatuh, fisik seperti pertama beli (Garansi MagSafe 1 Bulan).</td>
                    </tr>
                    <tr>
                        <td>6.</td>
                        <td>Barang yang tidak diambil selama 1 bulan, hilang/rusak bukan tanggung jawab dari iFixied.</td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>

</body>

</html>