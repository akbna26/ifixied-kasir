<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Servis_berat extends MY_controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('cabang/table_servis_berat', 'table');
    }

    public function index()
    {
        $data = [
            'index' => 'cabang/servis_berat/index',
            'index_js' => 'cabang/servis_berat/index_js',
            'title' => 'Servis Berat',
        ];

        $data['sidebar_mini'] = true;

        $data['all_status'] = [
            [
                'nama' => 'Belum Cek',
                'id' => '1',
                'nick' => 'belum',
            ],
            [
                'nama' => 'Sedang Cek',
                'id' => '2',
                'nick' => 'sedang',
            ],
            [
                'nama' => 'Menunggu',
                'id' => '3,4',
                'nick' => 'menunggu',
            ],
            [
                'nama' => 'Proses',
                'id' => '5,6',
                'nick' => 'proses',
            ],
            [
                'nama' => 'Cancel',
                'id' => '7,8',
                'nick' => 'cancel',
            ],
            [
                'nama' => 'Sudah Jadi',
                'id' => '9',
                'nick' => 'selesai',
            ],
        ];

        $this->templates->load($data);
    }

    public function table()
    {
        echo $this->table->generate_table();
    }

    public function detail()
    {
        $id = decode_id($this->input->post('id'));
        $data['id'] = $id;
        $data['row'] = $this->db->query("SELECT
            a.*,
            b.nama AS nm_status,
            ifnull( c.nama, '-' ) AS nm_tindakan,
            ifnull( f.nama, '-' ) AS nm_teknisi,
            e.nama AS nm_cabang,
            g.nama AS nm_pengambilan 
        FROM servis_berat a
            LEFT JOIN ref_status_servis b ON b.id = a.
            STATUS LEFT JOIN ref_tindakan c ON c.id = a.id_tindakan
            LEFT JOIN setting_pegawai d ON d.id = a.id_teknisi_setting
            LEFT JOIN pegawai f ON f.id = d.id_pegawai
            LEFT JOIN ref_cabang e ON e.id = a.id_cabang
            LEFT JOIN ref_pengambilan g ON g.id = a.id_pengambilan 
        WHERE
            a.deleted IS NULL and a.id='$id'
        ")->row();

        $html = $this->load->view('cabang/servis_berat/detail', $data, true);

        echo json_encode([
            'status' => 'success',
            'html' => $html,
        ]);
    }

    public function bayar()
    {
        $id = decode_id($this->input->post('id'));
        $data['id'] = $id;
        $data['data'] = $this->db->query("SELECT * from servis_berat where id='$id' and deleted is null ")->row();
        $data['pegawai'] = $this->db->query("SELECT * from pegawai where id_cabang='$this->id_cabang' and deleted is null ")->result();

        $html = $this->load->view('cabang/servis_berat/bayar', $data, true);

        echo json_encode([
            'status' => 'success',
            'html' => $html,
        ]);
    }

    public function tambah()
    {
        $data = [];
        $html = $this->load->view('cabang/servis_berat/form', $data, true);

        echo json_encode([
            'status' => 'success',
            'html' => $html,
        ]);
    }

    public function ubah()
    {
        $id = decode_id($this->input->post('id'));
        $data['id'] = $id;
        $data['data'] = $this->db->query("SELECT * from servis_berat where id='$id' and deleted is null ")->row();
        $html = $this->load->view('cabang/servis_berat/form', $data, true);

        echo json_encode([
            'status' => 'success',
            'html' => $html,
        ]);
    }

    public function do_submit()
    {
        cek_post();
        $id = decode_id($this->input->post('id'));
        $hapus = $this->input->post('hapus');

        $diagnosa = $this->input->post('diagnosa');
        $estimasi_biaya = clear_koma($this->input->post('estimasi_biaya'));
        $kerusakan = $this->input->post('kerusakan');
        $keterangan = $this->input->post('keterangan');
        $no_hp = $this->input->post('no_hp');
        $pelanggan = $this->input->post('pelanggan');
        $serial_number = $this->input->post('serial_number');
        $tipe_unit = $this->input->post('tipe_unit');
        $tgl_masuk = date('Y-m-d', strtotime($this->input->post('tgl_masuk')));
        $modal = clear_koma($this->input->post('modal'));
        $harga_part = clear_koma($this->input->post('harga_part'));

        if (!empty($hapus)) {
            $this->db->where('id', $id);
            $this->db->update('servis_berat', [
                'deleted' => date('Y-m-d H:i:s'),
            ]);
        } else {
            if (empty($id)) {
                $this->db->insert('servis_berat', [
                    'id_pengambilan' => 1,
                    'diagnosa' => $diagnosa,
                    'estimasi_biaya' => $estimasi_biaya,
                    'kerusakan' => $kerusakan,
                    'keterangan' => $keterangan,
                    'no_hp' => $no_hp,
                    'pelanggan' => $pelanggan,
                    'serial_number' => $serial_number,
                    'tipe_unit' => $tipe_unit,
                    'tgl_masuk' => $tgl_masuk,
                    'modal' => $modal,
                    'harga_part' => $harga_part,
                    'status' => 1,
                    'id_cabang' => $this->id_cabang,
                    'created' => date('Y-m-d H:i:s'),
                ]);

                $id_insert = $this->db->insert_id();
                insert_log_servis($id_insert, 1, '');
            } else {
                $this->db->where('id', $id);
                $this->db->update('servis_berat', [
                    'diagnosa' => $diagnosa,
                    'estimasi_biaya' => $estimasi_biaya,
                    'kerusakan' => $kerusakan,
                    'keterangan' => $keterangan,
                    'no_hp' => $no_hp,
                    'pelanggan' => $pelanggan,
                    'serial_number' => $serial_number,
                    'tipe_unit' => $tipe_unit,
                    'tgl_masuk' => $tgl_masuk,
                    'modal' => $modal,
                    'harga_part' => $harga_part,
                    'status' => 1,
                    'id_cabang' => $this->id_cabang,
                    'updated' => date('Y-m-d H:i:s'),
                ]);
            }
        }

        echo json_encode([
            'status' => 'success'
        ]);
    }

    public function do_bayar()
    {
        cek_post();
        $id = decode_id($this->input->post('id'));

        $tgl_keluar = date('Y-m-d', strtotime($this->input->post('tgl_keluar')));
        $bayar = clear_koma($this->input->post('bayar'));
        $user_pengambil = $this->input->post('user_pengambil');
        $id_pegawai = $this->input->post('id_pegawai');

        $this->db->where('id', $id);
        $this->db->update('servis_berat', [
            'id_pegawai' => $id_pegawai,
            'id_pengambilan' => 4,
            'tgl_keluar' => $tgl_keluar,
            'bayar' => $bayar,
            'user_pengambil' => $user_pengambil,
            'updated' => date('Y-m-d H:i:s'),
        ]);

        echo json_encode([
            'status' => 'success',
            'link' => base_url('cabang/cetak/nota_servis_berat/') . encode_id($id),
        ]);
    }

    public function konfirmasi()
    {
        cek_post();
        if (session('type') != 'admin') dd('not allowed');

        $id_servis = decode_id($this->input->post('id_servis'));
        $row = $this->db->query("SELECT * from servis_berat where id='$id_servis' ")->row();
        $data['data'] = $row;

        $data['ref_tindakan'] = $this->db->query("SELECT * from ref_tindakan")->result();
        $data['ref_teknisi'] =  $this->db->query("SELECT a.*, b.nama as nm_pegawai
            from setting_pegawai a
            left join pegawai b on b.id=a.id_pegawai
            where a.id_tindakan='$row->id_tindakan' and a.deleted is null
        ")->result();

        if ($row->status == 1) {
            $html = $this->load->view('cabang/servis_berat/form_1', $data, true);
        } elseif ($row->status == 2) {
            $html = $this->load->view('cabang/servis_berat/form_2', $data, true);
        } elseif (in_array($row->status, [3, 4])) {
            $html = $this->load->view('cabang/servis_berat/form_3', $data, true);
        } elseif ($row->status == 5) {
            $html = $this->load->view('cabang/servis_berat/form_5', $data, true);
        } elseif ($row->status == 6) {
            $html = $this->load->view('cabang/servis_berat/form_6', $data, true);
        }

        echo json_encode([
            'status' => 'success',
            'html' => $html,
        ]);
    }

    public function do_konfirmasi()
    {
        cek_post();
        if (session('type') != 'admin') dd('not allowed');

        $id = decode_id($this->input->post('id'));
        $form = decode_id($this->input->post('form'));
        $keterangan = $this->input->post('keterangan', true);
        $status = $this->input->post('status');

        $biaya = clear_koma($this->input->post('biaya'));
        $harga_part = clear_koma($this->input->post('harga_part'));
        $modal = clear_koma($this->input->post('modal'));
        $id_teknisi = $this->input->post('id_teknisi');
        $id_tindakan = $this->input->post('id_tindakan');

        if ($form == 1) {
            $tahun = date('Y');
            $bulan = date('m');
            $row_cabang = $this->db->query("SELECT * from servis_berat where id='$id' ")->row();
            $total_transaksi = $this->db->query("SELECT count(1)+1 as total from servis_berat where id !='$id' and id_cabang='$row_cabang->id_cabang' and month(created)='$bulan' and year(created)='$tahun' ")->row();
            $no_invoice = 'SRV' . $row_cabang->id_cabang . '-' . date('Ym') . '-' . sprintf("%04d", $total_transaksi->total);

            $status = 2;
            $this->db->set('id_pengambilan', 2);
            $this->db->set('invoice', $no_invoice);
        }

        if (in_array($status, [7, 8, 9])) $this->db->set('id_pengambilan', 3);

        if ($status == 5) {
            $this->db->where('id', $id);
            $this->db->update('servis_berat', [
                'id_teknisi_setting' => $id_teknisi,
                'id_tindakan' => $id_tindakan,
                'biaya' => $biaya,
                'harga_part' => $harga_part,
                'modal' => $modal,
                'status' => $status,
                'updated' => date('Y-m-d H:i:s'),
            ]);
        } else {
            $this->db->where('id', $id);
            $this->db->update('servis_berat', [
                'status' => $status,
                'updated' => date('Y-m-d H:i:s'),
            ]);
        }
        insert_log_servis($id, $status, $keterangan);

        echo json_encode([
            'status' => 'success',
        ]);
    }

    public function get_tindakan_teknisi()
    {
        cek_post();
        $id_tindakan = $this->input->post('id_tindakan');

        $list = $this->db->query("SELECT a.*, b.nama as nm_pegawai
            from setting_pegawai a
            left join pegawai b on b.id=a.id_pegawai
            where a.id_tindakan='$id_tindakan' and a.deleted is null
        ")->result();

        echo json_encode([
            'status' => 'success',
            'data' => $list,
        ]);
    }

    public function get_total()
    {
        $where = '';
        if (session('type') == 'cabang') $where = "and a.id_cabang='$this->id_cabang'";
        $data = $this->db->query("SELECT 
            count(1) as 'all'
            ,count(case when status in(1) then 1 end) as 'belum'
            ,count(case when status in(2) then 1 end) as 'sedang'
            ,count(case when status in(3,4) then 1 end) as 'menunggu'
            ,count(case when status in(5,6) then 1 end) as 'proses'
            ,count(case when status in(7,8) then 1 end) as 'cancel'
            ,count(case when status in(9) then 1 end) as 'selesai'
            from servis_berat a 
            where a.deleted is null $where
        ")->row();

        echo json_encode([
            'status' => 'success',
            'data' => $data,
        ]);
    }

    public function log()
    {
        $id = decode_id($this->input->post('id'));
        $data['id'] = $id;
        $data['data'] = $this->db->query("SELECT a.*, b.nama as nm_status
            from log_servis a 
            left join ref_status_servis b on b.id=a.status
            where a.id_servis='$id' and a.deleted is null 
            order by a.id
        ")->result();

        $html = $this->load->view('cabang/servis_berat/log', $data, true);

        echo json_encode([
            'status' => 'success',
            'html' => $html,
        ]);
    }
}
