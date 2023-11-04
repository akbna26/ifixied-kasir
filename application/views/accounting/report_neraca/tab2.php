<style>
    .bg_hijau {
        background-color: #2CD988;
    }

    .bg_hijau>td:nth-child(1) {
        font-weight: 600;
    }

    .bg_kuning {
        background-color: #F2E30A;
    }

    .my_tooltip {
        cursor: pointer;
    }

    .kredit,
    .debit {
        width: 200px;
    }
</style>

<table class="table table-bordered">
    <thead style="background-color: #2143EB;" class="text-white">
        <tr>
            <th></th>
            <th class="kredit">KREDIT</th>
            <th class="debit">DEBIT</th>
        </tr>
    </thead>
    <tbody>
        <tr class="bg_hijau">
            <td>MODAL AWAL</td>
            <td>0</td>
            <td>1.000.000</td>
        </tr>
        <tr class="bg_hijau">
            <td>ASET TIDAK BERGERAK</td>
            <td>2.000.000</td>
            <td>0</td>
        </tr>
    </tbody>
</table>

<div class="d-flex justify-content-between mt-4">
    <h4 class="mb-0">DANA</h4>
    <button class="btn btn-sm btn-primary"><i class="fa fa-plus"></i> Tambah Data</button>
</div>

<table class="table table-bordered">
    <thead class="text-white" style="background-color: #2143EB;">
        <tr>
            <th></th>
            <th class="kredit">KREDIT</th>
            <th class="debit">DEBIT</th>
        </tr>
    </thead>
    <tbody>
        <tr class="bg_kuning">
            <td>Dana Bentuk Cash</td>
            <td>1.500.000</td>
            <td>0</td>
        </tr>
        <tr class="bg_kuning">
            <td>Dana Di Rekening</td>
            <td>3.500.000</td>
            <td>0</td>
        </tr>
        <tr class="bg-soft-danger">
            <td>Dana Lain
                <span class="ml-3">
                    <i data-toggle="tooltip" data-placement="top" title="edit data" class="fa fa-edit text-primary my_tooltip"></i>
                    <i data-toggle="tooltip" data-placement="top" title="hapus data" class="fa fa-times text-danger ml-1 my_tooltip"></i>
                </span>
            </td>
            <td>800.000</td>
            <td>0</td>
        </tr>
    </tbody>
</table>

<div class="d-flex justify-content-between mt-4">
    <h4 class="mb-0">STOCK</h4>
    <button class="btn btn-sm btn-primary"><i class="fa fa-plus"></i> Tambah Data</button>
</div>

<table class="table table-bordered">
    <thead class="text-white" style="background-color: #2143EB;">
        <tr>
            <th></th>
            <th class="kredit">KREDIT</th>
            <th class="debit">DEBIT</th>
        </tr>
    </thead>
    <tbody>
        <tr class="bg_kuning">
            <td>Sparepart</td>
            <td>1.500.000</td>
            <td>0</td>
        </tr>
        <tr class="bg_kuning">
            <td>Accessories</td>
            <td>3.500.000</td>
            <td>0</td>
        </tr>
        <tr class="bg_kuning">
            <td>Retur</td>
            <td>0</td>
            <td>0</td>
        </tr>
    </tbody>
</table>

<div class="d-flex justify-content-between mt-4">
    <h4 class="mb-0">ORDER STOCK ONLINE/OFFLINE</h4>
    <button class="btn btn-sm btn-primary"><i class="fa fa-plus"></i> Tambah Data</button>
</div>

<table class="table table-bordered">
    <thead class="text-white" style="background-color: #2143EB;">
        <tr>
            <th></th>
            <th class="kredit">KREDIT</th>
            <th class="debit">DEBIT</th>
        </tr>
    </thead>
    <tbody>
        <tr class="bg-soft-danger">
            <td>Order LCD Tokopedia
                <span class="ml-3">
                    <i data-toggle="tooltip" data-placement="top" title="edit data" class="fa fa-edit text-primary my_tooltip"></i>
                    <i data-toggle="tooltip" data-placement="top" title="hapus data" class="fa fa-times text-danger ml-1 my_tooltip"></i>
                </span>
            </td>
            <td>800.000</td>
            <td>0</td>
        </tr>
    </tbody>
</table>

<div class="d-flex justify-content-between mt-4">
    <h4 class="mb-0">KASBON KARYAWAN</h4>
    <button class="btn btn-sm btn-primary"><i class="fa fa-plus"></i> Tambah Data</button>
</div>

