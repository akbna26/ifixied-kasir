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
                    <th colspan="3" class="text-right">Total</th>
                    <th><?= $total == 0 ? 0 : rupiah($total) ?></th>
                </tr>
            </tfoot>
        </table>
    </div>
<?php endforeach; ?>

<h3>ASSET BERGERAK</h3>
<table class="table table-bordered">
    <thead style="background-color: #2143EB;" class="text-white">
        <tr>
            <th>NAMA/JENIS</th>
            <th>NOMINAL</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>SPAREPART</td>
            <td>
                <input disabled ondblclick="remove_disable(this);" onblur="add_disabled(this)" type="text" class="form-control rupiah" placeholder="sekali saja">
            </td>
        </tr>
        <tr>
            <td>ACCESSIORIES</td>
            <td>
                <input disabled ondblclick="remove_disable(this);" onblur="add_disabled(this)" type="text" class="form-control rupiah" placeholder="sekali saja">
            </td>
        </tr>
        <tr>
            <td>HANDPHONE</td>
            <td>
                <input disabled ondblclick="remove_disable(this);" onblur="add_disabled(this)" type="text" class="form-control rupiah" placeholder="sekali saja">
            </td>
        </tr>
    </tbody>
    <tfoot>
        <tr>
            <th class="text-right">Total</th>
            <th>0</th>
        </tr>
    </tfoot>
</table>

<h3>TOTAL MODAL</h3>
<table class="table table-bordered">
    <tbody>
        <tr>
            <th style="background-color: #2143EB;width: 250px;" class="text-white">ASSET BERGERAK</th>
            <tH>0</tH>
        </tr>
        <tr>
            <th style="background-color: #2143EB;" class="text-white">ASSET TIDAK BERGERAK</th>
            <tH>0</tH>
        </tr>
        <tr>
            <th style="background-color: #2143EB;" class="text-white">TOTAL KESELURUHAN</th>
            <tH>0</tH>
        </tr>
    </tbody>
</table>