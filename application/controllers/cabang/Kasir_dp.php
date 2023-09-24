<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Kasir_dp extends MY_controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('cabang/table_kasir_dp', 'table');
    }

    public function index()
    {
        $data = [
            'index' => 'cabang/kasir_dp/index',
            'index_js' => 'cabang/kasir_dp/index_js',
            'title' => 'Kasir DP',
        ];

        $this->templates->load($data);
    }

    public function table()
    {
        echo $this->table->generate_table();
    }

    public function tambah()
    {
        $data['pegawai'] = $this->db->query("SELECT * from pegawai where id_cabang='$this->id_cabang' and deleted is null ")->result();
        $data['ref_jenis_pembayaran'] = $this->db->query("SELECT * from ref_jenis_pembayaran where deleted is null ")->result();

        $html = $this->load->view('cabang/kasir_dp/form', $data, true);

        echo json_encode([
            'status' => 'success',
            'html' => $html,
        ]);
    }

    public function ubah()
    {
        $id = decode_id($this->input->post('id'));
        $data['id'] = $id;
        $data['data'] = $this->db->query("SELECT * from dp where id='$id' and deleted is null ")->row();
        $data['pegawai'] = $this->db->query("SELECT * from pegawai where id_cabang='$this->id_cabang' and deleted is null ")->result();
        $data['ref_jenis_pembayaran'] = $this->db->query("SELECT * from ref_jenis_pembayaran where deleted is null ")->result();

        $html = $this->load->view('cabang/kasir_dp/form', $data, true);

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

        $tahun = date('Y');
        $bulan = date('m');
        $total_transaksi = $this->db->query("SELECT count(1)+1 as total from dp where id_cabang='$this->id_cabang' and month(created)='$bulan' and year(created)='$tahun' ")->row();
        $no_invoice = 'INVDP' . $this->id_cabang . '-' . date('Ym') . '-' . sprintf("%04d", $total_transaksi->total);
        
        $pembayaran = $this->input->post('pembayaran');
        $total = clear_koma($this->input->post('total'));
        $estimasi_biaya = clear_koma($this->input->post('estimasi_biaya'));
        $tanggal = date('Y-m-d', strtotime($this->input->post('tanggal')));
        $keterangan = $this->input->post('keterangan');
        $id_pegawai = $this->input->post('id_pegawai');
        $nama = $this->input->post('nama');
        $no_hp = $this->input->post('no_hp');

        $get_prosen_bayar_1 = $this->db->query("SELECT * from ref_jenis_pembayaran where id='$pembayaran' and deleted is null ")->row();
        $potongan = $get_prosen_bayar_1->persen_potongan;

        if (!empty($hapus)) {
            $this->db->where('id', $id);
            $this->db->update('dp', [
                'deleted' => date('Y-m-d H:i:s'),
            ]);
        } else {
            if (empty($id)) {
                $this->db->insert('dp', [
                    'pembayaran' => $pembayaran,
                    'total' => $total,
                    'tanggal' => $tanggal,
                    'keterangan' => $keterangan,
                    'kode' => $no_invoice,
                    'id_cabang' => $this->id_cabang,
                    'nama' => $nama,
                    'id_pegawai' => $id_pegawai,
                    'estimasi_biaya' => $estimasi_biaya,
                    'no_hp' => $no_hp,
                    'potongan' => $potongan,
                    'created' => date('Y-m-d H:i:s'),
                ]);
                $id = $this->db->insert_id();
            } else {
                $this->db->where('id', $id);
                $this->db->update('dp', [
                    'pembayaran' => $pembayaran,
                    'total' => $total,
                    'tanggal' => $tanggal,
                    'keterangan' => $keterangan,
                    'nama' => $nama,
                    'id_pegawai' => $id_pegawai,
                    'estimasi_biaya' => $estimasi_biaya,
                    'no_hp' => $no_hp,
                    'potongan' => $potongan,
                    'updated' => date('Y-m-d H:i:s'),
                ]);
            }
        }

        echo json_encode([
            'status' => 'success',
            'link' => base_url('cabang/cetak/nota_dp/') . encode_id($id),
        ]);
    }

    public function do_konfirmasi()
    {
        cek_post();
        $id = decode_id($this->input->post('id'));

        $this->db->where('id', $id);
        $this->db->update('dp', [
            'updated' => date('Y-m-d H:i:s'),
            'is_selesai' => '1',
        ]);

        echo json_encode([
            'status' => 'success'
        ]);
    }

    public function do_cancel()
    {
        cek_post();
        $id = decode_id($this->input->post('id'));

        $this->db->where('id', $id);
        $this->db->update('dp', [
            'deleted' => date('Y-m-d H:i:s'),
            'tgl_cancel' => date('Y-m-d H:i:s'),
            'is_cancel' => '1',
        ]);

        echo json_encode([
            'status' => 'success'
        ]);
    }

}
