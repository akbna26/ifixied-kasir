<style>
    .min_600 {
        min-height: 500px !important;
    }
</style>
<div class="row">
    <div class="col-md-4">
        <div class="card">
            <div class="card-body bg1 br-atas p-3 mb-0">
                <h3 class="fw-600 mb-0 text1"><i class="fa fa-info-circle mr-1"></i> INFO</h3>
            </div>
            <div class="card-body min_600">

                <div style="height: 250px;" class="text-center">
                    <img style="width: 255px;" class="img img-fluid rounded rounded-circle foto shadow1" src="<?= base_url($data->foto) ?>" alt="foto user">
                </div>

                <table class="mt-3 table table-striped">
                    <tr>
                        <td>Nama</td>
                        <th><?= $data->nama ?></th>
                    </tr>
                    <tr>
                        <td>Username</td>
                        <th><?= $data->username ?></th>
                    </tr>
                    <tr>
                        <td>Email</td>
                        <th><?= $data->email ?></th>
                    </tr>
                    <tr>
                        <td>Cabang</td>
                        <th><?= $data->cabang ?></th>
                    </tr>
                </table>
            </div>
        </div>
    </div>
    <div class="col-md-8">
        <div class="card">
            <div class="card-body bg1 br-atas p-3 mb-0">
                <h3 class="fw-600 text1 mb-0"><i class="fa fa-info-circle mr-1"></i> PROFILE</h3>
            </div>
            <div class="card-body min_600">
                <table class="table table-striped">
                    <tr>
                        <td>Nomer HP</td>
                        <th><?= $data->no_hp ?></th>
                    </tr>
                    <tr>
                        <td>Provinsi</td>
                        <th><?= $data->nama_prov ?></th>
                    </tr>
                    <tr>
                        <td>Kabupaten</td>
                        <th><?= $data->nama_kab ?></th>
                    </tr>
                    <tr>
                        <td>Kecamatan</td>
                        <th><?= $data->nama_kec ?></th>
                    </tr>
                    <tr>
                        <td>Kelurahan</td>
                        <th><?= $data->nama_kel ?></th>
                    </tr>
                    <tr>
                        <td>Alamat</td>
                        <th><?= nl2br($data->alamat) ?></th>
                    </tr>
                    <tr>
                        <td colspan="2">
                            <a href="<?= base_url('global/profil/edit') ?>" class="btn btn-outline-primary active btn-rounded btn-block fw-600"><i class="fas fa-edit"></i> Klik disini untuk mengubah profil</a>
                        </td>
                    </tr>

                </table>
            </div>
        </div>
    </div>
</div>