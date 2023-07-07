<div class="alert alert-primary">
    Catatan
    <ul class="mb-0 fw-600">
        <li>Pastikan data yang dimasukkan sudah sesuai</li>
        <li>Jika kosong silahkan di isi - (strip) atau 0 (nol)</li>
    </ul>
</div>
<form onsubmit="event.preventDefault();do_submit(this);">
    <div class="form-group">
        <label>User Pengambil <small class="text-danger fw-600">*</small></label>
        <input type="text" required name="user_pengambil" autocomplete="off" placeholder="Masukkan isian" class="form-control" value="<?= empty($data->user_pengambil) ? $data->pelanggan : $data->user_pengambil ?>">
    </div>

    <table class="table table-bordered table-primary">
        <tr>
            <th class="text-center" style="width: 200px;">TOTAL BIAYA</th>
            <th>BAYAR <small class="text-danger fw-600">*</small></th>
        </tr>
        <tr>
            <td class="text-center"><?= !empty($data->biaya) ? rupiah($data->biaya) : '-' ?></td>
            <td>
                <input type="text" required name="bayar" autocomplete="off" placeholder="Masukkan isian" class="form-control rupiah" value="<?= !empty($data->bayar) ? rupiah($data->bayar) : '' ?>">
            </td>
        </tr>
    </table>

    <div class="form-group">
        <label>Tanggal Keluar <small class="text-danger fw-600">*</small></label>
        <input type="date" required name="tgl_keluar" placeholder="Masukkan isian" class="form-control" value="<?= empty($data->tgl_keluar) ? '' : date('Y-m-d', strtotime($data->tgl_keluar)) ?>">
    </div>

    <input type="hidden" name="id" value="<?= encode_id(@$data->id) ?>">
    <button type="submit" class="btn btn-block btn-rounded fw-600 btn-primary"><i class="fas fa-check"></i> KLIK DISINI UNTUK SIMPAN</button>
</form>

<script>
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

                $.ajax({
                    type: "POST",
                    url: "<?= base_url('cabang/servis_berat/do_bayar') ?>",
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