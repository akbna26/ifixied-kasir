<div class="alert alert-primary">
    Catatan
    <ul class="mb-0 fw-600">
        <li>Pastikan data yang dimasukkan sudah sesuai</li>
        <li>Jika kosong silahkan di isi - (strip) atau 0 (nol)</li>
    </ul>
</div>
<form onsubmit="event.preventDefault();do_submit(this);">
    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label>Pegawai <small class="text-danger fw-600">*</small></label>
                <select required name="id_pegawai" class="form-control js_select2" data-placeholder="pilih pegawai">
                    <option value=""></option>
                    <?php foreach ($pegawai as $dt) : ?>
                        <option value="<?= $dt->id ?>"><?= $dt->nama ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label>User Pengambil <small class="text-danger fw-600">*</small></label>
                <input type="text" required name="user_pengambil" autocomplete="off" placeholder="Masukkan isian" class="form-control" value="<?= empty($data->user_pengambil) ? $data->pelanggan : $data->user_pengambil ?>">
            </div>
        </div>
    </div>

    <table class="table table-bordered table-primary">
        <tr>
            <th class="text-center" style="width: 200px;">TOTAL BIAYA</th>
            <th style="width: 300px;">JENIS PEMBAYARAN <small class="text-danger fw-600">*</small></th>
            <th>BAYAR <small class="text-danger fw-600">*</small></th>
            <th class="bg-white">SPLIT PEMBAYARAN <small class="text-danger fw-600">(opsional)</small></th>
        </tr>
        <tr>
            <td rowspan="2" style="vertical-align: middle;" class="text-center"><?= !empty($data->biaya) ? rupiah($data->biaya) : '-' ?></td>
            <td>
                <select required name="jenis_bayar_1" id="select_pembayaran" class="form-control js_select2" data-placeholder="pilih jenis pembayaran">
                    <option value=""></option>
                    <?php foreach ($ref_jenis_pembayaran as $dt) : ?>
                        <option value="<?= $dt->id ?>"><?= $dt->nama ?></option>
                    <?php endforeach; ?>
                </select>
            </td>
            <td>
                <input type="text" required name="bayar" autocomplete="off" placeholder="Masukkan isian" class="form-control rupiah" value="<?= !empty($data->bayar) ? rupiah($data->bayar) : '' ?>">
            </td>
            <td class="bg-white text-center" rowspan="2" style="vertical-align: middle;">
                <div class="btn-group btn-group-example" role="group">
                    <button type="button" onclick="set_radio(this,'cek_split');is_split(1);" data-value="1" class="btn btn-outline-primary w-sm cek_split">Ya</button>
                    <button type="button" onclick="set_radio(this,'cek_split');is_split(0);" data-value="0" class="btn btn-outline-primary w-sm cek_split active">Tidak</button>
                </div>
            </td>
        </tr>
        <tr class="is_split" style="display: none;">
            <td>
                <select name="jenis_bayar_2" class="form-control bayar_2 js_select2" data-placeholder="pilih jenis pembayaran kedua">
                    <option value=""></option>
                    <?php foreach ($ref_jenis_pembayaran as $dt) : ?>
                        <option value="<?= $dt->id ?>"><?= $dt->nama ?></option>
                    <?php endforeach; ?>
                </select>
            </td>
            <td>
                <input type="text" name="bayar_split" autocomplete="off" placeholder="Masukkan isian" class="form-control bayar_2 rupiah" value="<?= !empty($data->bayar) ? rupiah($data->bayar) : '' ?>">
            </td>
        </tr>
    </table>

    <div class="form-group">
        <label>Tanggal Keluar <small class="text-danger fw-600">*</small></label>
        <input type="date" required name="tgl_keluar" placeholder="Masukkan isian" class="form-control" value="<?= empty($data->tgl_keluar) ? date('Y-m-d') : date('Y-m-d', strtotime($data->tgl_keluar)) ?>">
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
            title: 'Proses Pengambilan ?',
            text: 'dapat dibatalkan, pastikan ada sudah sesuai',
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: 'Ya',
            cancelButtonText: 'Batal',
            reverseButtons: true
        }).then((result) => {
            if (result.value) {

                var form_data = new FormData(dt);

                var cek_split = $('.cek_split.active').data('value');
                form_data.append('cek_split', cek_split);

                $.ajax({
                    type: "POST",
                    url: "<?= base_url('cabang/servis_berat/do_bayar') ?>",
                    data: form_data,
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
                                    window.open(res.link);
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

    function is_split(type) {
        if (type == 1) {
            $('.is_split').show(500);
            $('.bayar_2').prop('required', true);
        } else {
            $('.is_split').hide(500);
            $('.bayar_2').prop('required', false);
        }
    }
</script>