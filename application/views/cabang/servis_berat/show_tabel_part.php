<form onsubmit="event.preventDefault();do_submit_part(this);">
    <div class="form-group">
        <label>Kategori Barang</label>
        <select required class="form-control js_select2" data-placeholder="pilih kategori" onchange="pilih_barang(this);">
            <option value=""></option>
            <?php foreach ($ref_kategori as $dt) : ?>
                <option value="<?= $dt->id ?>"><?= $dt->nama ?></option>
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
                    <th class="fw-600">TOTAL PART</th>
                    <th class="fw-600" style="width: 150px;">PILIH</th>
                </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
    </div>

    <button type="submit" class="btn btn-block btn-rounded fw-600 btn-primary"><i class="fas fa-check"></i> TAMBAHKAN</button>
</form>

<script>
    $(document).ready(function() {
        $('.js_select2').select2({
            width: '100%'
        });
    });

    function do_submit_part(dt) {
        Swal.fire({
            title: 'Tambahkan Part ?',
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: 'Ya',
            cancelButtonText: 'Batal',
            reverseButtons: true
        }).then((result) => {
            if (result.value) {

                $('.data_pilih').each(function(i, obj) {
                    if ($(this).is(':checked')) {
                        var id = $(this).data('target');
                        var value = $('#input_id_' + id).val();

                        if (value == '' || value == 0) {
                            Swal.fire({
                                icon: 'error',
                                title: 'Stock tidak boleh kosong',
                                showConfirmButton: true,
                            })
                            throw false;
                        }

                        var barcode = $('#barcode_' + id).html();
                        var nama = $('#nama_' + id).html();
                        var modal = $('#modal_' + id).data('total');
                        var total = modal * value;

                        var html = `
                            <tr id="tr_part_${id}">
                                <td>${barcode}</td>
                                <td class="text-center">${nama}</td>
                                <td data-total="${modal}" class="text-center">${formatRupiah(modal+'')}</td>
                                <td class="text-center">${value}</td>
                                <td data-total="${total}" class="text-center">${formatRupiah(total+'')}</td>
                                <td class="text-center">
                                    <button type="button" onclick="$('#tr_part_${id}').remove();hitung_total_part();" class="btn btn-outline-danger btn-sm part_terpilih" data-id="${id}" data-modal="${modal}" data-qty="${value}" data-total="${total}">
                                        <i class="fa fa-trash-alt"></i>
                                    </button>
                                </td>
                            </tr>
                        `;

                        $('#table_part tbody').append(html);
                        hitung_total_part();
                    }
                });

                $('#modal_custom_2').modal('hide');

            } else {
                return false;
            }
        })
    }

    function pilih_barang(dt) {
        $.ajax({
            type: "POST",
            url: "<?= base_url('global/profil/get_barang_cabang') ?>",
            data: {
                id_kategori: $(dt).val(),
                id_cabang: "<?= encode_id($row->id_cabang) ?>",
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
                                <td id="barcode_${e.id}" class="${is_danger}">${e.barcode}</td>
                                <td id="nama_${e.id}" class="${is_danger}">${e.nama}</td>
                                <td id="modal_${e.id}" data-total="${e.harga_modal}" class="${is_danger}">${formatRupiah(e.harga_modal)}</td>
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

    function cek_disable(dt, id) {
        if ($(dt).is(':checked')) {
            $('#input_id_' + id).prop('disabled', false);
            $('#input_id_' + id).focus();
        } else {
            $('#input_id_' + id).prop('disabled', true);
            $('#input_id_' + id).val('');
        }
    }

    function cek_max(dt, id) {
        var value = parseInt($(dt).val());
        var max = parseInt($(dt).data('max'));

        if (value > max) {
            Swal.fire({
                    icon: 'error',
                    title: 'stock melebihi batas maksimal',
                    text: `stock sekarang ${max}, di input ${value}`,
                    showConfirmButton: true,
                })
                .then(() => {
                    $('#input_id_' + id).val('');
                    throw false;
                })
        }
    }
</script>