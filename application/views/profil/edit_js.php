<!-- croppie -->
<link rel="stylesheet" href="<?= base_url('assets/plugin/croppie/croppie.css') ?>">
<script src="<?= base_url('assets/plugin/croppie/croppie.js') ?>"></script>

<script>
    var image_crop, nama_file, type;

    $('#do_crop').click(function(event) {
        image_crop.croppie('result', {
            type: 'canvas',
            size: {
                width: 700,
                height: 700,
            }
        }).then(function(res) {
            $('#img_' + type).attr('src', res);
            $('#input_' + type).val(res);
            $('#name_' + type).val(nama_file);
            $('.' + type).val('');
            $('#modal_crop_image').modal('hide');
        })
    });

    function crop_foto(dt, id, event) {
        type = id;

        var url = $(dt).val();
        var ext = url.substring(url.lastIndexOf('.') + 1).toLowerCase();
        $('#name_ext').val(ext);

        if (image_crop) {
            image_crop.croppie('destroy');
        }

        if (id == 'foto_profile') {
            image_crop = $('#image_crop').croppie({
                viewport: {
                    width: 400, // lebar image
                    height: 400, // tinggi image
                    type: 'square' //circle
                },
            });
        }

        var reader = new FileReader();
        reader.onload = function(event) {
            image_crop.croppie('bind', {
                url: event.target.result
            }).then(function() {
                // console.log('jQuery bind complete');
            });
        }

        nama_file = event.target.files[0].name;
        reader.readAsDataURL(dt.files[0]);
        $('#modal_crop_image').modal('show');
        $('.' + id).prop('disabled', true);
    }

    $('#modal_crop_image').on('hidden.bs.modal', function() {
        $('.' + type).prop('disabled', false);
        $('.' + type).val('')
    });
</script>

<script>
    function do_submit(dt) {
        Swal.fire({
            title: 'Perbarui Profil ?',
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: 'Ya',
            cancelButtonText: 'Batal',
            reverseButtons: true
        }).then((result) => {
            if (result.value) {

                var data = new FormData(dt)
                $.ajax({
                    type: "POST",
                    url: "<?= base_url('global/profil/do_submit') ?>",
                    data: data,
                    contentType: false,
                    processData: false,
                    dataType: "JSON",
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
                            Swal.fire({
                                    icon: 'success',
                                    title: 'Berhasil disimpan',
                                    showConfirmButton: true,
                                })
                                .then(() => {
                                    location.href = '<?= base_url('global/profil') ?>';
                                })

                        } else {
                            Swal.fire({
                                icon: 'warning',
                                title: res.msg,
                                showConfirmButton: true,
                            })
                        }
                    }
                });

            } else {
                return false;
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