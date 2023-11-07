<?php

class Table_kasir_dp extends CI_Model
{
    var $column_order = array(null); //field yang ada di table user
    var $column_search = array('a.nama', 'a.kode'); //field yang diizin untuk pencarian
    var $order = array('a.id' => 'desc'); // default order

    public function __construct()
    {
        parent::__construct();
    }

    private function _get_datatables_query()
    {
        $this->db->select('a.*, a.tgl_refund, b.nama as nm_pembayaran, c.inv_dp, d.nama as nm_cabang');
        $this->db->from('dp a');
        $this->db->join('ref_jenis_pembayaran b', 'b.id = a.pembayaran', 'left');
        $this->db->join('(select inv_dp from transaksi where deleted is null group by inv_dp) c', 'c.inv_dp = a.kode', 'left');
        $this->db->join('ref_cabang d', 'd.id = a.id_cabang', 'left');


        // $this->db->where('a.deleted', null);
        if (session('type') == 'cabang') $this->db->where('a.id_cabang', $this->id_cabang);

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
            $row[] = $field->nm_cabang;
            $row[] = nl2br($field->keterangan);
            $row[] = $field->nm_pembayaran . ' (' . $field->potongan . '%)';
            $row[] = rupiah($field->total);
            $row[] = tgl_indo($field->tanggal);
            $row[] = $field->kode;
            $row[] = '<a href="' . base_url($this->type . '/cetak/nota_dp/' . encode_id($field->id)) . '" target="_blank" class="btn btn-sm btn-success fw-600"><i class="fas fa-print"></i> Cetak</a>';
            $row[] = tgl_indo($field->tgl_refund);
            if ($field->inv_dp != '') {
                $row[] = '<div class="text-info">Sudah selesai transaksi</div>';
            } elseif ($field->is_refund == '1') {
                $row[] = '<div class="badge badge-info">Refund Berhasil</div>';
            } else {
                if (session('type') == 'accounting' && $field->is_cancel != '1') {
                    $row[] = '<button onclick="form_refund(\'' . encode_id($field->id) . '\');" type="button" class="btn btn-sm btn-info mr-1 fw-600"><i class="fas fa-sync"></i> Refund</button>';
                } else {
                    $row[] = '-';
                }
            }

            if ($field->deleted == null) {
                $aksi = '';
                if ($field->is_selesai == '1' && $field->inv_dp != '' || $field->is_refund == '1') {
                    $row[] = '<span class="text-success fw-600 mr-2"><i class="fa fa-check"></i> Selesai</span>';
                } elseif ($field->is_selesai == '1' && $field->inv_dp == '') {
                    $row[] = '<span class="text-warning mr-2"><i class="fa fa-check"></i> Dikonfirmasi admin</span>';
                } elseif (session('type') == 'cabang' && $field->is_selesai != '1' && $field->inv_dp == '') {
                    $row[] = '<span class="text-warning mr-2"><i class="fa fa-info-circle"></i> Menunggu konfirmasi admin</span>';
                } else {
                    if (session('type') == 'accounting' && $field->is_selesai != 1) {
                        $aksi .= '<button onclick="konfirmasi(\'' . encode_id($field->id) . '\');" type="button" class="btn btn-sm btn-warning mr-1 fw-600"><i class="fas fa-edit"></i> Konfirmasi</button>';
                    }

                    if (session('type') == 'accounting' && $field->inv_dp == '') {
                        if (date('Y-m-d') == date('Y-m-d', strtotime($field->tanggal))) {
                            $aksi .= '<button onclick="cancel(\'' . encode_id($field->id) . '\');" type="button" class="btn btn-sm btn-danger mr-1 fw-600"><i class="fas fa-times"></i> Cancel</button>';
                        }
                    }
                    $row[] = $aksi;
                }
            } else {
                $row[] = '<div class="text-danger">Dicancel oleh admin</div>';
            }

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
