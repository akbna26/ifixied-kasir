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
            Petugas <?= $transaksi->pegawai ?> <br>
            Pelanggan <?= !empty($transaksi->pelanggan) ? $transaksi->pelanggan : '-' ?> <br>
        </address>
    </div>
</div>

<div class="row">
    <div class="col-sm-6">
        <address>
            <strong class="text-underline">Tanggal Transaksi</strong><br>
            <span class="fw-600 text-primary"><?= tgl_indo($transaksi->created, true) ?></span>
        </address>
    </div>
    <div class="col-sm-6 text-sm-right">
        <address class="mt-2 mt-sm-0">
            <strong class="text-underline">Jenis Pembayaran</strong><br>

            <span class="badge badge-primary"><i class="bx bx-money mr-1"></i> <?= $transaksi->jenis_bayar ?></span> : <?= rupiah($transaksi->bayar) ?> <br>
            <?php if ($transaksi->is_split == 1) : ?>
                <span class="badge badge-primary"><i class="bx bx-money mr-1"></i> <?= $transaksi->jenis_bayar_2 ?></span> : <?= rupiah($transaksi->total_split) ?>
            <?php endif; ?>
            <?php if (!empty($transaksi->dp)) : ?>
                <span class="badge badge-success"><i class="bx bx-money mr-1"></i> DP</span> : <?= rupiah($transaksi->dp) ?>
            <?php endif; ?>
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
                <th>Produk</th>
                <th>Qty</th>
                <th>Modal</th>
                <th>Harga Satuan</th>
                <th class="text-right">Total</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($detail as $i => $dt) : ?>
                <tr>
                    <td><?= $i + 1 ?></td>
                    <td><?= $dt->barang ?></td>
                    <td><?= $dt->qty ?></td>
                    <td><?= rupiah($dt->harga_modal) ?></td>
                    <td><?= rupiah($dt->harga) ?></td>
                    <td class="text-right"><?= rupiah($dt->sub_total) ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
        <tfoot>
            <tr>
                <td colspan="4" class="text-right">Sub Total</td>
                <td class="text-right"><?= rupiah($transaksi->total) ?></td>
            </tr>
        </tfoot>
    </table>
</div>