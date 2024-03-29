<?php

class Table_mutasi extends CI_Model
{
    var $column_order = array(null, 'judul', 'tanggal', 'keterangan', null); //field yang ada di table user
    var $column_search = array('jenis', 'keterangan'); //field yang diizin untuk pencarian
    var $order = array('id' => 'desc'); // default order

    public function __construct()
    {
        parent::__construct();
    }

    private function _get_datatables_query()
    {
        $tanggal = $this->input->get('tanggal');

        $where = '';
        if (!empty($tanggal)) $where .= "AND DATE(created)='$tanggal' ";

        $query = "SELECT * from profit a where a.id_cabang='$this->id_cabang' $where ";
        $this->db->from("($query) as tabel");

        $i = 0;

        foreach ($this->column_search as $item) { // looping awal
            if ($_GET['search']['value']) { // jika datatable mengirimkan pencarian dengan metode POST

                if ($i === 0) // looping awal
                {
                    $this->db->group_start();
                    $this->db->like('LOWER(' . $item . ')', strtolower($_GET['search']['value']));
                } else {
                    $this->db->or_like('LOWER(' . $item . ')', strtolower($_GET['search']['value']));
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

            $metode = '<div>' . $field->nm_jenis_bayar_1 . '(' . $field->prosen_split_1 . '%)</div>';
            if (!empty($field->nm_jenis_bayar_2)) $metode .= '<div class="text-primary">Split ' . $field->nm_jenis_bayar_2 . '(' . $field->prosen_split_2 . '%)</div>';

            $row[] = $no;
            $row[] = tgl_indo($field->created, true);
            $row[] = $field->nm_barang;
            // $row[] = rupiah($field->harga_modal);
            $row[] = rupiah($field->harga);
            $row[] = $field->qty;
            $row[] = rupiah($field->sub_total);
            // $row[] = rupiah($field->total_profit);
            $row[] = $metode;

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
