<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Dashboard extends MY_controller
{

    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        $data = [
            'index' => 'cabang/dashboard/index',
            'index_js' => 'cabang/dashboard/index_js',
            'title' => 'Dashboard',
        ];

        $data['row'] = $this->db->query("SELECT 
            a.*, 
            b.nama as nama_prov, c.nama as nama_kab, d.nama as nama_kec, e.nama as nama_kel,
            f.nama as cabang
            from data_user a 
            left join ref_provinsi b on b.kode_wilayah=a.kode_prov
            left join ref_kabupaten c on c.kode_wilayah=a.kode_kab
            left join ref_kecamatan d on d.kode_wilayah=a.kode_kec
            left join ref_kelurahan e on e.kode_wilayah=a.kode_kel
            left join ref_cabang f on f.id=a.id_cabang
            where a.id='$this->id_akun'
        ")->row();

        $today = date('Y-m-d');
        $total = $this->db->query("SELECT count( 1 ) AS banyak, IFNULL(sum( total - (total*(potongan/100)) ),0) AS total, 'dp' AS jenis FROM dp WHERE id_cabang='$this->id_cabang' AND deleted IS NULL and tanggal='$today' UNION ALL
        SELECT count( 1 ) AS banyak, IFNULL(sum( sub_total ),0) AS total, 'barang' AS jenis FROM profit WHERE id_cabang='$this->id_cabang' AND DATE(created)='$today' UNION ALL
        (
            SELECT
                count( 1 ) AS banyak,
                IFNULL(sum( b.harga_modal),0) AS total,
                'refund' AS jenis 
            FROM
                refund a
                LEFT JOIN refund_detail b ON b.id_refund = a.id 
                AND b.deleted IS NULL 
            WHERE
                a.id_cabang='$this->id_cabang' 
            AND a.deleted IS NULL and tanggal='$today'
        ) union all SELECT count( 1 ) AS banyak, IFNULL(sum( sub_total ),0) AS total, 'servis_berat' AS jenis FROM profit_servis WHERE id_cabang='$this->id_cabang' and tgl_keluar='$today' ")->result();

        $total_all = [];
        foreach ($total as $dt) $total_all[$dt->jenis] = $dt;
        
        $data['total'] = $total_all;

        $this->templates->load($data);
    }

    public function session()
    {
        session();
    }
}

/* End of file Dashboard.php */
