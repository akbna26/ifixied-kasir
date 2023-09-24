<?php

class Table_laporan_refund extends CI_Model
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
        $select_tahun = $this->input->get('select_tahun');
        $select_bulan = $this->input->get('select_bulan');
        $select_cabang = $this->input->get('select_cabang');

        $this->db->select('a.*, b.total, b.nm_barang, c.no_invoice, d.nama as nm_cabang');
        $this->db->from('refund a');
        $this->db->join('(select a.id_refund, count(1) as total, group_concat(b.nama separator "<br>") as nm_barang from refund_detail a 
        left join barang b on b.id=a.id_barang
        where a.deleted is null group by a.id_refund) b', 'b.id_refund = a.id', 'left');
        $this->db->join('transaksi c', 'c.id = a.id_transaksi', 'left');
        $this->db->join('ref_cabang d', 'd.id = a.id_cabang', 'left');
        
        $this->db->where('a.deleted', null);
        if (session('type') == 'cabang') $this->db->where('a.id_cabang', $this->id_cabang);

        if ($select_tahun != 'all') $this->db->where('YEAR(a.created)', $select_tahun);
        if ($select_bulan != 'all') $this->db->where('MONTH(a.created)', $select_bulan);
        if (!empty($select_cabang) && $select_cabang != 'all') $this->db->where('a.id_cabang', $select_cabang);

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
            $row[] = '<span class="text-primary fw-600">' . $field->no_invoice . '</span>';
            $row[] = $field->total;
            $row[] = $field->nm_barang;

            $row[] = '
                <button onclick="detail(\'' . encode_id($field->id) . '\');" type="button" class="btn btn-sm btn-primary mr-1 fw-600"><i class="fas fa-eye"></i> Detail</button>
                <a href="' . base_url('cabang/cetak/nota_refund/' . encode_id($field->id)) . '" target="_blank" class="btn btn-sm btn-success fw-600"><i class="fas fa-print"></i> Cetak</a>
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
