<div class="alert alert-primary">
    Catatan
    <ul class="mb-0 fw-600">
        <li>Petugas yang melakukan teknisi dikonfirmasi oleh admin pusat</li>
        <li>Status diperbarui oleh admin pusat</li>
        <li>Silahkan isi data dengan benar agar dapat ditindak lanjut oleh admin pusat</li>
        <li>Jika kosong silahkan di isi - (strip)</li>
        <li>
            <div class="flash1">Semua nominal masih perkiraan</div>
        </li>
    </ul>
</div>
<form onsubmit="event.preventDefault();do_submit(this);">
    <div class="row">
        <div class="col-md-3">
            <div class="form-group">
                <label>Nama User</label>
                <input type="text" required name="pelanggan" autocomplete="off" placeholder="Masukkan isian" class="form-control" value="<?= @$data->pelanggan ?>">
            </div>
        </div>
        <div class="col-md-3">
            <div class="form-group">
                <label>No HP</label>
                <input type="number" required name="no_hp" autocomplete="off" placeholder="Masukkan isian" class="form-control" value="<?= @$data->no_hp ?>">
            </div>
        </div>
        <div class="col-md-3">
            <div class="form-group">
                <label>Tipe Unit</label>
                <input type="text" required name="tipe_unit" autocomplete="off" placeholder="Masukkan isian" class="form-control" value="<?= @$data->tipe_unit ?>">
            </div>
        </div>
        <div class="col-md-3">
            <div class="form-group">
                <label>Serial Number</label>
                <input type="text" required name="serial_number" autocomplete="off" placeholder="Masukkan isian" class="form-control" value="<?= @$data->serial_number ?>">
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-4">
            <div class="form-group">
                <label>Diagnosa</label>
                <textarea required name="diagnosa" rows="3" placeholder="Masukkan isian" class="form-control"><?= @$data->diagnosa ?></textarea>
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                <label>Kerusakan</label>
                <textarea required name="kerusakan" rows="3" placeholder="Masukkan isian" class="form-control"><?= @$data->kerusakan ?></textarea>
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                <label>Keterangan</label>
                <textarea required name="keterangan" rows="3" placeholder="Masukkan isian" class="form-control"><?= @$data->keterangan ?></textarea>
            </div>
        </div>
    </div>

    <div class="form-group">
        <label>Tanggal Masuk</label>
        <input type="date" required name="tgl_masuk" placeholder="Masukkan isian" class="form-control" value="<?= empty($data->tgl_masuk) ? date('Y-m-d') : date('Y-m-d', strtotime($data->tgl_masuk)) ?>">
    </div>

    <div class="row">
        <div class="col-md-4">
            <div class="form-group">
                <label>Estimasi Biaya</label>
                <input type="text" required name="estimasi_biaya" autocomplete="off" placeholder="Masukkan isian" class="form-control rupiah" value="<?= !empty($data->estimasi_biaya) ? rupiah($data->estimasi_biaya) : '' ?>">
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                <label>Harga PART/IC Nand</label>
                <input type="text" required name="harga_part" autocomplete="off" placeholder="Masukkan isian" class="form-control rupiah" value="<?= !empty($data->harga_part) ? rupiah($data->harga_part) : '' ?>">
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                <label>Modal</label>
                <input type="text" required name="modal" autocomplete="off" placeholder="Masukkan isian" class="form-control rupiah" value="<?= !empty($data->modal) ? rupiah($data->modal) : '' ?>">
            </div>
        </div>
    </div>

    <input type="hidden" name="id" value="<?= encode_id(@$data->id) ?>">
    <button type="submit" class="btn btn-block btn-rounded fw-600 btn-primary"><i class="fas fa-check"></i> KLIK DISINI UNTUK SIMPAN</button>
</form>

<script>
    function do_submit(dt) {

        Swal.fire({
            title: 'Simpan Servis Berat ?',
            text: 'dapat dibatalkan selama belum dikonfirmasi oleh admin pusat, pastikan ada sudah sesuai',
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: 'Ya',
            cancelButtonText: 'Batal',
            reverseButtons: true
        }).then((result) => {
            if (result.value) {

                $.ajax({
                    type: "POST",
                    url: "<?= base_url('cabang/servis_berat/do_submit') ?>",
                    data: new FormData(dt),
                    dataType: "JSON",
                    contentType: false,
                    processData: false,
                    beforeSend: function(res) {
                        Swal.fire({
                            title: 'Loading ...',
                            html: '<i style="font-size:25px;" class="fa fa-spinner fa-spin"></i>',
                            allowOutsideClick: false,
                            showConfirmButton: false,
                        });
                    },
                    error: function(res) {
                        Swal.close();
                    },
                    success: function(res) {
                        if (res.status == 'success') {
                            $('#modal_custom').modal('hide');
                            Swal.fire({
                                    icon: 'success',
                                    title: 'Data berhasil disimpan',
                                    showConfirmButton: true,
                                })
                                .then(() => {
                                    $('#table_data').DataTable().ajax.reload();
                                    get_total();
                                })
                        }
                    }
                });

            } else {
                return false;
            }
        })
    }
</script>