<div class="invoice-title">
    <h4 class="float-right font-size-16"><?= $detail->no_invoice ?></h4>
    <div class="mb-3 fw-600">
        INVOICE
    </div>
</div>

<hr>

<div class="row">
    <div class="col-sm-6">
        <address>
            <strong class="text-underline">Cabang</strong><br>
            <?= $detail->nm_cabang ?><br>
            <span class="text-muted"><?= $detail->cabang_alamat ?></span><br>
        </address>
    </div>
    <div class="col-sm-6 text-sm-right">
        <address>
            <strong class="text-underline">Tanggal Transaksi</strong><br>
            <span class="fw-600 text-primary"><?= tgl_indo($detail->created, true) ?></span>
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
                <th class="fw-600">BARCODE</th>
                <th class="fw-600">NAMA BARANG</th>
                <th class="fw-600">QTY</th>
                <th class="fw-600">JENIS KLAIM</th>
                <th class="fw-600">ALASAN (Jika Retur Teknisi)</th>
                <th class="fw-600">HASIL VERIFIKASI</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td><?= $detail->barcode ?></td>
                <td><?= $detail->nm_barang ?></td>
                <td><?= $detail->qty ?></td>
                <td><?= $detail->nm_klaim ?></td>
                <td><?= $detail->alasan_refund ?></td>
                <?php
                if (empty($detail->status_retur)) $verifikasi = '<span class="fw-600 text-primary">Belum diverifikasi</span>';
                elseif ($detail->status_retur == 1) $verifikasi = '<span class="fw-600 text-danger">Kerugian</span>';
                elseif ($detail->status_retur == 2) $verifikasi = '<span class="fw-600 text-success">Disetujui</span>';
                ?>
                <td><?= $verifikasi ?></td>
            </tr>
        </tbody>
    </table>
</div>

<hr>

<?php if ($detail->status_retur == 1) : ?>
    <div class="row">
        <div class="col-md-4">
            <div class="form-group">
                <label>Alasan ditolak <small class="fw-600 text-danger">*opsional</small></label>
                <div class="form-control is-valid"><?= nl2br(@$detail->alasan_tolak) ?></div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                <label>Kerugian <small class="fw-600 text-danger">*</small></label>
                <div readonly class="form-control is-valid"><?= rupiah(@$detail->potong_profit) ?></div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                <label>Tanggal Verifikasi <small class="fw-600 text-danger">*</small></label>
                <div readonly class="form-control is-valid"><?= tgl_indo(@$detail->tanggal_konfirmasi) ?></div>
            </div>
        </div>
    </div>
<?php endif; ?>