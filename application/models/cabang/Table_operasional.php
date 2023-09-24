<?php

class Table_operasional extends CI_Model
{
    var $column_order = array(null, 'judul', 'tanggal', 'keterangan', null); //field yang ada di table user
    var $column_search = array('a.keterangan'); //field yang diizin untuk pencarian
    var $order = array('id' => 'desc'); // default order

    public function __construct()
    {
        parent::__construct();
    }

    private function _get_datatables_query()
    {
        $this->db->select('a.*, b.nama as nm_operasional, c.nama as nm_pembayaran, d.nama as nm_cabang');
        $this->db->from('operasional a');
        $this->db->join('ref_operasional b', 'b.id = a.id_operasional', 'left');
        $this->db->join('ref_jenis_pembayaran c', 'c.id = a.id_pembayaran', 'left');
        $this->db->join('ref_cabang d', 'd.id = a.id_cabang', 'left');
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

            $operasional = $field->nm_operasional
                . '<div class="text-danger fw-600">Sumber Dana : ' . $field->nm_pembayaran . '</div>';

            $row[] = $no;
            $row[] = $field->nm_cabang;
            $row[] = $operasional;
            $row[] = tgl_indo($field->tanggal);
            $row[] = rupiah($field->jumlah);
            $row[] = $field->keterangan;

            if (session('type') == 'cabang') {
                $row[] = '
                    <button onclick="ubah(\'' . encode_id($field->id) . '\');" type="button" class="btn btn-sm btn-primary mr-1 fw-600"><i class="fas fa-edit"></i> Ubah</button>
                    <button onclick="hapus(\'' . encode_id($field->id) . '\');" type="button" class="btn btn-sm btn-danger fw-600"><i class="fas fa-trash-alt"></i> Hapus</button>
                ';
            } else {
                $row[] = '-';
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
