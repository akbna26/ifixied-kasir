<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Note extends MY_controller
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        $data = [
            'index' => 'admin/note/index',
            'index_js' => 'admin/note/index_js',
            'title' => 'Sticky Note',
        ];
        $data['label'] = $this->db->query("SELECT * from label where deleted is null and id_user='$this->id_akun' order by id DESC")->result();
        $this->templates->load($data);
    }

    public function load_card()
    {
        cek_post();
        $id = $this->input->post('id');
        $where = '';

        if ($id != '') {
            $id = decode_id($this->input->post('id'));
            $where = "and FIND_IN_SET('$id',id_label)";
        }

        $data['data'] = $this->db->query("SELECT * from note where 1=1 and id_user='$this->id_akun' and deleted is null $where order by id DESC")->result();
        $data['label'] = $this->db->query("SELECT * from label where id_user='$this->id_akun' and deleted is null")->result();
        $data['id_label'] = encode_id($id);
        $html = $this->load->view('admin/note/list_card', $data, true);

        echo json_encode([
            'status' => 'success',
            'html' => $html,
        ]);
    }

    public function tambah_note()
    {
        $data['ref_warna'] = $this->db->get('ref_warna')->result();
        $data['label'] = $this->db->query("SELECT * from label where id_user='$this->id_akun' and deleted is null")->result();
        $html = $this->load->view('admin/note/form_catatan', $data, true);

        echo json_encode([
            'status' => 'success',
            'html' => $html,
        ]);
    }

    public function edit_note()
    {
        cek_post();
        $id = decode_id($this->input->post('id'));

        $data['ref_warna'] = $this->db->get('ref_warna')->result();
        $data['label'] = $this->db->query("SELECT * from label where id_user='$this->id_akun' and deleted is null")->result();
        $data['data'] = $this->db->query("SELECT * from note where id='$id' and deleted is null")->row();

        $html = $this->load->view('admin/note/form_catatan', $data, true);

        echo json_encode([
            'status' => 'success',
            'html' => $html,
        ]);
    }

    public function tambah_label()
    {
        $data['ref_warna'] = $this->db->get('ref_warna')->result();
        $html = $this->load->view('admin/note/form_label', $data, true);

        echo json_encode([
            'status' => 'success',
            'html' => $html,
        ]);
    }

    public function ubah()
    {
        $id = decode_id($this->input->post('id'));
        $data = [
            'data' => $this->db->query("SELECT * from note where id='$id' and deleted is null ")->row(),
        ];
        $html = $this->load->view('admin/note/form', $data, true);

        echo json_encode([
            'status' => 'success',
            'html' => $html,
        ]);
    }

    public function do_submit_catatan()
    {
        cek_post();
        $id = decode_id($this->input->post('id'));
        $hapus = $this->input->post('hapus');

        $judul = $this->input->post('judul');
        $warna = $this->input->post('warna');
        $catatan = $this->input->post('catatan');
        $label = $this->input->post('label');

        if (!empty($hapus)) {
            $this->db->where('id', $id);
            $this->db->update('note', [
                'deleted' => date('Y-m-d H:i:s'),
            ]);
        } else {
            $label = implode(',', $label);

            if (empty($id)) {
                $this->db->insert('note', [
                    'id_user' => $this->id_akun,
                    'judul' => $judul,
                    'catatan' => $catatan,
                    'id_label' => $label,
                    'warna' => $warna,
                    'created' => date('Y-m-d H:i:s'),
                ]);
            } else {
                $this->db->where('id', $id);
                $this->db->update('note', [
                    'judul' => $judul,
                    'catatan' => $catatan,
                    'id_label' => $label,
                    'warna' => $warna,
                    'updated' => date('Y-m-d H:i:s'),
                ]);
            }
        }

        echo json_encode([
            'status' => 'success'
        ]);
    }

    public function do_submit_label()
    {
        cek_post();
        $id = decode_id($this->input->post('id'));
        $hapus = $this->input->post('hapus');

        $label = $this->input->post('label');
        $warna = $this->input->post('warna');

        if (!empty($hapus)) {
            $this->db->where('id', $id);
            $this->db->update('label', [
                'deleted' => date('Y-m-d H:i:s'),
            ]);
        } else {
            if (empty($id)) {
                $this->db->insert('label', [
                    'id_user' => $this->id_akun,
                    'label' => $label,
                    'warna' => $warna,
                    'created' => date('Y-m-d H:i:s'),
                ]);
            } else {
                $target = $this->input->post('target');
                $val = $this->input->post('val');
                
                $this->db->where('id', $id);
                $this->db->update('label', [
                    $target => $val,
                    'updated' => date('Y-m-d H:i:s'),
                ]);
            }
        }


        echo json_encode([
            'status' => 'success'
        ]);
    }

    public function kelola_label()
    {
        $data = [
            'data' => $this->db->query("SELECT * from label where deleted is null ")->result(),
            'ref_warna' => $this->db->get('ref_warna')->result(),
        ];
        $html = $this->load->view('admin/note/kelola_label', $data, true);

        echo json_encode([
            'status' => 'success',
            'html' => $html,
        ]);
    }
}
