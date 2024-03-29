<?php

class Table_operasional extends CI_Model
{
    var $column_order = array(null, 'judul', 'tanggal', 'keterangan', null); //field yang ada di table user
    var $column_search = array('a.keterangan'); //field yang diizin untuk pencarian
    var $order = array('a.id' => 'desc'); // default order

    public function __construct()
    {
        parent::__construct();
    }

    private function _get_datatables_query()
    {
        $id_cabang = decode_id($this->input->get('id_cabang'));
        $tgl_start = $this->input->get('tgl_start');
        $tgl_end = $this->input->get('tgl_end');

        $where = '';
        if (!empty($tgl_start)) $where .= "AND DATE(a.tanggal) >= '$tgl_start' ";
        if (!empty($tgl_end)) $where .= "AND DATE(a.tanggal) <= '$tgl_end' ";

        $this->db->select('a.*, b.nama as nm_operasional, c.nama as nm_pembayaran, d.nama as nm_cabang');
        $this->db->from('operasional a');
        $this->db->join('ref_operasional b', 'b.id = a.id_operasional', 'left');
        $this->db->join('ref_jenis_pembayaran c', 'c.id = a.id_pembayaran', 'left');
        $this->db->join('ref_cabang d', 'd.id = a.id_cabang', 'left');
        $this->db->where('a.deleted', null);
        $this->db->where("a.id_cabang='$id_cabang' $where ");

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
