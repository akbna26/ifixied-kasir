<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Daftar_cabang extends MY_controller
{
    
    public function __construct()
    {
        parent::__construct();
        $this->load->model('owner/table_mutasi', 'table');
        $this->load->model('owner/table_mutasi_servis', 'table_servis');
    }

    public function index()
    {
        $data = [
            'index' => 'owner/daftar_cabang/index',
            'index_js' => 'owner/daftar_cabang/index_js',
            'title' => 'Daftar Cabang',
        ];

        $where='';
        if($this->type=='owner_cabang') $where .="AND id='$this->id_cabang' ";
        $data['cabang'] = $this->db->query("SELECT * from ref_cabang where deleted is null $where ")->result();

        $this->templates->load($data);
    }

    public function table()
    {
        echo $this->table->generate_table();
    }

    public function table_servis()
    {
        echo $this->table_servis->generate_table();
    }

    public function detail($id)
    {
        $data = [
            'index' => 'owner/daftar_cabang/detail',
            'index_js' => 'owner/daftar_cabang/detail_js',
            'title' => 'Detail Profit',
        ];

        $id = decode_id($id);
        $data['id_cabang'] = $id;
        $data['cabang'] = $this->db->query("SELECT * from ref_cabang where deleted is null and id='$id' ")->row();

        $this->templates->load($data);
    }

    public function get_data()
    {
        $id = decode_id($this->input->post('id_cabang'));
        $tanggal = date('Y-m-d', strtotime($this->input->post('tanggal')));

        $total_profit_penjualan = $this->db->query("SELECT sum(total_profit) as total from profit where id_cabang='$id' and date(created)='$tanggal' ")->row();
        $total_profit_servis = $this->db->query("SELECT sum(profit) as total from profit_servis where id_cabang='$id' and date(tgl_keluar)='$tanggal' ")->row();
        $total_profit_harian = @$total_profit_penjualan->total + @$total_profit_servis->total;
        $total_profit_bulanan = $this->db->query("SELECT sum(total) as total FROM (
            SELECT SUM(total_profit) AS total 
            FROM profit
            WHERE id_cabang = '$id'
            AND MONTH(created) = MONTH('$tanggal')
            AND YEAR(created) = YEAR('$tanggal')

            UNION

            SELECT SUM(profit) AS total 
            FROM profit_servis
            WHERE id_cabang = '$id'
            AND MONTH(tgl_keluar) = MONTH('$tanggal')
            AND YEAR(tgl_keluar) = YEAR('$tanggal')
        ) as tabel
        ")->row();

        $grafik = $this->db->query("SELECT sum(total) as total, waktu FROM (
            SELECT SUM(total_profit) AS total, DATE(created) as waktu
            FROM profit
            WHERE id_cabang = '$id' AND MONTH(created) = MONTH('$tanggal') AND YEAR(created) = YEAR('$tanggal')

            UNION

            SELECT SUM(profit) AS total, tgl_keluar as waktu
            FROM profit_servis
            WHERE id_cabang = '$id' AND MONTH(tgl_keluar) = MONTH('$tanggal') AND YEAR(tgl_keluar) = YEAR('$tanggal')
        ) as tabel 
           group by waktu order by waktu
        ")->result();

        $kategori = [];
        $series = [];
        foreach ($grafik as $dt) {
            $kategori[] = $dt->waktu;
            $series[] = (int)$dt->total;
        }

        echo json_encode([
            'status' => 'success',
            'data' => [
                'total_profit_penjualan' => empty($total_profit_penjualan->total) ? 0 : rupiah($total_profit_penjualan->total),
                'total_profit_servis' => empty($total_profit_servis->total) ? 0 : rupiah($total_profit_servis->total),
                'total_profit_harian' => empty($total_profit_harian) ? 0 : rupiah($total_profit_harian),
                'total_profit_bulanan' => empty($total_profit_bulanan->total) ? 0 : rupiah($total_profit_bulanan->total),
            ],
            'grafik' => [
                'waktu' => angkaKeNamaBulan(date('m', strtotime($tanggal))) . ' ' . date('Y', strtotime($tanggal)),
                'kategori' => $kategori,
                'series' => $series,
            ]
        ]);
    }
}

/* End of file Dashboard.php */
