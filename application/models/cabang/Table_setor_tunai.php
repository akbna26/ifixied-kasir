<?php

class Table_setor_tunai extends CI_Model
{
    var $column_order = array(null, 'judul', 'tanggal', 'keterangan', null); //field yang ada di table user
    var $column_search = array('nm_pegawai', 'keterangan'); //field yang diizin untuk pencarian
    var $order = array('id' => 'desc'); // default order

    public function __construct()
    {
        parent::__construct();
    }

    private function _get_datatables_query()
    {
        $where = '';
        if ($this->type == 'cabang') $where .= "AND a.id_cabang='$this->id_cabang'";

        $query = "SELECT a.*, b.nama as nm_pembayaran, c.nama as nm_cabang 
        from setor_tunai a 
        left join ref_jenis_pembayaran b on b.id=a.id_pembayaran
        left join ref_cabang c on c.id=a.id_cabang
        where 1=1 $where ";
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

            $row[] = $no;
            $row[] = $field->nm_cabang;
            $row[] = $field->nm_pembayaran;
            $row[] = tgl_indo($field->tanggal);
            $row[] = rupiah($field->nominal);
            $row[] = $field->keterangan;

            if ($field->deleted != null) {
                $row[] = '<div class="text-danger">cancel</div>';
            } elseif ($field->is_konfirmasi == 0) {
                if (session('type') == 'accounting') {
                    $row[] = '<button onclick="konfirmasi(\'' . encode_id($field->id) . '\');" type="button" class="btn btn-sm btn-success mr-1 fw-600"><i class="fas fa-check"></i> Konfirmasi</button>';
                } else {
                    $row[] = '<div class="text-danger">Belum dikonfirmasi</div>';
                }
            } else {
                $row[] = '<div class="text-success fw-600">Sudah dikonfirmasi</div>';
            }


            if ($field->deleted != null) {
                $row[] = '<div class="text-danger">dicancel oleh admin</div>';
            } elseif ($field->is_konfirmasi == 0) {
                if (session('type') == 'accounting') {
                    $row[] = '<button onclick="hapus(\'' . encode_id($field->id) . '\');" type="button" class="btn btn-sm btn-danger fw-600"><i class="fas fa-times"></i> Cancel</button>';
                } else {
                    $row[] = '<div class="text-info">jika terjadi kesalahan hubungi admin</div>';
                }
            } else {
                $row[] = '<div class="badge badge-soft-success">Final</div>';
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
