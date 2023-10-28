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
            'index' => 'owner/dashboard/index',
            'index_js' => 'owner/dashboard/index_js',
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
        
        $data['row_data'] = $this->db->query("SELECT count(1) as total_item, sum(a.stock) as total_stock, 
            sum(
                case when a.id_kategori = '2' then a.stock*a.harga_modal else 0 end
            ) as total_modal_acc,
            sum(
                case when a.id_kategori != '2' then a.stock*a.harga_modal else 0 end
            ) as total_modal_part
            from barang a
            where a.deleted is null
        ")->row();

        $data['row_data_cabang'] = $this->db->query("SELECT count(distinct b.id_barang) as total_item, sum(b.stock) as total_stock, 
            sum(
                case when a.id_kategori = '2' then b.stock*a.harga_modal else 0 end
            ) as total_modal_acc,
            sum(
                case when a.id_kategori != '2' then b.stock*a.harga_modal else 0 end
            ) as total_modal_part
            from barang a 
            left join barang_cabang b on b.id_barang=a.id
            where a.deleted is null
        ")->row();

        $this->templates->load($data);
    }

    public function session()
    {
        session();
    }
}

/* End of file Dashboard.php */
