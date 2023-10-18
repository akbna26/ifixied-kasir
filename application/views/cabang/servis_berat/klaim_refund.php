<form onsubmit="event.preventDefault();do_submit(this);">

    <div class="form-group">
        <label>Metode Pembayaran</label>
        <select required name="id_pembayaran" class="form-control js_select2" data-placeholder="pilih sumber dana">
            <option value=""></option>
            <?php foreach ($ref_jenis_pembayaran as $dt) : ?>
                <option value="<?= $dt->id ?>"><?= $dt->nama ?> (<?= $dt->persen_potongan ?>)</option>
            <?php endforeach; ?>
        </select>
    </div>

    <div class="form-group">
        <label>Alasan Refund <small class="text-danger fw-600">*</small></label>
        <textarea name="alasan_refund" rows="3" placeholder="Masukkan isian" class="form-control"></textarea>
    </div>

    <input type="hidden" name="id" value="<?= encode_id($id) ?>">
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
            title: 'Simpan Klaim Refund ?',
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: 'Ya',
            cancelButtonText: 'Batal',
            reverseButtons: true
        }).then((result) => {
            if (result.value) {

                $.ajax({
                    type: "POST",
                    url: "<?= base_url('cabang/servis_berat/do_klaim_refund') ?>",
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
                                    get_total();
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