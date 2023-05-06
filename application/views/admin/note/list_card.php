<?php foreach ($data as $i => $dt) : ?>
    <div class="col-md-4">
        <div class="card" style="background-color: <?= $dt->warna ?>;">
            <div class="card-body">
                <h4><?= $dt->judul ?></h4>
                <div class="m-1" style="position: absolute; top: 0;right: 0;">
                    <div class="dropdown">
                        <a href="#" class="dropdown-toggle card-drop" data-toggle="dropdown" aria-expanded="false">
                            <i class="mdi mdi-dots-horizontal font-size-18"></i>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-right">
                            <li><a href="#" onclick="event.preventDefault();edit_catatan('<?= encode_id($dt->id) ?>')" class="dropdown-item"><i class="mdi mdi-pencil font-size-16 text-success mr-1"></i> Edit</a></li>
                            <li><a href="#" onclick="event.preventDefault();hapus_catatan('<?= encode_id($dt->id) ?>','<?= $id_label ?>')" class="dropdown-item"><i class="mdi mdi-trash-can font-size-16 text-danger mr-1"></i> Delete</a></li>
                        </ul>
                    </div>
                </div>
                <div class="mt-2">
                    <?= nl2br($dt->catatan) ?>
                </div>
                <div class="mt-2">
                    <?php
                    $arr = explode(',', $dt->id_label);
                    foreach ($label as $val) :
                        if (in_array($val->id, $arr)) :
                    ?>
                            <span class="badge p-1" style="color:#000;border: 1px solid #000;background-color: <?= $val->warna ?>;"><?= $val->label ?></span>
                    <?php
                        endif;
                    endforeach;
                    ?>
                </div>
                <div>
                    <small><?= date('d-m-Y H:i', strtotime($dt->created)) ?></small>
                </div>
            </div>
        </div>
    </div>
<?php endforeach; ?>