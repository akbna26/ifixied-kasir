<?php

class Table_barang extends CI_Model
{
    var $column_order = array(null, 'a.nama', 'c.nama', null); //field yang ada di table user
    var $column_search = array('a.nama','a.barcode'); //field yang diizin untuk pencarian
    var $order = array('a.id' => 'desc'); // default order

    public function __construct()
    {
        parent::__construct();
    }

    private function _get_datatables_query()
    {
        $id_kategori = $this->input->get('id_kategori');

        $this->db->select('a.*, c.nama as kategori, d.nama as supplier');
        $this->db->from('barang a');
        $this->db->join('ref_kategori c', 'c.id = a.id_kategori', 'left');
        $this->db->join('ref_supplier d', 'd.id = a.id_supplier', 'left');
        $this->db->where('a.deleted', null);

        if ($id_kategori != 'all') $this->db->where('a.id_kategori', $id_kategori);

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
            $row[] = $field->nama
                . '<span class="d-block text-primary fw-600">Kategori : ' . $field->kategori . '</span>';

            $row[] = '
            <table class="table table-sm table-bordered mb-0">
                <tr class="bg-white">
                    <th>Harga Modal</th>
                    <td>' . rupiah($field->harga_modal) . '</td>
                </tr>
                <tr class="bg-white">
                    <th>Harga Jual</th>
                    <td>' . rupiah($field->harga_jual) . '</td>
                </tr>
            </table>
            ';

            $row[] = '<span class="badge badge-warning" style="font-size:15px;color:#000;"><i class="bx bx-task mr-1"></i> Stock : ' . rupiah($field->stock) . '</span>'
                . '<span class="d-block mt-2 text2 text-underline">Restock : ' . tgl_indo($field->tanggal_restock) . '</span>';

            $gambar = '';
            if (!empty($field->gambar)) {
                $gambar = '
                <tr class="bg-white">
                    <td colspan="2" class="text-center">
                        <a class="d-block text-danger text-underline" onclick="event.preventDefault();detail_gambar(this);" href="' . base_url($field->gambar) . '">lihat gambar</a>
                    </td>
                </tr>';
            }

            $row[] = $field->barcode;

            $row[] = '<span class="d-block">Ket. : ' . $field->keterangan . '</span>'
                .'<span class="d-block text-secondary">Supplier : ' . $field->supplier . '</span>'
                . $gambar;

            $row[] = '
                <div class="btn-group">
                    <button onclick="ubah(\'' . encode_id($field->id) . '\');" type="button"  data-toggle="tooltip" data-placement="top" title="edit barang" class="btn btn-primary fw-600"><i class="fas fa-edit"></i></button>
                    <button onclick="hapus(\'' . encode_id($field->id) . '\');" type="button"  data-toggle="tooltip" data-placement="top" title="hapus barang" class="btn btn-danger fw-600"><i class="fas fa-trash-alt"></i></button>
                </div>
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
