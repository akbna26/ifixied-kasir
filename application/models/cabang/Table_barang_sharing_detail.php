<?php

class Table_barang_sharing_detail extends CI_Model
{
    var $column_order = array(null, 'c.nama', 'b.nama', 'a.stock', null); //field yang ada di table user
    var $column_search = array('b.nama', 'b.barcode', 'c.nama'); //field yang diizin untuk pencarian
    var $order = array('a.id' => 'desc'); // default order

    public function __construct()
    {
        parent::__construct();
    }

    private function _get_datatables_query()
    {
        $id_sharing = decode_id($this->input->get('id_sharing'));

        $this->db->select('a.*, b.nama as barang, b.barcode, c.nama as kategori, d.is_konfirmasi, (a.stock * b.harga_modal) as modal');
        $this->db->from('sharing_detail a');
        $this->db->join('barang b', 'b.id = a.id_barang and b.deleted is null', 'left');
        $this->db->join('ref_kategori c', 'c.id = b.id_kategori', 'left');
        $this->db->join('sharing d', 'd.id = a.id_sharing', 'left');        
        $this->db->where('a.deleted', null);
        $this->db->where('a.id_sharing', $id_sharing);

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
            $row[] = $field->kategori;
            $row[] = $field->barang
                . '<span class="d-block text-primary fw-600">' . $field->barcode . '</span>';
            $row[] = rupiah($field->stock);

            if ($field->is_konfirmasi == 0) {
                $row[] = '
                    <button onclick="ubah(\'' . encode_id($field->id) . '\');" type="button" class="btn btn-sm btn-primary mr-1 fw-600"><i class="fas fa-edit"></i> Ubah</button>
                    <button onclick="hapus(\'' . encode_id($field->id) . '\');" type="button" class="btn btn-sm btn-danger fw-600"><i class="fas fa-trash-alt"></i> Hapus</button>
                ';
            } else {
                $row[] = '<span class="text-danger">sudah dikonfirmasi</span>';
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
