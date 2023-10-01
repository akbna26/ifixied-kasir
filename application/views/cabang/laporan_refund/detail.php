<div class="invoice-title">
    <h4 class="float-right font-size-16"><?= $transaksi->no_invoice ?></h4>
    <div class="mb-3 fw-600">
        INVOICE
    </div>
</div>

<hr>

<div class="row">
    <div class="col-sm-6">
        <address>
            <strong class="text-underline">Cabang</strong><br>
            <?= $transaksi->cabang ?><br>
            <span class="text-muted"><?= $transaksi->cabang_alamat ?></span><br>
        </address>
    </div>
    <div class="col-sm-6 text-sm-right">
        <address class="mt-2 mt-sm-0">
            <strong class="text-underline">Informasi</strong><br>
            Pelanggan <?= !empty($transaksi->pelanggan) ? $transaksi->pelanggan : '-' ?> <br>
        </address>
        <address>
            <strong class="text-underline">Tanggal Transaksi</strong><br>
            <span class="fw-600 text-primary"><?= tgl_indo($transaksi->created, true) ?></span>
        </address>
    </div>
</div>

<div class="my-3">
    <h3 class="font-size-15 font-weight-bold">Rincian Transaksi</h3>
</div>

<div class="table-responsive">
    <table class="table table-nowrap table-sm">
        <thead>
            <tr>
                <th style="width: 70px;">No.</th>
                <th class="fw-600">NAMA BARANG</th>
                <th class="fw-600">HARGA JUAL</th>
                <th class="fw-600">QTY</th>
                <th class="fw-600">STATUS KLAIM</th>
                <th class="fw-600">NILAI REFUND</th>
                <th class="fw-600">BARANG PENGGANTI</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($detail as $i => $dt) : ?>
                <tr>
                    <td><?= $i + 1 ?></td>
                    <td><?= $dt->barang ?></td>
                    <td><?= rupiah($dt->harga_jual) ?></td>
                    <td><?= $dt->qty ?></td>
                    <td><?= $dt->nm_klaim ?></td>
                    <td><?= in_array($dt->id_klaim, [3, 4]) ? rupiah($dt->nilai_refund) : '-' ?> <?= in_array($dt->id_klaim, [3, 4]) ? '<span class="badge badge-primary ml-1 fw-600">' . ($dt->nm_pembayaran) . '</span>' : '' ?></td>
                    <td><?= $dt->nm_pengganti ?? '-' ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>