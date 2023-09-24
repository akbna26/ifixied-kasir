<div class="alert alert-primary">
    <i class="fa fa-note"></i> Catatan
    <ul class="mb-0 fw-600">
        <li>Verifikasi hanya dapat dilakukan sekali</li>
        <li>Pastikan tidak melakukan kesalahan</li>
    </ul>
</div>

<form onsubmit="event.preventDefault();do_submit(this);">

    <h3 class="text-center">VERIFIKASI RETUR BARANG</h3>
    <div class="text-center">
        <button data-value="1" type="button" onclick="set_radio(this,'btn_verifikasi');cek_tolak(1);" class="btn btn-outline-danger btn-lg fw-600 btn_verifikasi mr-2">TOLAK</button>
        <button data-value="2" type="button" onclick="set_radio(this,'btn_verifikasi');cek_tolak(0);" class="btn btn-outline-success btn-lg fw-600 btn_verifikasi">SETUJUI</button>
    </div>

    <hr>
    <div class="form-group" style="display: none;" id="div_alasan_tolak">
        <label>Alasan Ditolak <small class="fw-600 text-danger">(opsional)</small></label>
        <textarea rows="3" name="alasan_tolak" id="alasan_tolak" placeholder="Masukkan isian" class="form-control"></textarea>
    </div>

    <div class="form-group">
        <label>Barang yang di retur</label>
        <input readonly class="form-control is-valid" value="<?= @$data->nm_barang ?>">
    </div>

    <div class="form-group">
        <label>Alasan barang retur <small class="fw-600 text-danger">*jika retur teknisi</small></label>
        <textarea readonly rows="3" placeholder="Jika retur petugas" class="form-control is-valid"><?= @$data->alasan_refund ?></textarea>
    </div>

    <div class="row">
        <div class="col-md-6" hidden>
            <div class="form-group">
                <label>Harga Modal <small class="fw-600 text-danger">*otomatis</small></label>
                <input type="int" id="potong_profit" required readonly name="harga_modal" placeholder="Jika retur petugas" class="form-control is-valid" value="<?= !empty(@$data->harga_modal) ? rupiah($data->harga_modal) : '' ?>">
            </div>
        </div>
        <div class="col-md-12">
            <div class="form-group">
                <label>Qty <small class="fw-600 text-danger">*otomatis</small></label>
                <input autocomplete="off" type="int" readonly name="qty" placeholder="Masukkan isian" class="form-control is-valid rupiah" value="<?= @$data->qty ?>">
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

    function select_harga_modal(dt) {
        var harga = $('option:selected', dt).data('hargamodal');
        $('#potong_profit').val(harga);
    }

    function cek_tolak(type) {
        if (type == 1) {
            $('#div_alasan_tolak').slideDown(500);            
        } else {
            $('#div_alasan_tolak').slideUp(500);
            $('#alasan_tolak').val('');
        }
    }

    function do_submit(dt) {

        var status_retur = $('.btn_verifikasi.active').data('value');
        if (status_retur == undefined) {
            Swal.fire({
                icon: 'warning',
                title: 'Tentukan hasil verifikasi',
                showConfirmButton: true,
            })
            throw false;
        }

        Swal.fire({
            title: 'Simpan Retur Barang ?',
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: 'Ya',
            cancelButtonText: 'Batal',
            reverseButtons: true
        }).then((result) => {
            if (result.value) {

                var form = new FormData(dt);
                form.append('status_retur', status_retur);

                $.ajax({
                    type: "POST",
                    url: "<?= base_url(session('type') . '/retur_barang/do_verifikasi') ?>",
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
                        }
                    }
                });

            } else {
                return false;
            }
        })
    }
</script>