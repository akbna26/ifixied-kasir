<form onsubmit="event.preventDefault();do_submit(this);">

    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label>Cabang</label>
                <select required name="id_cabang" class="form-control js_select2" data-placeholder="pilih cabang">
                    <option value=""></option>
                    <?php foreach ($ref_cabang as $dt) : ?>
                        <option <?= $dt->id == @$data->id_cabang ? 'selected' : '' ?> value="<?= $dt->id ?>"><?= $dt->nama ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label>Pengeluaran</label>
                <select required name="id_jenis" class="form-control js_select2" data-placeholder="pilih pengeluaran">
                    <option value=""></option>
                    <?php foreach ($ref_jenis_modal as $dt) : ?>
                        <option <?= $dt->id == @$data->id_jenis ? 'selected' : '' ?> value="<?= $dt->id ?>"><?= $dt->nama ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
        </div>
    </div>

    <div class="form-group">
        <label>Tanggal</label>
        <input type="date" required name="tanggal" placeholder="Masukkan isian" class="form-control" value="<?= empty($data->tanggal) ? date('Y-m-d') : date('Y-m-d', strtotime($data->tanggal)) ?>">
    </div>

    <div class="form-group">
        <label>Jenis</label>
        <input type="text" required name="nama" autocomplete="off" placeholder="Masukkan isian" class="form-control" value="<?= @$data->nama ?>">
    </div>

    <div class="form-group">
        <label>Harga Satuan</label>
        <input type="text" required onchange="hitung_total();" name="harga" id="harga_satuan" autocomplete="off" placeholder="Masukkan isian" class="form-control rupiah" value="<?= empty($data->harga) ? '' : rupiah($data->harga) ?>">
    </div>

    <div class="form-group">
        <label>Jumlah</label>
        <input type="text" required onchange="hitung_total();" name="jumlah" id="jumlah" autocomplete="off" placeholder="Masukkan isian" class="form-control rupiah" value="<?= empty($data->jumlah) ? '' : rupiah($data->jumlah) ?>">
    </div>

    <div class="form-group">
        <label>Total</label>
        <input type="text" readonly required id="total" name="total" autocomplete="off" placeholder="Otomatis" class="form-control rupiah" value="<?= empty($data->total) ? '' : rupiah($data->total) ?>">
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

    function hitung_total() {
        var harga_satuan = angka($('#harga_satuan').val());
        var jumlah = angka($('#jumlah').val());
        var total = harga_satuan * jumlah;
        total = formatRupiah(total + '');
        $('#total').val(total);
    }

    function do_submit(dt) {

        Swal.fire({
            title: 'Simpan Data Modal Neraca ?',
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: 'Ya',
            cancelButtonText: 'Batal',
            reverseButtons: true
        }).then((result) => {
            if (result.value) {

                $.ajax({
                    type: "POST",
                    url: "<?= base_url($this->type . '/modal_neraca/do_submit') ?>",
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