<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body bg1 br-atas p-3 mb-0">
                <h3 class="fw-600 text1 mb-0"><i class="fa fa-info-circle mr-1"></i> EDIT PROFILE</h3>
            </div>
            <div class="card-body">
                <form onsubmit="do_submit(this);event.preventDefault();">
                    <table class="table table-striped">
                        <tr class="bg2">
                            <td style="width: 250px;">Nama Lengkap</td>
                            <td>
                                <input required type="text" class="form-control" name="nama" placeholder="tulis nama lengkap" value="<?= $data->nama ?>">
                            </td>
                        </tr>
                        <tr class="bg2">
                            <td>Username</td>
                            <td>
                                <input type="text" required class="form-control" name="username" placeholder="tulis username" value="<?= $data->username ?>">
                            </td>
                        </tr>
                        <tr class="bg2">
                            <td>Password</td>
                            <td>
                                <input type="password" class="form-control" autocomplete="new-password" name="password" placeholder="tulis password" value="">
                                <small class="d-block fw-600 text-danger">* kosongi jika tidak mengganti password</small>
                            </td>
                        </tr>
                        <tr class="bg2">
                            <td>Tulis Ulang Password</td>
                            <td>
                                <input type="password" class="form-control" name="re_password" placeholder="tulis ulang password" value="">
                            </td>
                        </tr>
                        <tr>
                            <td>Nomer HP</td>
                            <td>
                                <input type="number" required class="form-control" name="no_hp" placeholder="tulis nomer hp yang dapat dihubungi" value="<?= $data->no_hp ?>">
                            </td>
                        </tr>
                        <tr>
                            <td>Email</td>
                            <td>
                                <input type="email" required class="form-control" name="email" placeholder="tulis email" value="<?= $data->email ?>">
                            </td>
                        </tr>
                        <tr>
                            <td>Alamat</td>
                            <td>
                                <textarea required name="alamat" rows="5" placeholder="tulis alamat" class="form-control"><?= $data->alamat ?></textarea>
                            </td>
                        </tr>
                        <tr>
                            <td>Provinsi</td>
                            <td>
                                <select required name="provinsi" onchange="pilih_provinsi(this);" class="form-control js_select2" data-placeholder="pilih provinsi">
                                    <option value=""></option>
                                    <?php foreach ($ref_prov as $dt) : ?>
                                        <option <?= $dt->kode_wilayah == $data->kode_prov ? 'selected' : '' ?> value="<?= $dt->kode_wilayah ?>"><?= $dt->nama ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td>Kabupaten</td>
                            <td>
                                <select required name="kabupaten" onchange="pilih_kabupaten(this);" id="select_kabupaten" class="form-control js_select2" data-placeholder="pilih kabupaten">
                                    <option value=""></option>
                                    <?php foreach ($ref_kab as $dt) : ?>
                                        <option <?= $dt->kode_wilayah == $data->kode_kab ? 'selected' : '' ?> value="<?= $dt->kode_wilayah ?>"><?= $dt->nama ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td>Kecamatan</td>
                            <td>
                                <select required name="kecamatan" onchange="pilih_kecamatan(this);" id="select_kecamatan" class="form-control js_select2" data-placeholder="pilih kecamatan">
                                    <option value=""></option>
                                    <?php foreach ($ref_kec as $dt) : ?>
                                        <option <?= $dt->kode_wilayah == $data->kode_kec ? 'selected' : '' ?> value="<?= $dt->kode_wilayah ?>"><?= $dt->nama ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td>Kelurahan</td>
                            <td>
                                <select required name="kelurahan" id="select_kelurahan" class="form-control js_select2" data-placeholder="pilih kelurahan">
                                    <option value=""></option>
                                    <?php foreach ($ref_kel as $dt) : ?>
                                        <option <?= $dt->kode_wilayah == $data->kode_kel ? 'selected' : '' ?> value="<?= $dt->kode_wilayah ?>"><?= $dt->nama ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </td>
                        </tr>
                        <tr class="bg2">
                            <td>Foto Profile</td>
                            <td>
                                <input name="foto_profil" class="foto_profile" onchange="crop_foto(this,'foto_profile',event);" type="file" accept=".jpg,.jpeg,.png">
                            </td>
                        </tr>
                        <tr class="bg2">
                            <td colspan="2" class="text-center">
                                <img id="img_foto_profile" style="width: 300px;height: 300px;" class="rounded shadow1" src="<?= base_url($data->foto) ?>" alt="foto profile">
                                <input type="hidden" name="foto" id="input_foto_profile">
                                <input type="hidden" name="nama_foto" id="name_foto_profile">
                                <input type="hidden" name="ext" id="name_ext">
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2">
                                <button type="submit" class="btn btn-primary btn-block">Simpan</button>
                                <a href="<?= base_url('global/profil') ?>" class="btn btn-secondary btn-block">Batal</a>
                            </td>
                        </tr>
                    </table>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- modal crop -->
<div id="modal_crop_image" class="modal" data-backdrop="static" role="dialog">
    <div style="max-width: 80% !important;" class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Sesuaikan Ukuran</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <div style="width: 100%;height: 500px;" id="image_crop"></div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button id="do_crop" class="btn btn-success btn-block fw-600">CROP</button>
            </div>
        </div>
    </div>
</div>