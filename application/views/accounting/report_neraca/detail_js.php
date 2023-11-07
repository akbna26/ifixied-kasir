<script>
    $(document).ready(function() {
        modal_hitung();
    });

    const id_cabang = "<?= $id_cabang ?>";

    function remove_disable(dt) {
        $(dt).prop('disabled', false);
        $(dt).focus();
    }

    function add_disabled(dt) {
        $(dt).prop('disabled', true);
    }

    function save_one(dt, jenis) {
        $.ajax({
            type: "POST",
            url: "<?= base_url($this->type . '/report_neraca/save_one') ?>",
            data: {
                value: $(dt).val(),
                id_cabang: id_cabang,
                jenis: jenis,
            },
            dataType: "JSON",
            beforeSend: function() {
                Swal.fire({
                    title: 'Loading',
                    html: '<i style="font-size:25px;" class="fa fa-spinner fa-spin"></i>',
                    allowOutsideClick: false,
                    showConfirmButton: false,
                });
            },
            complete: function() {
                Swal.close();
            },
            success: function(res) {
                if (res.status == 'success') {
                    toastr.success("Berhasil disimpan");
                    modal_hitung();
                }
            }
        });
    }

    function modal_hitung() {
        var total = 0;
        $('.modal_hitung').each(function() {
            var nilai = $(this).val();
            total += angka(nilai);
        });

        var modal_awal = $('.modal_hitung_awal').html();
        total += angka(modal_awal);

        var hasil = formatRupiah(total + '');
        var modal_tidak_bergerak = angka($('#modal_tidak_bergerak').html());
        $('#target_modal').html(hasil);
        $('#modal_total').html(hasil);
        var all = angka(modal_tidak_bergerak) + total;
        all = formatRupiah(all + '');
        $('#modal_all').html(all);
    }
</script>