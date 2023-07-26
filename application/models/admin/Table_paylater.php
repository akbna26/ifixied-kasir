<?php

class Table_paylater extends CI_Model
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
        $select_tahun = $this->input->get('select_tahun');
        $select_bulan = $this->input->get('select_bulan');

        $this->db->select('a.*, b.nama as cabang, c.nama as pegawai');
        $this->db->from('transaksi a');
        $this->db->join('ref_cabang b', 'b.id = a.id_cabang', 'left');
        $this->db->join('pegawai c', 'c.id = a.id_pegawai', 'left');
        $this->db->where('a.deleted', null);
        $this->db->where('a.id_jenis_pembayaran', 10);


        if ($id_cabang != 'all') $this->db->where('a.id_cabang', $id_cabang);
        if ($select_tahun != 'all') $this->db->where('YEAR(a.created)', $select_tahun);
        if ($select_bulan != 'all') $this->db->where('MONTH(a.created)', $select_bulan);

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

            if ($field->verif_paylater == 1) {
                $status = '<span class="badge badge-soft-success font-size-12">Terverifikasi</span>';
                $btn_verif = '';
            } else {
                $status = '<span class="badge badge-soft-danger font-size-12">Belum Diverifikasi</span>';
                $btn_verif = '<button onclick="verif(\'' . encode_id($field->id) . '\')" class="btn btn-success btn-sm mt-1 fw-600"><i class="fa fa-check mr-1"></i> Verifikasi</button>';
            }

            $row[] = $no;
            $row[] = $field->created
                . '<br>Invoice : <span class="text-primary">' . $field->no_invoice . '</span>';
            $row[] = $field->cabang;
            $row[] = $field->pegawai;
            $row[] = rupiah($field->total);
            $row[] = $status;
            $row[] = rupiah($field->potongan);
            $row[] = '
                <button onclick="detail(\'' . encode_id($field->id) . '\');" type="button" class="btn btn-sm btn-primary mr-1 fw-600"><i class="fas fa-eye"></i> Detail</button>
            ' . $btn_verif;

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
