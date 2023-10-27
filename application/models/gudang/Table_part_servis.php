<?php

class Table_part_servis extends CI_Model
{
    var $column_order = array(null, 'judul', 'tanggal', 'keterangan', null); //field yang ada di table user
    var $column_search = array('barcode'); //field yang diizin untuk pencarian
    var $order = array('tgl_refund' => 'desc'); // default order

    public function __construct()
    {
        parent::__construct();
    }

    private function _get_datatables_query()
    {
        $query = "SELECT b.*, a.tgl_refund, aa.nama as nm_cabang, c.barcode, c.nama as nm_barang
            FROM servis_berat a
            left join ref_cabang aa on aa.id=a.id_cabang
            left join servis_detail_part b on b.id_servis=a.id
            left join barang c on c.id=b.id_barang
            where a.deleted is null and a.is_refund='1' and b.id is not null
        ";
        $this->db->from("($query) a");

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

            if ($field->verif_refund == null) {
                $status = '<div class="text-warning">Belum diverifikasi<div>';
                $aksi = '<button onclick="verifikasi(\'' . encode_id($field->id) . '\');" type="button" class="btn btn-sm btn-success mr-1 fw-600"><i class="fas fa-check"></i> Verifikasi</button>';
            } else {
                if ($field->verif_refund === '0') {
                    $status = '<div data-toggle="tooltip" data-placement="top" title="' . $field->alasan_tolak . '" class="text-danger my_tooltip"><i class="fa fa-info-circle"></i> Ditolak<div>';
                    $aksi = '<div class="text-success"><i class="fa fa-check"></i> Final<div>';;
                } else {
                    $status = '<div class="text-success">Disetujui<div>';
                    $aksi = '<div class="text-success"><i class="fa fa-check"></i> Final<div>';;
                }
            }

            $row[] = $no;
            $row[] = $field->nm_cabang;
            $row[] = tgl_indo($field->tgl_refund);
            $row[] = $field->barcode;
            $row[] = $field->nm_barang;
            $row[] = rupiah($field->harga_modal);
            $row[] = $field->qty;
            $row[] = rupiah($field->total);
            $row[] = $status;
            $row[] = tgl_indo($field->tgl_verifikasi);
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
