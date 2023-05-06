<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Profil extends MY_controller
{

    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        $data = [
            'index' => 'profil/index',
            'index_js' => 'profil/index_js',
            'title' => 'Profil',

            'data' => $this->db->query("SELECT 
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
            ")->row()
        ];

        $this->templates->load($data);
    }

    public function edit()
    {
        $row = $this->db->query("SELECT 
            a.*, b.nama as nama_kec, c.nama as nama_kel
            from data_user a 
            left join ref_kecamatan b on b.kode_wilayah=a.kode_kec
            left join ref_kelurahan c on c.kode_wilayah=a.kode_kel
            where a.id='$this->id_akun'
        ")->row();

        $data = [
            'index' => 'profil/edit',
            'index_js' => 'profil/edit_js',
            'title' => 'Edit Profil',

            'data' => $row,
        ];

        $data['ref_prov'] = $this->db->query("SELECT 
            * from ref_provinsi
        ")->result();

        $data['ref_kab'] = $this->db->query("SELECT 
            * from ref_kabupaten where kode_prop='$row->kode_prov'
        ")->result();

        $data['ref_kec'] = $this->db->query("SELECT 
            * from ref_kecamatan where kode_kab='$row->kode_kab'
        ")->result();

        $data['ref_kel'] = $this->db->query("SELECT 
            * from ref_kelurahan where kode_kec='$row->kode_kec'
        ")->result();

        $this->templates->load($data);
    }

    public function do_submit()
    {
        cek_post();
        $nama = $this->input->post('nama');
        $username = $this->input->post('username');
        $password = $this->input->post('password');
        $re_password = $this->input->post('re_password');
        $no_hp = $this->input->post('no_hp');
        $email = $this->input->post('email');
        $alamat = $this->input->post('alamat');
        $provinsi = $this->input->post('provinsi');
        $kabupaten = $this->input->post('kabupaten');
        $kecamatan = $this->input->post('kecamatan');
        $kelurahan = $this->input->post('kelurahan');
        $ext = $this->input->post('ext');

        $foto = $this->input->post('foto');
        $nama_foto = time() . '_' . $this->input->post('nama_foto');

        $cek_email = $this->db->query("SELECT * from data_user where deleted is null and email='$email' and id !='$this->id_akun' ")->row();
        $cek_no_hp = $this->db->query("SELECT * from data_user where deleted is null and no_hp='$no_hp' and id !='$this->id_akun' ")->row();

        if (!empty($cek_email)) {
            echo json_encode([
                'status' => 'failed',
                'msg' => 'email sudah digunakan',
            ]);
            die;
        }

        if (!empty($cek_no_hp)) {
            echo json_encode([
                'status' => 'failed',
                'msg' => 'nomer hp sudah digunakan',
            ]);
            die;
        }

        if (!empty($cek_nik)) {
            echo json_encode([
                'status' => 'failed',
                'msg' => 'NIK sudah terdaftar',
            ]);
            die;
        }

        if (!empty($password)) {
            if ($password != $re_password) {
                echo json_encode([
                    'status' => 'failed',
                    'msg' => 'password tidak sama',
                ]);
                die;
            } else {
                $this->db->set('password', sha1($password));
            }
        }

        if (!empty($foto) && in_array($ext,['jpg','jpeg','png'])) {
            $path = FCPATH . 'uploads/users/' . session('id_akun');
            if (!file_exists($path)) {
                mkdir($path, 0777, TRUE);
            }
            $file_name = 'uploads/users/' . session('id_akun') . '/' . $nama_foto;
            $image_array_1 = explode(";", $foto);
            $image_array_2 = explode(",", $image_array_1[1]);
            $foto = base64_decode($image_array_2[1]);
            file_put_contents(FCPATH . 'uploads/users/' . session('id_akun') . '/' . $nama_foto, $foto);
            $this->session->set_userdata('foto', $file_name);
            $this->db->set('foto', $file_name);
        }

        $this->session->set_userdata('nama', $nama);
        $this->session->set_userdata('username', $username);
        $this->session->set_userdata('provinsi', $provinsi);
        $this->session->set_userdata('kabupaten', $kabupaten);
        $this->session->set_userdata('kecamatan', $kecamatan);
        $this->session->set_userdata('kelurahan', $kelurahan);

        $this->db->where('id', session('id_akun'));
        $this->db->update('data_user', [
            'nama' => $nama,
            'username' => $username,
            'email' => $email,
            'kode_prov' => $provinsi,
            'kode_kab' => $kabupaten,
            'kode_kec' => $kecamatan,
            'kode_kel' => $kelurahan,
            'alamat' => $alamat,
            'no_hp' => $no_hp,
            'updated' => date('Y-m-d H:i:s')
        ]);

        echo json_encode([
            'status' => 'success',
            'msg' => 'berhasil memperbarui data',
        ]);
    }

    public function get_kabupaten()
    {
        $id_prov = $this->input->post('id_prov');
        $data = $this->db->get_where('ref_kabupaten', [
            'kode_prop' => $id_prov,
        ])        
        ->result();
        echo json_encode([
            'status' => 'success',
            'data' => $data,
        ]);
    }

    public function get_kecamatan()
    {
        $id_kab = $this->input->post('id_kab');
        $data = $this->db->get_where('ref_kecamatan', [
            'kode_kab' => $id_kab,
        ])        
        ->result();
        echo json_encode([
            'status' => 'success',
            'data' => $data,
        ]);
    }

    public function get_kelurahan()
    {
        $id_kec = $this->input->post('id_kec');
        $data = $this->db->get_where('ref_kelurahan', [
            'kode_kec' => $id_kec,
        ])->result();
        echo json_encode([
            'status' => 'success',
            'data' => $data,
        ]);
    }
}

/* End of file Dashboard.php */
