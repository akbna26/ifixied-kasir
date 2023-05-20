<form onsubmit="event.preventDefault();do_submit(this);">

    <?php if (empty($data)) : ?>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label>Kategori Barang</label>
                    <select required class="form-control js_select2" data-placeholder="pilih kategori" onchange="pilih_barang(this);">
                        <option value=""></option>
                        <?php foreach ($ref_kategori as $dt) : ?>
                            <option <?= $dt->id == @$data->id_kategori ? 'selected' : '' ?> value="<?= $dt->id ?>"><?= $dt->nama ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label>Barang</label>
                    <select name="id_barang" required class="form-control js_select2" data-placeholder="pilih produk" id="select_barang" onchange="cek_stock(this);">
                        <option value=""></option>
                        <?php foreach ($ref_barang as $dt) : ?>
                            <option <?= $dt->id == @$data->id_barang ? 'selected' : '' ?> value="<?= $dt->id ?>" data-stock="<?= $dt->stock ?>"><?= $dt->nama ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>
        </div>
    <?php else : ?>
        <input type="hidden" name="id_barang" value="<?= @$data->id_barang ?>">
    <?php endif; ?>

    <div class="alert alert-success" id="div_stock" style="display: none;">
        <h3 class="text-center fw-600 mb-0">Stock Saat ini : <span id="total_stock">-</span></h3>
    </div>

    <div class="form-group">
        <label>Total Sharing Stock</label>
        <input type="text" required name="stock" autocomplete="off" placeholder="Masukkan isian" class="form-control rupiah" value="<?= @$data->stock ?>">
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
            title: 'Sharing Barang ?',
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: 'Ya',
            cancelButtonText: 'Batal',
            reverseButtons: true
        }).then((result) => {
            if (result.value) {

                var form = new FormData(dt);
                form.append('id_sharing', ID_SHARING);

                $.ajax({
                    type: "POST",
                    url: "<?= base_url('admin/barang_sharing_detail/do_submit') ?>",
                    data: form,
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
                            });
                        }
                    }
                });

            } else {
                return false;
            }
        })
    }

    function pilih_barang(dt) {
        $.ajax({
            type: "POST",
            url: "<?= base_url('global/profil/get_barang') ?>",
            data: {
                id_kategori: $(dt).val(),
            },
            dataType: "JSON",
            success: function(res) {
                if (res.status == 'success') {
                    var html = '<option value=""></option>';
                    $.map(res.data, function(e, i) {
                        html += `
                            <option value="${e.id}" data-stock="${e.stock}">${e.nama}</option>
                       `;
                    });
                    $('#select_barang').html(html);
                    $('#div_stock').slideUp(500);
                } else {
                    toastr.error('Gagal');
                }
            }
        });
    }

    function cek_stock(dt) {
        var stock = $('option:selected', dt).data('stock');
        $('#total_stock').html(stock);
        $('#div_stock').slideDown(500);
    }
</script>