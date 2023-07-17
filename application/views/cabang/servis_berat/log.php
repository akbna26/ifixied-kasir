<div class="text-center">
    <div class="badge badge-primary">
        <h4 class="mb-0 text-white fw-600">STATUS PROGRES SERVIS</h4>
    </div>
</div>
<hr>

<ul class="verti-timeline list-unstyled">
    <?php foreach ($data as $i => $dt) : ?>
        <li class="event-list <?= count($data) == $i + 1 ? 'active' : '' ?>" style="padding: 0 0 30px 30px !important;">
            <div class="event-timeline-dot">
                <i class="bx bx-right-arrow-circle font-size-18 <?= count($data) == $i + 1 ? 'bx-fade-right' : '' ?>"></i>
            </div>
            <div class="media">
                <div class="mr-3">
                    <h5 class="font-size-14"><?= tgl_indo($dt->created, true) ?> <i class="bx bx-right-arrow-alt font-size-16 text-primary align-middle ml-2"></i></h5>
                </div>
                <div class="media-body">
                    <div class="fw-600">
                        <?= $dt->nm_status ?>
                    </div>
                    <?php if (!empty($dt->keterangan)) : ?>
                        <div class="text-danger">
                            <i class="bx bx-notepad mr-1"></i> <?= !empty($dt->keterangan) ? nl2br($dt->keterangan) : '-' ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </li>
    <?php endforeach; ?>
</ul>