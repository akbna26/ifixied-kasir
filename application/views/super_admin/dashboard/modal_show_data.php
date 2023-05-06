<div class="table-responsive">
    <table class="table table-bordered table-hover table-sm" id="tabel_show_data" style="width: 100%;">
        <thead>
            <tr class="text-center">
                <th>No</th>
                <th>Username</th>
                <th>Nama</th>
                <th>Cabang</th>
                <th>Informasi</th>
                <th style="width: 70px;">Pilih</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($data as $index => $dt) : ?>
                <tr>
                    <td class="text-center"><?= $index + 1 ?></td>
                    <td><?= $dt->username ?></td>
                    <td><?= $dt->nama ?></td>
                    <td><?= $dt->cabang ?></td>
                    <td>
                        <span class="text-primary fw-600"><?= $dt->no_hp ?></span>
                        <br>
                        <?= $dt->email ?>
                    </td>
                    <td class="text-center">
                        <a class="btn btn-outline-primary" href="<?= base_url('super_admin/dashboard/do_pilih_role/') . encode_id($dt->id) ?>"><i class="fa fa-check"></i> Pilih</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<script>
    $(document).ready(function() {
        $('#tabel_show_data').DataTable();
    });
</script>