<?php

class Table_retur_barang extends CI_Model
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
        $this->db->select('a.*, a.created as tanggal, concat(b.barcode," - ",b.nama) as nm_barang, c.no_invoice, 
        case when a.id_klaim=5 then f.nama else d.nama end as nm_cabang, e.nama as nm_klaim ', false);
        $this->db->from('refund_detail a');
        $this->db->join('refund aa', 'aa.id = a.id_refund', 'left');
        $this->db->join('barang b', 'b.id = a.id_barang', 'left');
        $this->db->join('transaksi c', 'c.id = aa.id_transaksi and c.deleted is null', 'left');
        $this->db->join('ref_cabang d ', 'd.id = aa.id_cabang', 'left');
        $this->db->join('ref_status_refund e ', 'e.id = a.id_klaim', 'left');
        $this->db->join('ref_cabang f ', 'f.id = a.id_cabang', 'left');
        $this->db->where_in('a.id_klaim', [1, 3, 5]);
        $this->db->where('a.deleted', null);
        $this->db->where('aa.deleted', null);
        if (session('type') == 'cabang') $this->db->where("(a.id_cabang = $this->id_cabang OR aa.id_cabang=$this->id_cabang )");

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
            $row[] = $field->nm_barang;
            $row[] = $field->qty;
            $row[] = tgl_indo($field->tanggal);
            $row[] = '<span class="text-primary fw-600">' . $field->no_invoice . '</span>';

            $retur = '';

            if (empty($field->status_retur)) $retur = '<span class="fw-600 text-primary">Belum diverifikasi</span>';
            elseif ($field->status_retur == 1) $retur = '<span class="fw-600 text-danger">Potong Profit</span>';
            elseif ($field->status_retur == 2) $retur = '<span class="fw-600 text-success">Disetujui</span>';

            $row[] = $field->nm_klaim;
            $row[] = $retur;

            $aksi = '';

            if (empty($field->status_retur) && session('type') == 'cabang' && $field->id_klaim == 5) {
                $aksi .= '
                    <button onclick="detail(\'' . encode_id($field->id) . '\');" type="button" class="btn btn-sm btn-warning mr-1 fw-600"><i class="fas fa-eye"></i> Detail</button>
                    <button onclick="ubah(\'' . encode_id($field->id) . '\');" type="button" class="btn btn-sm btn-primary mr-1 fw-600"><i class="fas fa-edit"></i> Ubah</button>
                    <button onclick="hapus(\'' . encode_id($field->id) . '\');" type="button" class="btn btn-sm btn-danger mt-1 fw-600"><i class="fas fa-trash-alt"></i> Hapus</button>
                ';
            }

            if (session('type') == 'gudang' && empty($field->status_retur)) $aksi .= '<button onclick="verifikasi(\'' . encode_id($field->id) . '\');" type="button" class="btn btn-sm btn-success fw-600"><i class="fas fa-check"></i> Verifikasi</button>';
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
