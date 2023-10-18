<div class="alert alert-primary">
    <i class="fa fa-note"></i> Catatan
    <ul class="mb-0 fw-600">
        <li>Keterangan barang di isi sesuai barang yang mau di pesan</li>
        <li>Kode invoice DP di generate otomatis oleh aplikasi</li>
    </ul>
</div>

<form onsubmit="event.preventDefault();do_submit(this);">
    <div class="form-group">
        <label>Pembayaran</label>
        <select required name="pembayaran" class="form-control js_select2" data-placeholder="pilih jenis pembayaran">
            <option value="">Pilih jenis pembayaran</option>
            <?php foreach ($ref_jenis_pembayaran as $key) : ?>
                <option <?= $key->id == @$data->pembayaran ? 'selected' : '' ?> value="<?= $key->id ?>"><?= $key->nama ?> (potongan <?= $key->persen_potongan ?> %)</option>
            <?php endforeach; ?>
        </select>
    </div>

    <div class="row">
        <div class="col-md-4">
            <div class="form-group">
                <label>Pegawai Yang Bertugas</label>
                <select name="id_pegawai" required class="w-100 ph js_select2" data-placeholder="pilih pegawai">
                    <option value=""></option>
                    <?php foreach ($pegawai as $key) : ?>
                        <option <?= @$data->id_pegawai == $key->id ? 'selected' : '' ?> value="<?= $key->id ?>"><?= $key->nama ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                <label>Nama Pelanggan</label>
                <input type="text" required name="nama" placeholder="Masukkan isian" class="form-control" value="<?= @$data->nama ?>">
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                <label>Nomer HP (<small class="text-danger fw-600">diutamakan WA</small>)</label>
                <input type="int" required name="no_hp" placeholder="Masukkan isian" class="form-control" value="<?= @$data->no_hp ?>">
            </div>
        </div>
    </div>

    <div class="form-group">
        <label>Keterangan Barang</label>
        <textarea required name="keterangan" rows="5" placeholder="Tulis keterangan produk" class="form-control"><?= @$data->keterangan ?></textarea>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label>Estimasi Biaya</label>
                <input type="text" required name="estimasi_biaya" placeholder="Masukkan isian" class="form-control rupiah" value="<?= empty($data->estimasi_biaya) ? '' : rupiah($data->estimasi_biaya) ?>">
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label>Total DP</label>
                <input type="text" required name="total" placeholder="Masukkan isian" class="form-control rupiah" value="<?= empty($data->total) ? '' : rupiah($data->total) ?>">
            </div>
        </div>
    </div>

    <div class="form-group">
        <label>Tanggal</label>
        <input type="date" required name="tanggal" placeholder="Masukkan isian" class="form-control" value="<?= empty($data->tanggal) ? date('Y-m-d') : date('Y-m-d', strtotime($data->tanggal)) ?>">
    </div>

    <input type="hidden" name="id" value="<?= encode_id(@$data->id) ?>">
    <button type="submit" class="btn btn-block btn-rounded fw-600 btn-primary"><i class="fas fa-check"></i> KLIK DISINI UNTUK SIMPAN</button>
</form>

<script>
    $(document).ready(function() {
        $('.js_select2').select2({
            width: '100%'
        });
    });

    function do_submit(dt) {

        Swal.fire({
            title: 'Simpan Transaksi DP ?',
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: 'Ya',
            cancelButtonText: 'Batal',
            reverseButtons: true
        }).then((result) => {
            if (result.value) {

                $.ajax({
                    type: "POST",
                    url: "<?= base_url('cabang/kasir_dp/do_submit') ?>",
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
                                    window.open(res.link);
                                    $('#table_data').DataTable().ajax.reload();
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