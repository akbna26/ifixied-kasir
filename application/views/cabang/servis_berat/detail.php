<a href="<?= base_url(session('type') . '/cetak/nota_servis_berat/') . encode_id($row->id) ?>" target="_blank" class="btn btn-success btn-lg float-right fw-600"><i class="fa fa-print mr-1"></i> PRINT NOTA</a>
<div style="clear: both;"></div>

<div class="row mt-2">
    <div class="col-md-4">
        <div class="alert alert-primary fw-600">
            <h5>Invoice</h5>
            <div><?= @$row->invoice ?></div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="alert alert-primary fw-600">
            <h5>Tanggal Masuk</h5>
            <div><?= !empty($row->tgl_masuk) ? tgl_indo($row->tgl_masuk)  : '-' ?></div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="alert alert-primary fw-600">
            <h5>Tanggal Keluar</h5>
            <div><?= !empty($row->tgl_keluar) ? tgl_indo($row->tgl_keluar)  : '-' ?></div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-6">
        <table class="table table-bordered">
            <tr>
                <th style="width: 200px;">Nama User</th>
                <td><?= @$row->pelanggan ?></th>
            </tr>
            <tr>
                <th>No HP</th>
                <td><?= @$row->no_hp ?></td>
            </tr>
            <tr>
                <th>Tipe Unit</th>
                <td><?= @$row->tipe_unit ?></td>
            </tr>
            <tr>
                <th>Serial Number</th>
                <td><?= @$row->serial_number ?></td>
            </tr>
            <tr>
                <th>Diagnosa</th>
                <td><?= @$row->diagnosa ?></td>
            </tr>
            <tr>
                <th>Kerusakan</th>
                <td><?= @$row->kerusakan ?></td>
            </tr>
            <tr>
                <th>Keterangan</th>
                <td><?= @$row->keterangan ?></td>
            </tr>
        </table>
    </div>
    <div class="col-md-6">
        <table class="table table-bordered">
            <tr>
                <th style="width: 200px;">Status Servis</th>
                <td><?= @$row->nm_status ?></th>
            </tr>
            <tr>
                <th>Posisi Barang</th>
                <td><?= @$row->nm_pengambilan ?></th>
            </tr>
            <tr>
                <th>Estimasi Biaya</th>
                <td><?= rupiah(@$row->estimasi_biaya) ?></th>
            </tr>
            <tr>
                <th>Total Biaya</th>
                <td><?= empty($row->biaya) ? '-' : rupiah($row->biaya) ?></th>
            </tr>
            <?php if (session('type') == 'admin') : ?>
                <tr>
                    <th>Teknisi</th>
                    <td><?= @$row->nm_teknisi ?></td>
                </tr>
                <tr>
                    <th>Harga PART/IC Nand</th>
                    <td><?= rupiah(@$row->harga_part) ?></td>
                </tr>
                <tr>
                    <th>Modal</th>
                    <td><?= rupiah(@$row->modal) ?></td>
                </tr>
            <?php endif; ?>
            <tr>
                <th>Tindakan</th>
                <td><?= @$row->nm_tindakan ?></td>
            </tr>
            <?php if ($row->id_pengambilan == 4) : ?>
                <tr>
                    <th>Total Bayar</th>
                    <td><?= rupiah($row->bayar) ?> ( <span class="text-primary"><?= $row->nm_pembayaran_1 ?></span> )</td>
                </tr>
                <tr>
                    <th>Total Bayar Split</th>
                    <td><?= rupiah($row->bayar_split) ?> ( <span class="text-primary"><?= $row->nm_pembayaran_2 ?></span> )</td>
                </tr>
            <?php endif; ?>
        </table>
    </div>
</div>

<h4>Informasi Tambahan</h4>
<div class="table-responsive">
    <table class="table table-bordered">
        <tr>
            <th style="width: 150px;">Password Layar</th>
            <td>
                <?= $row->pass_layar ?>
            </td>
        </tr>
        <tr>
            <th>iCloud</th>
            <td>
                <?= $row->email ?>
            </td>
        </tr>
        <tr>
            <th>Warna</th>
            <td>
                <?= $row->warna ?>
            </td>
        </tr>
        <tr>
            <th>Kapasitas Memory (GB)</th>
            <td>
                <?= $row->kapasitas_memori ?>
            </td>
        </tr>
    </table>
</div>

<?php if (session('type') == 'servis') : ?>
    <h4>Part yang Digunakan</h4>
    <div class="table-responsive">
        <table class="table table-bordered striped table-sm mb-0">
            <thead class="bg-primary text-white text-center">
                <tr>
                    <th>BARCODE</th>
                    <th>NAMA PART</th>
                    <th>HARGA MODAL</th>
                    <th>QTY</th>
                    <th>SUB TOTAL</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $total = 0;
                foreach ($part as $dt) : ?>
                    <tr>
                        <td><?= $dt->barcode ?></td>
                        <td class="text-center"><?= $dt->nama ?></td>
                        <td class="text-center"><?= rupiah($dt->harga_modal) ?></td>
                        <td class="text-center"><?= $dt->qty ?></td>
                        <td class="text-center"><?= rupiah($dt->total) ?></td>
                    </tr>

                <?php
                    $total += $dt->total;
                endforeach; ?>
            </tbody>
            <tfoot>
                <tr class="bg-primary text-white">
                    <td colspan="4" class="text-right">Total</td>
                    <td class="text-center"><?= rupiah($total) ?></td>
                </tr>
            </tfoot>
        </table>
    </div>
<?php endif; ?>