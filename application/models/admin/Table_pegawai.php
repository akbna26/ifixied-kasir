<?php

class Table_pegawai extends CI_Model
{
    var $column_order = array(null, 'a.nama', 'b.nama', 'c.nama', null); //field yang ada di table user
    var $column_search = array('a.nama'); //field yang diizin untuk pencarian
    var $order = array('a.id' => 'desc'); // default order

    public function __construct()
    {
        parent::__construct();
    }

    private function _get_datatables_query()
    {

        $id_cabang = $this->input->get('id_cabang');
        $id_jabatan = $this->input->get('id_jabatan');

        $this->db->select('a.*, b.nama as cabang, b.lokasi, c.nama as jabatan');
        $this->db->from('pegawai a');
        $this->db->join('ref_cabang b', 'b.id = a.id_cabang', 'left');
        $this->db->join('ref_jabatan c', 'c.id = a.id_jabatan', 'left');
        $this->db->where('a.deleted', null);
        
        if($id_cabang != 'all') $this->db->where('a.id_cabang', $id_cabang);
        if($id_jabatan != 'all') $this->db->where('a.id_jabatan', $id_jabatan);        

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
            $row[] = $field->nama;
            $row[] = $field->cabang
                . '<span class="d-block text-primary">' . $field->lokasi . '</span>';
            $row[] = $field->jabatan;
            $row[] = '
                <button onclick="ubah(\'' . encode_id($field->id) . '\');" type="button" class="btn btn-sm btn-primary mr-1 fw-600"><i class="fas fa-edit"></i> Ubah</button>
                <button onclick="hapus(\'' . encode_id($field->id) . '\');" type="button" class="btn btn-sm btn-danger fw-600"><i class="fas fa-trash-alt"></i> Hapus</button>
            ';

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