<table class="table table-bordered">
    <thead class="text-white" style="background-color: #2143EB;">
        <tr>
            <th></th>
            <th class="kredit">KREDIT</th>
            <th class="debit">DEBIT</th>
        </tr>
    </thead>
    <tbody>
        <tr class="bg_kuning">
            <td>Akbar</td>
            <td>1.000.000</td>
            <td>0</td>
        </tr>
        <tr class="bg_kuning">
            <td>Adnan</td>
            <td>2.000.000</td>
            <td>0</td>
        </tr>
        <tr class="bg_kuning">
            <td>Zainal</td>
            <td>1.500.00</td>
            <td>0</td>
        </tr>
        <tr class="bg-soft-danger">
            <td>Mas Rendra
                <span class="ml-3">
                    <i data-toggle="tooltip" data-placement="top" title="edit data" class="fa fa-edit text-primary my_tooltip"></i>
                    <i data-toggle="tooltip" data-placement="top" title="hapus data" class="fa fa-times text-danger ml-1 my_tooltip"></i>
                </span>
            </td>
            <td>1.700.000</td>
            <td>0</td>
        </tr>
        <tr class="bg-soft-danger">
            <td>Mas Suyun
                <span class="ml-3">
                    <i data-toggle="tooltip" data-placement="top" title="edit data" class="fa fa-edit text-primary my_tooltip"></i>
                    <i data-toggle="tooltip" data-placement="top" title="hapus data" class="fa fa-times text-danger ml-1 my_tooltip"></i>
                </span>
            </td>
            <td>3.000.000</td>
            <td>0</td>
        </tr>
        <tr class="bg-soft-danger">
            <td>Mas Ncis
                <span class="ml-3">
                    <i data-toggle="tooltip" data-placement="top" title="edit data" class="fa fa-edit text-primary my_tooltip"></i>
                    <i data-toggle="tooltip" data-placement="top" title="hapus data" class="fa fa-times text-danger ml-1 my_tooltip"></i>
                </span>
            </td>
            <td>2.000.000</td>
            <td>0</td>
        </tr>
    </tbody>
</table>

<div class="d-flex justify-content-between mt-4">
    <h4 class="mb-0">SIRKULASI PROFIT, OPERASIONAL, PIUTANG DAN UTANG HARIAN (TIAP CABANG)</h4>
    <button class="btn btn-sm btn-primary"><i class="fa fa-plus"></i> Tambah Data</button>
</div>

<table class="table table-bordered">
    <thead class="text-white" style="background-color: #2143EB;">
        <tr>
            <th></th>
            <th class="kredit">KREDIT</th>
            <th class="debit">DEBIT</th>
        </tr>
    </thead>
    <tbody>
        <tr class="bg_kuning">
            <td>PROFIT</td>
            <td>0</td>
            <td>1.000.000</td>
        </tr>
        <tr class="bg_kuning">
            <td>OPERASIONAL</td>
            <td>2.000.000</td>
            <td>0</td>
        </tr>
        <tr class="bg_kuning">
            <td>PIUTANG
            </td>
            <td>1.700.000</td>
            <td>0</td>
        </tr>
        <tr class="bg_kuning">
            <td>HUTANG
            </td>
            <td>3.000.000</td>
            <td>0</td>
        </tr>
    </tbody>
</table>

<div class="d-flex justify-content-between mt-4">
    <h4 class="mb-0">PIUTANG CABANG</h4>
</div>

<table class="table table-bordered">
    <thead class="text-white" style="background-color: #2143EB;">
        <tr>
            <th></th>
            <th class="kredit">KREDIT</th>
            <th class="debit">DEBIT</th>
        </tr>
    </thead>
    <tbody>
        <tr class="bg_kuning">
            <td>DATA KERUGIAN</td>
            <td>1.000.000</td>
            <td>0</td>
        </tr>
        <tr class="bg_kuning">
            <td>IKLAN</td>
            <td>2.000.000</td>
            <td>0</td>
        </tr>
        <tr class="bg_kuning">
            <td>MARGIN ERROR</td>
            <td>0</td>
            <td>
                <input type="text" class="form-control rupiah" placeholder="margin error ....">
            </td>
        </tr>
    </tbody>
</table>

<div class="d-flex justify-content-between mt-4">
    <h4 class="mb-0">LAIN LAIN</h4>
    <button class="btn btn-sm btn-primary"><i class="fa fa-plus"></i> Tambah Data</button>
</div>

<table class="table table-bordered">
    <thead class="text-white" style="background-color: #2143EB;">
        <tr>
            <th></th>
            <th class="kredit">KREDIT</th>
            <th class="debit">DEBIT</th>
        </tr>
    </thead>
    <tbody>      
        <tr class="bg-soft-danger">
            <td>PROFIT SO
                <span class="ml-3">
                    <i data-toggle="tooltip" data-placement="top" title="edit data" class="fa fa-edit text-primary my_tooltip"></i>
                    <i data-toggle="tooltip" data-placement="top" title="hapus data" class="fa fa-times text-danger ml-1 my_tooltip"></i>
                </span>
            </td>
            <td>1.700.000</td>
            <td>0</td>
        </tr>
    </tbody>
</table>