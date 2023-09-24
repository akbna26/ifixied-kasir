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
        $this->db->select('a.*, b.nama as nm_pembayaran');
        $this->db->from('dp a');
        $this->db->join('ref_jenis_pembayaran b', 'b.id = a.pembayaran', 'left');

        $this->db->where('a.deleted', null);
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
            $row[] = nl2br($field->keterangan);
            $row[] = $field->nm_pembayaran . ' (' . $field->potongan . '%)';
            $row[] = rupiah($field->total);
            $row[] = tgl_indo($field->tanggal);
            $row[] = $field->kode;

            if (session('type') == 'cabang') {
                if ($field->is_selesai != '1') {
                    $row[] = '
                        <button onclick="ubah(\'' . encode_id($field->id) . '\');" type="button" class="btn btn-sm btn-primary mr-1 fw-600"><i class="fas fa-edit"></i> Ubah</button>
                        <a href="' . base_url('cabang/cetak/nota_dp/' . encode_id($field->id)) . '" target="_blank" class="btn btn-sm btn-success fw-600"><i class="fas fa-print"></i> Cetak</a>
                    ';
                } else {
                    $row[] = '
                        <a href="' . base_url('cabang/cetak/nota_dp/' . encode_id($field->id)) . '" target="_blank" class="btn btn-sm btn-success fw-600"><i class="fas fa-print"></i> Cetak</a>
                    ';
                }
            } else {
                if (session('type') == 'admin' && $field->is_selesai == '1') {
                    $row[] = 'selesai';
                } else {
                    $row[] = '
                        <button onclick="cancel(\'' . encode_id($field->id) . '\');" type="button" class="btn btn-sm btn-danger mr-1 fw-600"><i class="fas fa-times"></i> Cancel</button>
                        <button onclick="konfirmasi(\'' . encode_id($field->id) . '\');" type="button" class="btn btn-sm btn-warning mr-1 fw-600"><i class="fas fa-edit"></i> Konfirmasi</button>
                    ';
                }
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
