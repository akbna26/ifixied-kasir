function formatRupiah(angka) {
    var number_string = angka.replace(/[^,\d]/g, '').toString(),
        split = number_string.split(','),
        sisa = split[0].length % 3,
        rupiah = split[0].substr(0, sisa),
        ribuan = split[0].substr(sisa).match(/\d{3}/gi);

    if (ribuan) {
        separator = sisa ? '.' : '';
        rupiah += separator + ribuan.join('.');
    }

    rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
    return rupiah;
}

$('body').on('keyup', '.rupiah', function() {
    $(this).val(formatRupiah(this.value));
});

function set_radio(dt, kelas) {
    $('.' + kelas).removeClass('active');
    $(dt).addClass('active');
}

function show_div(kelas, id) {
    $('.' + kelas).hide();
    $('#' + id).show();
}

$('.js_select2').select2({
    width: '100%'
});

function show_more(type, id) {
    if (type == 'full') {
        $('#full_' + id).hide()
        $('#less_' + id).show()
    } else {
        $('#full_' + id).show()
        $('#less_' + id).hide()
    }
}

function show_modal_custom(obj) {
    if (obj.judul.indexOf('class="fa') != -1) {
        var judul = obj.judul;
    } else {
        var judul = '<i class="fa fa-info-circle mr-2"></i>' + obj.judul;
    }

    $('#modal_custom .modal-title').html(judul);
    $('#modal_custom .modal-body').html(obj.html);
    $("#modal_custom_size").removeClass();
    $("#modal_custom_size").addClass('modal-dialog');
    $("#modal_custom_size").addClass(obj.size);
    $('#modal_custom').modal('show');
}

function show_modal_custom_2(obj) {
    if (obj.judul.indexOf('class="fa') != -1) {
        var judul = obj.judul;
    } else {
        var judul = '<i class="fa fa-info-circle mr-2"></i>' + obj.judul;
    }

    $('#modal_custom_2 .modal-title').html(judul);
    $('#modal_custom_2 .modal-body').html(obj.html);
    $("#modal_custom_size_2").removeClass();
    $("#modal_custom_size_2").addClass('modal-dialog');
    $("#modal_custom_size_2").addClass(obj.size);
    $('#modal_custom_2').modal('show');
}

function full_page(dt, id_target, type) {
    $(dt).hide();
    $('#' + id_target).show();

    if (type == 1) {
        $('#target_full_page').css({
            position: 'fixed',
            'z-index': 1000000000,
            top: 5,
            left: 5,
            width: '100%',
        });
    } else {
        $('#target_full_page').removeAttr("style");
    }

    //! how to use ? add this in html
    // <button id="btn_full_page" onclick="full_page(this,'btn_exit_page',1)" class="btn btn_page btn-outline-primary w-25 fw-600">Full Page</button>
    // <button id="btn_exit_page" style="display: none;" onclick="full_page(this,'btn_full_page',0)" class="btn btn_page btn-outline-primary w-25 fw-600">Exit Full Page</button>

}

function detail_gambar(dt) {
    var img = $(dt).attr('href');
    var html = `
        <img class="img rounded" style="width:100%;" src="${img}" />
    `;

    show_modal_custom({
        judul: 'Detail Gambar',
        html: html,
        size: 'modal-lg',
    });
}