<script>
    function cetak_harian(id, inc) {
        var link = '<?= base_url($this->type . '/report_neraca/detail') ?>';
        var tanggal = $('#pilih_tanggal_' + inc).val();
        if (tanggal == '') {
            Swal.fire({
                icon: 'warning',
                title: 'pilih tanggal terlebih dahulu',
                showConfirmButton: true,
            })
            throw false;
        }
        location.href = link + '?tanggal=' + tanggal + '&id_cabang=' + id;
    }
</script>