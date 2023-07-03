<div class="alert alert-primary">
    <i class="fa fa-note"></i> Catatan
    <ul class="mb-0 fw-600">
        <li>Verifikasi hanya dapat dilakukan sekali</li>
        <li>Pastikan tidak melakukan kesalahan</li>
    </ul>
</div>

<form onsubmit="event.preventDefault();do_submit(this);">

    <h3 class="text-center">KONFIRMASI STATUS SERVIS</h3>
    <div class="text-center">
        <button data-value="5" type="button" onclick="set_radio(this,'btn_konfirmasi');cek_konfirmasi(5);" class="btn btn-outline-success btn-lg fw-600 btn_konfirmasi mx-2">Proses Pengerjaan</button>
        <button data-value="7" type="button" onclick="set_radio(this,'btn_konfirmasi');cek_konfirmasi(7);" class="btn btn-outline-danger btn-lg fw-600 btn_konfirmasi mx-2">Cancel by User</button>
        <button data-value="8" type="button" onclick="set_radio(this,'btn_konfirmasi');cek_konfirmasi(8);" class="btn btn-outline-danger btn-lg fw-600 btn_konfirmasi mx2">Cancel by Teknisi</button>
    </div>

    <hr>

    <div id="proses_pengerjaan" class="mt-3" style="display: none;">
        <div class="card rounded alert alert-success">
            <div class="card-body">

                <table class="table table-bordered table-sm table-primary">
                    <tr>
                        <th>DIAGNOSA</th>
                        <th>KETERANGAN/DESKRIPSI</th>
                        <th>KERUSAKAN</th>
                        <th>ESTIMASI BIAYA</th>
                    </tr>
                    <tr>
                        <td><?= nl2br($data->diagnosa) ?></td>
                        <td><?= nl2br($data->keterangan) ?></td>
                        <td><?= nl2br($data->kerusakan) ?></td>
                        <td><?= rupiah($data->estimasi_biaya) ?></td>
                    </tr>
                </table>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Tindakan</label>
                            <select required name="id_tindakan" id="tindakan" class="form-control js_select2 wajib" onchange="select_tindakan(this);" data-placeholder="pilih jenis tindakan">
                                <option value=""></option>
                                <?php foreach ($ref_tindakan as $dt) : ?>
                                    <option <?= @$data->id_tindakan == $dt->id ? 'selected' : '' ?> value="<?= $dt->id ?>"><?= $dt->nama ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Teknisi <small class="text-danger fw-600">(pilih tindakan terlebih dahulu)</small></label>
                            <select required name="id_teknisi" id="teknisi" onchange="hitung_modal();" class="form-control js_select2 wajib" data-placeholder="pilih teknisi">
                                <option value=""></option>
                                <?php foreach ($ref_teknisi as $dt) : ?>
                                    <option <?= @$data->id_teknisi_setting == $dt->id ? 'selected' : '' ?> data-prosen="<?= $dt->prosentase ?>" value="<?= $dt->id ?>"><?= $dt->nm_pegawai ?> (<?= $dt->prosentase ?>%)</option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Biaya <small class="text-danger fw-600">(Biaya akhir)</small></label>
                            <input type="text" required id="biaya" name="biaya" onchange="hitung_modal();" autocomplete="off" placeholder="Masukkan isian" class="form-control rupiah wajib" value="<?= !empty($data->biaya) ? rupiah($data->biaya) : '' ?>">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Harga PART/IC Nand</label>
                            <input type="text" required id="part" name="harga_part" onchange="hitung_modal();" autocomplete="off" placeholder="Masukkan isian" class="form-control rupiah wajib" value="<?= !empty($data->harga_part) ? rupiah($data->harga_part) : '' ?>">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Modal <small class="flash1 fw-600">(otomatis dari sistem)</small></label>
                            <input type="text" readonly required id="modal_servis" name="modal" autocomplete="off" placeholder="Masukkan isian" class="form-control rupiah wajib" value="<?= !empty($data->modal) ? rupiah($data->modal) : '' ?>">
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <div class="form-group">
        <label>Keterangan Status<small class="text-danger fw-600">(opsional)</small></label>
        <textarea name="keterangan" rows="3" placeholder="Masukkan isian" class="form-control"></textarea>
    </div>

    <input type="hidden" name="id" value="<?= encode_id(@$data->id) ?>">
    <input type="hidden" name="form" value="<?= encode_id(3) ?>">
    <button type="submit" class="btn btn-block btn-rounded fw-600 btn-primary"><i class="fas fa-check"></i> KONFIRMASI STATUS</button>
</form>

<script>
    $(document).ready(function() {
        $('.js_select2').select2({
            width: '100%'
        });
    });

    function hitung_modal() {
        var prosen = parseFloat($('option:selected', $('#teknisi')).data('prosen'));
        var part = angka($('#part').val());
        var biaya = angka($('#biaya').val());

        var hasil = ((biaya - part) * (prosen / 100)) + part;
        $('#modal_servis').val(formatRupiah(hasil + ''));
    }

    function cek_konfirmasi(type) {
        if (type == 5) {
            $('#proses_pengerjaan').slideDown(500);
            $('.wajib').prop('required', true);
        } else {
            $('#proses_pengerjaan').slideUp(500);
            $('.wajib').prop('required', false);
        }
    }

    function select_tindakan(dt) {
        $.ajax({
            type: "POST",
            url: "<?= base_url('admin/servis_berat/get_tindakan_teknisi') ?>",
            data: {
                id_tindakan: $(dt).val(),
            },
            dataType: "JSON",
            success: function(res) {
                if (res.status == 'success') {
                    var html = '<option value=""></option>';
                    $.map(res.data, function(e, i) {
                        html += `
                            <option data-prosen="${e.prosentase}" value="${e.id}">${e.nm_pegawai} (${e.prosentase}%)</option>
                       `;
                    });
                    $('#teknisi').html(html);
                } else {
                    toastr.error('Gagal');
                }
            }
        });
    }

    function do_submit(dt) {
        var status = $('.btn_konfirmasi.active').data('value');
        if (status == undefined) {
            Swal.fire({
                icon: 'warning',
                title: 'Pilih Status Servis',
                showConfirmButton: true,
            })
            throw false;
        }

        Swal.fire({
            title: 'Konfirmasi Status Servis ?',
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: 'Ya',
            cancelButtonText: 'Batal',
            reverseButtons: true
        }).then((result) => {
            if (result.value) {

                var form = new FormData(dt);
                form.append('status', status);

                $.ajax({
                    type: "POST",
                    url: "<?= base_url('admin/servis_berat/do_konfirmasi') ?>",
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
                                    title: 'Status berhasil diperbarui',
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