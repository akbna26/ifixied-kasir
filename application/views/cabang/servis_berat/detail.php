<a href="<?= base_url('cabang/cetak/nota_servis_berat/') . encode_id($row->id) ?>" target="_blank" class="btn btn-success btn-lg float-right fw-600"><i class="fa fa-print mr-1"></i> PRINT NOTA</a>
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