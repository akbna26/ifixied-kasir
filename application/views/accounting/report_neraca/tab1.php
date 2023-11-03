<h3>ASSET TIDAK BERGERAK</h3>
<?php foreach ($modal_neraca as $key => $dt) : ?>
    <h4 class="rounded p-1 text-center text-white" style="background-color: #2143EB;"><?= $key ?></h4>
    <div class="table-responsive">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>NAMA/JENIS</th>
                    <th>JUMLAH</th>
                    <th>HARGA</th>
                    <th>TOTAL</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $total = 0;
                foreach ($dt as $item) : ?>
                    <tr>
                        <td><?= $item->nama ?></td>
                        <td><?= $item->jumlah ?></td>
                        <td><?= rupiah($item->harga) ?></td>
                        <td><?= rupiah($item->total) ?></td>
                    </tr>
                <?php
                    $total += $item->total;
                endforeach; ?>
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="3" class="text-right">Total</td>
                    <td><?= rupiah($total) ?></td>
                </tr>
            </tfoot>
        </table>
    </div>
<?php endforeach; ?>