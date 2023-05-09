<form onsubmit="event.preventDefault();do_submit(this);" enctype="multipart/form-data">
    <div class="form-group">
        <label>Nama Barang</label>
        <input type="text" required name="nama" autocomplete="off" placeholder="Masukkan isian" class="form-control" value="<?= @$data->nama ?>">
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label>Kategori Produk</label>
                <select required name="id_kategori" class="form-control js_select2" data-placeholder="pilih kategori">
                    <option value=""></option>
                    <?php foreach ($ref_kategori as $dt) : ?>
                        <option <?= $dt->id == @$data->id_kategori ? 'selected' : '' ?> value="<?= $dt->id ?>"><?= $dt->nama ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label>Toko Cabang</label>
                <select required name="id_cabang" class="form-control js_select2" data-placeholder="pilih cabang">
                    <option value=""></option>
                    <?php foreach ($ref_cabang as $dt) : ?>
                        <option <?= $dt->id == @$data->id_cabang ? 'selected' : '' ?> value="<?= $dt->id ?>"><?= $dt->nama ?> - <?= $dt->lokasi ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-4">
            <div class="form-group">
                <label>Harga Modal</label>
                <input type="text" required name="harga_modal" autocomplete="off" placeholder="Masukkan isian" class="form-control rupiah" value="<?= !empty($data->harga_modal) ? rupiah($data->harga_modal) : '' ?>">
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                <label>Harga Jual</label>
                <input type="text" required name="harga_jual" autocomplete="off" placeholder="Masukkan isian" class="form-control rupiah" value="<?= !empty($data->harga_jual) ? rupiah($data->harga_jual) : '' ?>">
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                <label>Barcode</label>
                <input type="text" required name="barcode" autocomplete="off" placeholder="Masukkan isian" class="form-control" value="<?= @$data->barcode ?>">
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-4">
            <div class="form-group">
                <label>Stock <small class="text-danger fw-600">*pertama kali barang di input</small></label>
                <input <?= !empty($data) ? 'disabled' : '' ?> type="text" required name="stock" autocomplete="off" placeholder="Masukkan isian" class="form-control <?= !empty($data) ? 'border border-danger' : '' ?> rupiah" value="<?= !empty($data->stock) ? rupiah($data->stock) : '' ?>">
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                <label>Tanggal Stock <small class="text-danger fw-600">*pertama kali barang di input</small></label>
                <input <?= !empty($data) ? 'disabled' : '' ?> type="date" required name="tanggal_restock" placeholder="Masukkan isian" class="form-control <?= !empty($data) ? 'border border-danger' : '' ?>" value="<?= empty($data->tanggal_restock) ? '' : date('Y-m-d', strtotime($data->tanggal_restock)) ?>">
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                <label>Gambar <small class="text-danger fw-600">*opsional</small></label>
                <input type="file" accept="image/*" name="gambar" autocomplete="off" placeholder="Masukkan isian" class="form-control">
            </div>
        </div>
    </div>

    <div class="form-group">
        <label>Keterangan <small class="text-danger fw-600">*opsional</small></label>
        <textarea name="keterangan" rows="3" placeholder="Tulis keterangan jika diperlukan" class="form-control"><?= @$data->keterangan ?></textarea>
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
            title: 'Simpan Data Barang ?',
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: 'Ya',
            cancelButtonText: 'Batal',
            reverseButtons: true
        }).then((result) => {
            if (result.value) {

                $.ajax({
                    type: "POST",
                    url: "<?= base_url('admin/barang/do_submit') ?>",
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
                        } else {
                            Swal.fire({
                                icon: 'warning',
                                title: res.msg,
                                showConfirmButton: true,
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