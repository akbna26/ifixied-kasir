<div class="alert alert-primary">
    <i class="fa fa-note"></i> Catatan
    <ul class="mb-0 fw-600">
        <li>Transaksi tidak dapat dibatalkan</li>
        <li>Pastikan kode invoice sudah sesuai</li>
    </ul>
</div>

<form onsubmit="event.preventDefault();do_submit_refund(this);">
    <table class="table table-bordered table-sm">
        <tbody>
            <tr>
                <td>Invoice</td>
                <td><?= $data->kode ?></td>
            </tr>
            <tr>
                <td>Nama</td>
                <td><?= $data->nama ?></td>
            </tr>
            <tr>
                <td>Total</td>
                <td><?= rupiah($data->total) ?></td>
            </tr>
        </tbody>
    </table>
    <div class="form-group">
        <label>Pembayaran</label>
        <select required name="pembayaran" class="form-control js_select2" data-placeholder="pilih jenis pembayaran">
            <option value="">Pilih jenis pembayaran</option>
            <?php foreach ($ref_jenis_pembayaran as $key) : ?>
                <option value="<?= $key->id ?>"><?= $key->nama ?> (potongan <?= $key->persen_potongan ?> %)</option>
            <?php endforeach; ?>
        </select>
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

    function do_submit_refund(dt) {

        Swal.fire({
            title: 'Simpan Refund DP ?',
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: 'Ya',
            cancelButtonText: 'Batal',
            reverseButtons: true
        }).then((result) => {
            if (result.value) {

                $.ajax({
                    type: "POST",
                    url: "<?= base_url($this->type . '/laporan_dp/do_refund') ?>",
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