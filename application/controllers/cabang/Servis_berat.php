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
            ],
            [
                'nama' => 'Sedang Cek',
                'id' => '2',
            ],
            [
                'nama' => 'Menunggu',
                'id' => '3,4',
            ],
            [
                'nama' => 'Proses',
                'id' => '5,6',
            ],
            [
                'nama' => 'Cancel',
                'id' => '7,8',
            ],
            [
                'nama' => 'Sudah Jadi',
                'id' => '9',
            ],
        ];

        $this->templates->load($data);
    }

    public function table()
    {
        echo $this->table->generate_table();
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

        if ($status == 9) $this->db->set('id_pengambilan', 3);

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
}
