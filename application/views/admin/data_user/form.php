<form onsubmit="event.preventDefault();do_submit(this);">
    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label>Nama Lengkap</label>
                <input type="text" required name="nama" autocomplete="off" placeholder="Tulis nama lengkap" class="form-control" value="<?= @$data->nama ?>">
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label>Username</label>
                <input type="text" required autocomplete="new-password" name="username" autocomplete="off" placeholder="Tulis username" class="form-control" value="<?= @$data->username ?>">
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label>Password</label>
                <input type="password" autocomplete="new-password" <?= empty($data->id) ? 'required' : '' ?> name="password" autocomplete="off" placeholder="Tulis password" class="form-control" value="">
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label>Ulangi Password</label>
                <input type="password" autocomplete="new-password" <?= empty($data->id) ? 'required' : '' ?> name="re_password" autocomplete="off" placeholder="Tulis ulangi password" class="form-control" value="">
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label>Email</label>
                <input type="email" required name="email" autocomplete="off" placeholder="Tulis email aktif" class="form-control" value="<?= @$data->email ?>">
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label>Nomer HP</label>
                <input type="number" required name="no_hp" autocomplete="off" placeholder="Tulis nomer hp yang aktif" class="form-control" value="<?= @$data->no_hp ?>">
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="form-group">
                <label>Cabang Toko</label>
                <select required name="id_cabang" class="form-control js_select2" data-placeholder="pilih cabang">
                    <option value=""></option>
                    <?php foreach ($ref_cabang as $dt) : ?>
                        <option <?= $dt->id == @$data->id_cabang ? 'selected' : '' ?> value="<?= $dt->id ?>"><?= $dt->nama ?> - <?= $dt->lokasi ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
        </div>
    </div>

    <?php if ($otoritas == 5) : ?>
        <div class="row">
            <div class="col-md-12">
                <div class="form-group">
                    <label>Cabang Owner <small class="text-danger">*khusus owner cabang</small></label>
                    <select required multiple name="id_cabang_multi[]" class="form-control js_select2" data-placeholder="pilih cabang">
                        <option value=""></option>
                        <?php foreach ($ref_cabang as $dt) : ?>
                            <option <?= in_array(@$dt->id, $arr_multi) ? 'selected' : '' ?> value="<?= $dt->id ?>"><?= $dt->nama ?> - <?= $dt->lokasi ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>
        </div>
    <?php endif; ?>

    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label>Provinsi</label>
                <select required name="provinsi" onchange="pilih_provinsi(this);" class="form-control js_select2" data-placeholder="pilih provinsi">
                    <option value=""></option>
                    <?php foreach ($ref_prov as $dt) : ?>
                        <option <?= $dt->kode_wilayah == @$data->kode_prov ? 'selected' : '' ?> value="<?= $dt->kode_wilayah ?>"><?= $dt->nama ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label>Kabupaten</label>
                <select required name="kabupaten" onchange="pilih_kabupaten(this);" id="select_kabupaten" class="form-control js_select2" data-placeholder="pilih kabupaten">
                    <option value=""></option>
                    <?php foreach ($ref_kab as $dt) : ?>
                        <option <?= $dt->kode_wilayah == @$data->kode_kab ? 'selected' : '' ?> value="<?= $dt->kode_wilayah ?>"><?= $dt->nama ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label>Kecamatan</label>
                <select required name="kecamatan" onchange="pilih_kecamatan(this);" id="select_kecamatan" class="form-control js_select2" data-placeholder="pilih kecamatan">
                    <option value=""></option>
                    <?php foreach ($ref_kec as $dt) : ?>
                        <option <?= $dt->kode_wilayah == @$data->kode_kec ? 'selected' : '' ?> value="<?= $dt->kode_wilayah ?>"><?= $dt->nama ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label>Kelurahan</label>
                <select required name="kelurahan" id="select_kelurahan" class="form-control js_select2" data-placeholder="pilih kelurahan">
                    <option value=""></option>
                    <?php foreach ($ref_kel as $dt) : ?>
                        <option <?= $dt->kode_wilayah == @$data->kode_kel ? 'selected' : '' ?> value="<?= $dt->kode_wilayah ?>"><?= $dt->nama ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="form-group">
                <label>Alamat</label>
                <textarea name="alamat" rows="5" class="form-control" placeholder="tulis alamat yang sesuai"><?= @$data->alamat ?></textarea>
            </div>
        </div>
    </div>

    <input type="hidden" name="id" value="<?= encode_id(@$data->id) ?>">
    <input type="hidden" name="otoritas" value="<?= encode_id($otoritas) ?>">
    <button type="submit" class="btn btn-block btn-primary">SIMPAN</button>
