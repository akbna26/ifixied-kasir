<?php

class Table_barang_sharing extends CI_Model
{
    var $column_order = array(null, 'b.nama', 'a.tanggal', 'c.total', 'a.is_konfirmasi', null); //field yang ada di table user
    var $column_search = array('b.nama'); //field yang diizin untuk pencarian
    var $order = array('a.id' => 'desc'); // default order

    public function __construct()
    {
        parent::__construct();
    }

    private function _get_datatables_query()
    {
        $this->db->select('a.*, b.nama as cabang, b.lokasi, c.total, c.modal');
        $this->db->from('sharing a');
        $this->db->join('ref_cabang b', 'b.id = a.id_cabang', 'left');
        $this->db->join('(select a.id_sharing, count(1) as total, sum(a.stock * b.harga_modal) as modal
            from sharing_detail a
            left join barang b on b.id=a.id_barang and b.deleted is null
        where a.deleted is null group by a.id_sharing) c', 'c.id_sharing = a.id', 'left');
        $this->db->where('a.deleted', null);

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
            $row[] = $field->cabang
                . '<span class="d-block text-primary">' . $field->lokasi . '</span>';

            $row[] = tgl_indo($field->tanggal);
            $row[] = $field->total ?? 0;
            $row[] = rupiah($field->modal) ?? 0;

            if ($field->is_konfirmasi == '1') {
                $row[] = '<span class="badge badge-success">Sudah dikonfirmasi</span>';
                $row[] = '
                    <div class="btn-group">
                        <a href="' . base_url($this->type . '/barang_sharing_detail/index/' . encode_id($field->id)) . '" data-toggle="tooltip" data-placement="top" title="detail barang" class="btn btn-success fw-600"><i class="far fa-list-alt"></i></a>
                    </div>
                ';
            } else {
                $row[] = '<button onclick="konfirmasi(\'' . encode_id($field->id) . '\');" type="button" class="btn btn-sm btn-outline-warning fw-600"><i class="fas fa-check"></i> Konfirmasi sharing</button>';
                $row[] = '                    
                    <div class="btn-group">
                        <a href="' . base_url($this->type . '/barang_sharing_detail/index/' . encode_id($field->id)) . '" data-toggle="tooltip" data-placement="top" title="detail barang" class="btn btn-warning fw-600"><i class="far fa-list-alt"></i></a>
                        <button onclick="ubah(\'' . encode_id($field->id) . '\');" type="button" data-toggle="tooltip" data-placement="top" title="edit sharing" class="btn btn-primary fw-600"><i class="fas fa-edit"></i></button>
                        <button onclick="hapus(\'' . encode_id($field->id) . '\');" type="button" data-toggle="tooltip" data-placement="top" title="hapus sharing" class="btn btn-danger fw-600"><i class="fas fa-trash-alt"></i></button>
                    </div>
                ';
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
