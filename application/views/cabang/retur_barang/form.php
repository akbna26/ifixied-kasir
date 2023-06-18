<div class="alert alert-primary">
    <i class="fa fa-note"></i> Catatan
    <ul class="mb-0 fw-600">
        <li>Barang yang diretur oleh teknisi harus sudah melalui tahap pengecekan</li>
    </ul>
</div>

<form onsubmit="event.preventDefault();do_submit(this);">
    <div class="form-group">
        <label>Barang yang di retur</label>
        <select required name="id_barang" class="form-control js_select2" onchange="select_harga_modal(this);" data-placeholder="pilih barang">
            <option value=""></option>
            <?php foreach ($barang as $dt) : ?>
                <option data-hargamodal="<?= rupiah($dt->harga_modal) ?>" <?= $dt->id == @$data->id_barang ? 'selected' : '' ?> value="<?= $dt->id ?>"><?= $dt->barcode . ' - ' . $dt->nm_barang ?></option>
            <?php endforeach; ?>
        </select>
    </div>

    <div class="form-group">
        <label>Alasan barang retur <small class="fw-600 text-danger">*</small></label>
        <textarea required name="keterangan" rows="3" placeholder="Tulis keterangan produk" class="form-control"><?= @$data->alasan_refund ?></textarea>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label>Harga Modal <small class="fw-600 text-danger">*otomatis</small></label>
                <input type="int" id="potong_profit" required readonly name="harga_modal" placeholder="Pilih barang terlebih dahulu" class="form-control" value="<?= !empty(@$data->harga_modal) ? rupiah($data->harga_modal) : '' ?>">
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label>Qty <small class="fw-600 text-danger">*</small></label>
                <input autocomplete="off" type="int" required name="total" placeholder="Masukkan isian" class="form-control rupiah" value="<?= @$data->qty ?>">
            </div>
        </div>
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

    function select_harga_modal(dt){
        var harga = $('option:selected', dt).data('hargamodal');
        $('#potong_profit').val(harga);
    }

    function do_submit(dt) {

        Swal.fire({
            title: 'Simpan Retur Barang ?',
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: 'Ya',
            cancelButtonText: 'Batal',
            reverseButtons: true
        }).then((result) => {
            if (result.value) {

                $.ajax({
                    type: "POST",
                    url: "<?= base_url('cabang/retur_barang/do_submit') ?>",
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