<?php

class Table_mutasi_servis extends CI_Model
{
    var $column_order = array(null, 'judul', 'tanggal', 'keterangan', null); //field yang ada di table user
    var $column_search = array('nm_teknisi', 'tipe_unit'); //field yang diizin untuk pencarian
    var $order = array('id' => 'desc'); // default order

    public function __construct()
    {
        parent::__construct();
    }

    private function _get_datatables_query()
    {
        $id_cabang = decode_id($this->input->get('id_cabang'));
        $tgl_start = $this->input->get('tgl_start');
        $tgl_end = $this->input->get('tgl_end');

        $where = '';
        if (!empty($tgl_start)) $where .= "AND DATE(a.tgl_keluar) >= '$tgl_start' ";
        if (!empty($tgl_end)) $where .= "AND DATE(a.tgl_keluar) <= '$tgl_end' ";

        $query = "SELECT a.*, b.pelanggan, b.tipe_unit, b.kerusakan, d.nama as nm_teknisi, e.nama as nm_tindakan
        from profit_servis a 
        left join servis_berat b on b.id=a.id
        left join setting_pegawai c on c.id=b.id_teknisi_setting
        left join pegawai d on d.id=c.id_pegawai
        left join ref_tindakan e on e.id=b.id_tindakan
        where a.id_cabang='$id_cabang' $where ";

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
            $row[] = tgl_indo($field->tgl_keluar);
            $row[] = 'Pelanggan : ' . $field->pelanggan
                . '<div class="text-primary">Tipe Unit : ' . $field->tipe_unit .'<span class="text-danger"> (' . $field->kerusakan . ')</span></div>';
            $row[] = rupiah($field->biaya);
            $row[] = rupiah($field->modal);
            $row[] = rupiah($field->profit);
            $row[] = $field->nm_teknisi;
            $row[] = $field->nm_tindakan;

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
