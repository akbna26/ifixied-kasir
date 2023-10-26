<?php

class Table_kerugian extends CI_Model
{
    var $column_order = array(null, 'judul', 'tanggal', 'keterangan', null); //field yang ada di table user
    var $column_search = array('keterangan'); //field yang diizin untuk pencarian
    var $order = array('tanggal' => 'desc'); // default order

    public function __construct()
    {
        parent::__construct();
        $this->load->model('query_global');        
    }

    private function _get_datatables_query()
    {
        $id_cabang = decode_id($this->input->get('id_cabang'));
        $tanggal = $this->input->get('tanggal');

        $where = '';
        if (!empty($tanggal)) {
            $bulan = date('m',strtotime($tanggal));
            $tahun = date('Y',strtotime($tanggal));
            $where .= "AND MONTH(a.tanggal)='$bulan' AND YEAR(a.tanggal)='$tahun' ";
        }

        $query = $this->query_global->data_kerugian();

        $query = "SELECT a.*, b.nama as nm_cabang from ($query) a 
            left join ref_cabang b on b.id=a.id_cabang
            where a.id_cabang='$id_cabang' $where 
        ";
        $this->db->from("($query) as tabel");

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
            $row[] = tgl_indo($field->tanggal);
            $row[] = strtoupper(str_replace('_',' ',$field->jenis));
            $row[] = $field->keterangan;
            $row[] = rupiah($field->jumlah);
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
