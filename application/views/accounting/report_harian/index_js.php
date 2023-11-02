<script>
    function cetak_harian(id, inc) {
        var link = '<?= base_url($this->type . '/cetak/laporan_harian') ?>';
        var tanggal = $('#pilih_tanggal_' + inc).val();
        if (tanggal == '') {
            Swal.fire({
                icon: 'warning',
                title: 'pilih tanggal terlebih dahulu',
                showConfirmButton: true,
            })
            throw false;
        }
        window.open(link + '?tanggal=' + tanggal + '&id_cabang=' + id);
    }
</script>