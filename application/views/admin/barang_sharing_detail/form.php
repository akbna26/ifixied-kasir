<div class="alert alert-success">
    Catatan
    <ul>
        <li>Pilih barang bisa lebih dari satu</li>
        <li>Pastikan untuk memperhatikan ceklist disebelah kanan</li>
        <li>Cek stock barang</li>
        <li>Jika ganti kategori maka akan ke reset</li>
        <li>Jika merah maka tidak dapat di pilih</li>
    </ul>
</div>
<form onsubmit="event.preventDefault();do_submit(this);">

    <div class="form-group">
        <label>Kategori Barang</label>
        <select required class="form-control js_select2" data-placeholder="pilih kategori" onchange="pilih_barang(this);">
            <option value=""></option>
            <?php foreach ($ref_kategori as $dt) : ?>
                <option <?= $dt->id == @$data->id_kategori ? 'selected' : '' ?> value="<?= $dt->id ?>"><?= $dt->nama ?></option>
            <?php endforeach; ?>
        </select>
    </div>

    <div class="table-responsive">
        <table class="mt-3 table table-striped table-sm" id="table_barang">
            <thead class="bg1 text-white">
                <tr>
                    <th class="fw-600">BARCODE</th>
                    <th class="fw-600">BARANG</th>
                    <th class="fw-600">MODAL</th>
                    <th class="fw-600">QTY</th>
                    <th class="fw-600">TOTAL SHARING</th>
                    <th class="fw-600" style="width: 150px;">PILIH</th>
                </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
    </div>

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

                var barang_id = [];
                var barang_qty = [];
                $('.data_pilih').each(function(i, obj) {
                    if ($(this).is(':checked')) {
                        var id = $(this).data('target');
                        var value = $('#input_id_' + id).val();
                        console.log(value);
                        if (value == '' || value == 0) {
                            Swal.fire({
                                icon: 'error',
                                title: 'Stock tidak boleh kosong',
                                showConfirmButton: true,
                            })
                            throw false;
                        }

                        barang_id.push(id);
                        barang_qty.push(value);
                    }
                });

                if (barang_id.length < 1) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Barang wajib dipilih',
                        showConfirmButton: true,
                    });
                    throw false;
                }

                var form = new FormData(dt);
                form.append('id_sharing', ID_SHARING);
                form.append('barang_id', barang_id);
                form.append('barang_qty', barang_qty);

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
                    var html = '';
                    $.map(res.data, function(e, i) {
                        var is_disable = '';
                        var is_danger = '';

                        if (e.stock == 0 || e.stock == null || e.stock < 0) {
                            var is_disable = 'disabled';
                            var is_danger = 'bg-danger';
                        }

                        html += `
                            <tr>
                                <td class="${is_danger}">${e.barcode}</td>
                                <td class="${is_danger}">${e.nama}</td>
                                <td class="${is_danger}">${formatRupiah(e.harga_modal)}</td>
                                <td class="${is_danger}">${e.stock}</td>
                                <td class="${is_danger}">
                                    <input type="number" disabled id="input_id_${e.id}" style="width:150px;" onchange="cek_max(this,'${e.id}');" data-max="${e.stock}" placeholder="Masukkan stock sharing" class="form-control" value="">
                                </td>
                                <td class="${is_danger}">
                                    <div class="custom-control custom-switch mb-3" dir="ltr">
                                        <input ${is_disable} type="checkbox" data-target="${e.id}" class="custom-control-input data_pilih" onchange="cek_disable(this,'${e.id}');" id="customSwitch_${e.id}">
                                        <label class="custom-control-label" for="customSwitch_${e.id}"></label>
                                    </div>
                                </td>
                            </tr>
                       `;
                    });
                    $('#table_barang tbody').html(html);
                } else {
                    toastr.error('Gagal');
                }
            }
        });
    }
</script>