</form>

<script>
    $(document).ready(function() {
        $('.js_select2').select2({
            width: '100%'
        });
    });

    function do_submit(dt) {
        Swal.fire({
            title: 'Simpan data ?',
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: 'Ya',
            cancelButtonText: 'Batal',
            reverseButtons: true
        }).then((result) => {
            if (result.value) {
                $.ajax({
                    type: "POST",
                    url: "<?= base_url('admin/data_user/do_submit') ?>",
                    data: new FormData(dt),
                    dataType: "JSON",
                    contentType: false,
                    processData: false,
                    error: function(res) {
                        toastr.error('gagal');
                    },
                    success: function(res) {
                        if (res.status == 'success') {
                            $('#modal_custom').modal('hide');
                            $('#table_data').DataTable().ajax.reload();
                            toastr.success('data berhasil disimpan');
                        } else {
                            Swal.fire({
                                icon: 'warning',
                                title: res.msg,
                                showConfirmButton: true,
                            })
                        }
                    }
                });
            }
        })
    }

    function pilih_provinsi(dt) {
        $.ajax({
            type: "POST",
            url: "<?= base_url('global/profil/get_kabupaten') ?>",
            data: {
                id_prov: $(dt).val(),
            },
            dataType: "JSON",
            success: function(res) {
                if (res.status == 'success') {
                    var html = '<option value=""></option>';
                    $.map(res.data, function(e, i) {
                        html += `
                            <option value="${e.kode_wilayah}">${e.nama}</option>
                       `;
                    });
                    $('#select_kabupaten').html(html);
                    $('#select_kecamatan').html('<option value=""></option>');
                    $('#select_kelurahan').html('<option value=""></option>');
                } else {
                    toastr.error('Gagal');
                }
            }
        });
    }

    function pilih_kabupaten(dt) {
        $.ajax({
            type: "POST",
            url: "<?= base_url('global/profil/get_kecamatan') ?>",
            data: {
                id_kab: $(dt).val(),
            },
            dataType: "JSON",
            success: function(res) {
                if (res.status == 'success') {
                    var html = '<option value=""></option>';
                    $.map(res.data, function(e, i) {
                        html += `
                            <option value="${e.kode_wilayah}">${e.nama}</option>
                       `;
                    });
                    $('#select_kecamatan').html(html);
                    $('#select_kelurahan').html('<option value=""></option>');
                } else {
                    toastr.error('Gagal');
                }
            }
        });
    }

    function pilih_kecamatan(dt) {
        $.ajax({
            type: "POST",
            url: "<?= base_url('global/profil/get_kelurahan') ?>",
            data: {
                id_kec: $(dt).val(),
            },
            dataType: "JSON",
            success: function(res) {
                if (res.status == 'success') {
                    var html = '<option value=""></option>';
                    $.map(res.data, function(e, i) {
                        html += `
                            <option value="${e.kode_wilayah}">${e.nama}</option>
                       `;
                    });
                    $('#select_kelurahan').html(html);
                } else {
                    toastr.error('Gagal');
                }
            }
        });
    }
</script>