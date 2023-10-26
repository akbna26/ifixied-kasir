<form onsubmit="event.preventDefault();do_submit(this);">

    <div class="form-group">
        <label>Status Klaim</label>
        <select required name="id_klaim" class="form-control js_select2" data-placeholder="pilih status klaim" onchange="cek_klaim(this);">
            <option <?= @$data->id_klaim == 1 ? 'selected' : '' ?> value="1">Human Error</option>
            <option <?= @$data->id_klaim == 2 ? 'selected' : '' ?> value="2">Klaim Servis IC</option>
        </select>
    </div>

    <div class="row">
        <div class="col-md-12" id="select_cabang">
            <div class="form-group">
                <label>Pegawai</label>
                <select required name="id_pegawai" id="pilih_pegawai_cabang" class="form-control js_select2 pilih_pegawai" data-placeholder="pilih pegawai">
                    <option value=""></option>
                    <?php foreach ($pegawai as $dt) : ?>
                        <option <?= $dt->id == @$data->id_pegawai ? 'selected' : '' ?> value="<?= $dt->id ?>"><?= $dt->nama ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
        </div>
        <div class="col-md-12" style="display: none;" id="select_office">
            <div class="form-group">
                <label>Pegawai Office <small class="text-danger">* khusus servis IC</small></label>
                <select id="pilih_pegawai_office" name="id_pegawai_office" class="form-control js_select2 pilih_pegawai" data-placeholder="pilih pegawai office">
                    <option value=""></option>
                    <?php foreach ($pegawai_office as $dt) : ?>
                        <option <?= $dt->id == @$data->id_pegawai_office ? 'selected' : '' ?> value="<?= $dt->id ?>"><?= $dt->nama ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="form-group">
                <label>Barang</label>
                <select required name="id_barang" class="form-control js_select2" onchange="select_harga_modal(this);" data-placeholder="pilih barang">
                    <option value=""></option>
                    <?php foreach ($barang as $dt) : ?>
                        <option data-hargamodal="<?= rupiah($dt->harga_modal) ?>" <?= $dt->id == @$data->id_barang ? 'selected' : '' ?> value="<?= $dt->id ?>"><?= $dt->barcode . ' - ' . $dt->nm_barang ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
        </div>
        <div class="col-md-6" hidden>
            <div class="form-group">
                <label>Harga Barang <small class="fw-600 text-danger">*otomatis</small></label>
                <input type="int" id="potong_profit" readonly name="harga_modal" placeholder="Pilih barang terlebih dahulu" class="form-control" value="<?= !empty(@$data->modal) ? rupiah($data->modal) : '' ?>">
            </div>
        </div>
    </div>

    <div class="form-group">
        <label>Tanggal</label>
        <input type="date" required name="tanggal" placeholder="Masukkan isian" class="form-control" value="<?= empty($data->tanggal) ? date('Y-m-d') : date('Y-m-d', strtotime($data->tanggal)) ?>">
    </div>

    <div class="form-group">
        <label>Keterangan</label>
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

    function cek_klaim(dt) {
        var status = $(dt).val();
        $('.pilih_pegawai').prop('required', false);
        if (status == 1) {
            $('#pilih_pegawai_office').val('').change();
            $('#pilih_pegawai_cabang').prop('required', true);
            $('#select_cabang').show(500);
            $('#select_office').hide();
        } else {
            $('#pilih_pegawai_cabang').val('').change();
            $('#select_office').show(500);
            $('#select_cabang').hide();
            $('#pilih_pegawai_office').prop('required', true);
        }
    }

    function select_harga_modal(dt) {
        var harga = $('option:selected', dt).data('hargamodal');
        $('#potong_profit').val(harga);
    }

    function do_submit(dt) {

        Swal.fire({
            title: 'Simpan Data ?',
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: 'Ya',
            cancelButtonText: 'Batal',
            reverseButtons: true
        }).then((result) => {
            if (result.value) {

                $.ajax({
                    type: "POST",
                    url: "<?= base_url(session('type') . '/human_error/do_submit') ?>",
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