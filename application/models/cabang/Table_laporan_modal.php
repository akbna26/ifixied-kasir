<?php

class Table_laporan_modal extends CI_Model
{
    var $column_order = array(null); //field yang ada di table user
    var $column_search = array('keterangan', 'jenis_transaksi'); //field yang diizin untuk pencarian
    var $order = array('tanggal' => 'desc'); // default order

    public function __construct()
    {
        parent::__construct();
        $this->load->model('query_global');
    }

    private function _get_datatables_query()
    {
        $query = $this->query_global->modal();
        $filter_rekening = $this->input->get('filter_rekening');
        $filter_cabang = $this->input->get('filter_cabang');
        $filter_tanggal = $this->input->get('filter_tanggal');

        $this->db->select('tabel.*');
        $this->db->from("($query) as tabel");
        $this->db->join('ref_jenis_pembayaran b', 'b.id = tabel.id_pembayaran', 'left');

        if ($this->type == 'cabang') $this->db->where('id_cabang', $this->id_cabang);
        else {
            if ($filter_cabang != 'all') $this->db->where('id_cabang', $filter_cabang);
        }

        if ($filter_rekening != 'all') $this->db->where('b.nm_jenis', $filter_rekening);
        if ($filter_tanggal != '') $this->db->where('tanggal', $filter_tanggal);

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

            $jenis_transaksi = $field->jenis_transaksi;
            if (in_array($field->jenis_transaksi, ['PENJUALAN', 'PENJUALAN SPLIT', 'DP', 'REFUND DP', 'SERVIS IC', 'SERVIS IC SPLIT', 'REFUND SERVIS IC', 'REFUND PENJUALAN'])) {
                $jenis_transaksi .= '<div class="text-primary">Nama user : ' . $field->nama_user . '</div>'
                    . '<div class="text-primary">No HP : ' . $field->no_hp . '</div>';
            }

            $row[] = $jenis_transaksi;

            $row[] = rupiah($field->kredit);

            $row[] = rupiah($field->debit);
            $row[] = $field->jenis_pembayaran;

            $keterangan = $field->keterangan;
            if (in_array($field->jenis_transaksi, ['PENJUALAN'])) {
                $keterangan .= '<div class="text-primary">DP : ' . rupiah($field->dp) . '</div>'
                    . '<div class="text-primary">Tgl : ' . tgl_indo($field->tgl_dp) . '</div>';
            }
            $row[] = $keterangan;
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
