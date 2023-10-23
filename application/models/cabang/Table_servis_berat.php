<?php

class Table_servis_berat extends CI_Model
{
    var $column_order = array(null, 'judul', 'tanggal', 'keterangan', null); //field yang ada di table user
    var $column_search = array('a.invoice', 'a.pelanggan', 'a.no_hp', 'a.imei'); //field yang diizin untuk pencarian
    var $order = array('id' => 'desc'); // default order

    public function __construct()
    {
        parent::__construct();
    }

    private function _get_datatables_query()
    {
        $id_status = $this->input->get('id_status');
        $kode = decode_id($this->input->get('kode'));

        $this->db->select('a.*, b.nama as nm_status, ifnull(c.nama,"-") as nm_tindakan, ifnull(f.nama,"-") as nm_teknisi, 
        e.nama as nm_cabang, g.nama as nm_pengambilan, DATEDIFF(NOW(),tgl_keluar) AS jarak_hari');
        $this->db->from('servis_berat a');
        $this->db->join('ref_status_servis b', 'b.id = a.status', 'left');
        $this->db->join('ref_tindakan c', 'c.id = a.id_tindakan', 'left');
        $this->db->join('setting_pegawai d', 'd.id = a.id_teknisi_setting', 'left');
        $this->db->join('pegawai f', 'f.id = d.id_pegawai', 'left');
        $this->db->join('ref_cabang e', 'e.id = a.id_cabang', 'left');
        $this->db->join('ref_pengambilan g', 'g.id = a.id_pengambilan', 'left');

        $this->db->where('a.deleted', null);
        if ($id_status != 'all') $this->db->where('a.status in (' . $id_status . ') ');

        if (session('type') == 'cabang') $this->db->where('a.id_cabang', $this->id_cabang);
        if (session('type') == 'servis') $this->db->where('a.id_cabang', $kode);

        $i = 0;

        foreach ($this->column_search as $item) { // looping awal
            if ($_GET['search']['value']) { // jika datatable mengirimkan pencarian dengan metode POST

                if ($i === 0) // looping awal
                {
                    $this->db->group_start();
                    $this->db->like($item, $_GET['search']['value']);
                } else {
                    $this->db->or_like($item, $_GET['search']['value']);
                }

                if (count($this->column_search) - 1 == $i)
                    $this->db->group_end();
            }
            $i++;
        }

        if (isset($_GET['order'])) {
            $this->db->order_by($this->column_order[$_GET['order']['0']['column']], $_GET['order']['0']['dir']);
        } else if (isset($this->order)) {
            $order = $this->order;
            $this->db->order_by(key($order), $order[key($order)]);
        }
    }

    function get_datatables()
    {
        $this->_get_datatables_query();
        if ($_GET['length'] != -1)
            $this->db->limit($_GET['length'], $_GET['start']);
        $query = $this->db->get();
        return $query->result();
    }

    function count_filtered()
    {
        $this->_get_datatables_query();
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function count_all()
    {
        $this->_get_datatables_query();
        return $this->db->count_all_results();
    }

    function generate_table()
    {
        $list = $this->get_datatables();
        $data = array();
        $no = $_GET['start'];

        foreach ($list as $field) {
            $no++;
            $row = [];

            $row[] = $no;
            $row[] = $field->pelanggan
                . '<div class="text-primary">inv : ' . ($field->invoice ?? '-') . '</div>';

            $row[] =
                '<div class="fw-600 text-primary"><i class="fas fa-map-marker-alt mr-1"></i> ' . $field->nm_cabang . '</div>'
                . '<div><i class="fa fa-calendar mr-1"></i> Tgl Masuk : ' . tgl_indo($field->tgl_masuk) . '</div>'
                . '<div><i class="fa fa-calendar mr-1"></i> Tgl Keluar : ' . (!empty($field->tgl_keluar) ? tgl_indo($field->tgl_keluar) : '-') . '</div>';

            $row[] = 'Tipe : ' . $field->tipe_unit
                . '<div>Diagnosa : ' . $field->diagnosa . '</div>'
                . '<div class="text-danger fw-600">Biaya : ' . (!empty($field->biaya) ? rupiah($field->biaya) : '-') . '</div>';

            $informasi = '<div><i class="fa fa-wrench mr-1"></i> Tindakan : ' . $field->nm_tindakan . '</div>';
            if (in_array(session('type'), ['admin', 'servis'])) $informasi .= '<div><i class="fa fa-user mr-1"></i> Teknisi : ' . $field->nm_teknisi . '</div>';

            if ($field->status == 9 && $field->id_pengambilan == 4) {
                if ($field->jarak_hari > 30) {
                    $informasi .= '<span class="badge badge-pill badge-soft-danger font-size-12">Garansi Habis (' . ($field->jarak_hari) . ' Hari)</span>';
                    $is_garansi = false;
                } else {
                    $informasi .= '<span class="badge badge-pill badge-soft-success font-size-12">Sisa Garansi ' . (30 - $field->jarak_hari) . ' Hari</span>';
                    $is_garansi = true;
                }
            }

            $row[] = $informasi;

            if (in_array($field->status, [9])) {
                $warna = 'success';
            } elseif (in_array($field->status, [5])) {
                $warna = 'primary';
            } elseif (in_array($field->status, [7, 8])) {
                $warna = 'danger';
            } else {
                $warna = 'warning';
            }

            $is_klaim_garansi = '';
            if ($field->is_klaim_garansi == 1) $is_klaim_garansi = '<br><span class="badge badge-primary fw-600 font-size-12">Proses Klaim Garansi</span>';
            elseif ($field->is_klaim_garansi == 2) $is_klaim_garansi = '<br><span class="badge badge-primary fw-600 font-size-12">Klaim Garansi Selesai</span>';

            $refund = '';
            if ($field->is_refund == 1) $refund = '<br><span class="badge badge-info fw-600 font-size-12">KLAIM REFUND</span>';

            $row[] = '<span class="badge badge-' . $warna . ' fw-600 font-size-12">' . $field->nm_status . '</span>'
                . '<br><span class="badge badge-dark fw-600 font-size-12">' . $field->nm_pengambilan . '</span>'
                . $refund
                . $is_klaim_garansi;

            $aksi = '
                <button onclick="ubah(\'' . encode_id($field->id) . '\');" type="button" class="btn btn-sm btn-primary mr-1 fw-600"><i class="fas fa-edit mr-1"></i> Ubah</button>
                <button onclick="hapus(\'' . encode_id($field->id) . '\');" type="button" class="btn btn-sm btn-danger fw-600"><i class="fas fa-trash-alt mr-1"></i> Hapus</button>
            ';

            if ($field->status != 1 || in_array(session('type'), ['admin', 'servis'])) $aksi = '';

            $aksi .= '<button onclick="detail(\'' . encode_id($field->id) . '\');" type="button" class="btn btn-sm btn-success fw-600 mt-1"><i class="fas fa-eye mr-1"></i> Detail</button>';

            if (in_array($field->status, [9]) && $field->id_pengambilan == 2 && session('type') == 'cabang') {
                $aksi .= '<button onclick="barangTiba(\'' . encode_id($field->id) . '\');" type="button" class="btn btn-sm btn-warning fw-600 mt-1"><i class="fas fa-car mr-1"></i> Barang Tiba</button>';
            }

            if (in_array($field->status, [7, 8, 9]) && $field->id_pengambilan == 3 && $field->is_klaim_garansi == 0 && session('type') == 'cabang') {
                $aksi .= '<button onclick="bayar(\'' . encode_id($field->id) . '\');" type="button" class="btn btn-sm btn-primary fw-600 mt-1"><i class="fas fa-money-check-alt mr-1"></i> Payment</button>';
            }

            if (in_array(session('type'), ['admin', 'servis']) && !in_array($field->status, [7, 8, 9])) {
                $aksi .= '<button onclick="konfirmasi(\'' . encode_id($field->id) . '\');" type="button" class="btn btn-sm btn-primary fw-600 mt-1"><i class="fas fa-gavel mr-1"></i> Konfirmasi</button>';
            }

            if (session('type') == 'cabang' && in_array($field->status, [9]) && $field->id_pengambilan == 4 && $is_garansi && $field->is_refund != 1) {
                $aksi .= '<button onclick="klaim_garansi(\'' . encode_id($field->id) . '\');" type="button" class="btn btn-sm btn-danger fw-600 mt-1"><i class="fas fa-sync-alt mr-1"></i> Klaim Garansi</button>';
                $aksi .= '<button onclick="klaim_refund(\'' . encode_id($field->id) . '\');" type="button" class="btn btn-sm btn-info fw-600 mt-1"><i class="fas fa-undo mr-1"></i> Refund</button>';
            }

            $aksi .= '<button onclick="log(\'' . encode_id($field->id) . '\');" type="button" class="btn btn-sm btn-dark fw-600 ml-1 mt-1"><i class="far fa-list-alt mr-1"></i> Log</button>';

            if (in_array(session('type'), ['admin', 'servis'])) {
                $aksi .= '<button onclick="cancelTransaksi(\'' . encode_id($field->id) . '\',\'' . $field->invoice . '\');" type="button" class="btn btn-sm btn-danger mr-1 fw-600"><i class="fas fa-times"></i> Cancel</button>';
            }

            $row[] = $aksi;

            $data[] = $row;
        }

        $output = array(
            "draw" => $_GET['draw'],
            "recordsTotal" => $this->count_all(),
            "recordsFiltered" => $this->count_filtered(),
            "data" => $data,
        );
        return json_encode($output);
    }
}
