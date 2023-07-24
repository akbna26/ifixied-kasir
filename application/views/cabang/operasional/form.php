<form onsubmit="event.preventDefault();do_submit(this);">

    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label>Jenis Operasional</label>
                <select required name="id_operasional" class="form-control js_select2" data-placeholder="pilih jenis operasional">
                    <option value=""></option>
                    <?php foreach ($ref_operasional as $dt) : ?>
                        <option <?= $dt->id == @$data->id_operasional ? 'selected' : '' ?> value="<?= $dt->id ?>"><?= $dt->nama ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label>Sumber Dana</label>
                <select required name="id_pembayaran" class="form-control js_select2" data-placeholder="pilih sumber dana">
                    <option value=""></option>
                    <?php foreach ($ref_jenis_pembayaran as $dt) : ?>
                        <option <?= $dt->id == @$data->id_pembayaran ? 'selected' : '' ?> value="<?= $dt->id ?>"><?= $dt->nama ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
        </div>
    </div>

    <div class="form-group">
        <label>Tanggal</label>
        <input type="date" required name="tanggal" placeholder="Masukkan isian" class="form-control" value="<?= empty($data->tanggal) ? '' : date('Y-m-d', strtotime($data->tanggal)) ?>">
    </div>

    <div class="form-group">
        <label>Keterangan</label>
        <textarea required name="keterangan" rows="3" placeholder="Tulis keterangan jika diperlukan" class="form-control"><?= @$data->keterangan ?></textarea>
    </div>

    <div class="form-group">
        <label>Jumlah Operasional</label>
        <input type="text" required name="jumlah" autocomplete="off" placeholder="Masukkan isian" class="form-control rupiah" value="<?= empty($data->jumlah) ? '' : rupiah($data->jumlah) ?>">
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
            title: 'Simpan Data Operasional ?',
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: 'Ya',
            cancelButtonText: 'Batal',
            reverseButtons: true
        }).then((result) => {
            if (result.value) {

                $.ajax({
                    type: "POST",
                    url: "<?= base_url('cabang/operasional/do_submit') ?>",
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