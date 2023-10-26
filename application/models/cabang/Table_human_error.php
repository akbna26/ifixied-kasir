<?php

class Table_human_error extends CI_Model
{
    var $column_order = array(null, 'a.nama', 'b.nama', 'c.nama', null); //field yang ada di table user
    var $column_search = array('b.nm_barang'); //field yang diizin untuk pencarian
    var $order = array('a.id' => 'desc'); // default order

    public function __construct()
    {
        parent::__construct();
    }

    private function _get_datatables_query()
    {
        $this->db->select("a.*, 
        case when a.id_klaim=1 then 'HUMAN ERROR' else 'KLAIM SERVIS IC' end as status_klaim,
        case when a.id_klaim=1 then d.nama else CONCAT('OFFICE - ',e.nama) end as nm_pegawai,
        concat(b.barcode,' - ',b.nama) as nm_barang, b.harga_modal, c.nama as nm_cabang");
        $this->db->from('human_error a');
        $this->db->join('barang b', 'b.id = a.id_barang', 'left');
        $this->db->join('ref_cabang c ', 'c.id = a.id_cabang', 'left');
        $this->db->join('pegawai d ', 'd.id = a.id_pegawai', 'left');
        $this->db->join('pegawai e ', 'e.id = a.id_pegawai_office', 'left');
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
            $row[] = $field->nm_cabang;
            $row[] = $field->status_klaim;
            $row[] = $field->nm_pegawai;
            $row[] = $field->nm_barang;
            $row[] = tgl_indo($field->tanggal);
            $row[] = $field->keterangan;

            if (session('type') == 'admin') {
                // <button onclick="ubah(\'' . encode_id($field->id) . '\');" type="button" class="btn btn-sm btn-primary mr-1 fw-600"><i class="fas fa-edit"></i> Ubah</button>
                $aksi = '
                    <button onclick="hapus(\'' . encode_id($field->id) . '\');" type="button" class="btn btn-sm btn-danger mt-1 fw-600"><i class="fas fa-times"></i> Cancel</button>
                ';
            }else{
                $aksi = '<span class="text-danger">Jika terjadi kesalahan hubungi admin</span>';
            }

            $row[] = $aksi;

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
