<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Tahun extends CI_Controller {

    public function __construct()
    {
        parent::__construct();

        // cek login admin
        if (
            !$this->session->userdata('role') ||
            $this->session->userdata('role') != 'admin'
        ){
            redirect('login');
        }
    }

    // ======================
    // LIST DATA
    // ======================
    public function index()
    {
        $data['title'] = 'Tahun Ajaran';

        $data['tahun'] = $this->db
            ->order_by('id','DESC')
            ->get('tahun_ajaran')
            ->result();

        template('admin/tahun/index', $data);
    }

    // ======================
    // TAMBAH
    // ======================
    public function tambah()
    {
        if ($this->input->post()) {

            $this->db->insert('tahun_ajaran', [
                'tahun' => $this->input->post('tahun'),
                'status' => 'nonaktif'
            ]);

            $this->session->set_flashdata(
                'success',
                'Tahun ajaran berhasil ditambahkan'
            );

            redirect('tahun');
        }

        $data['title'] = 'Tambah Tahun Ajaran';

        template('admin/tahun/tambah', $data);
    }

    // ======================
    // EDIT
    // ======================
    public function edit($id)
    {
        $tahun = $this->db
            ->get_where(
                'tahun_ajaran',
                ['id' => $id]
            )
            ->row();

        if (!$tahun) {
            show_404();
        }

        if ($this->input->post()) {

            $this->db
                ->where('id', $id)
                ->update('tahun_ajaran', [
                    'tahun' =>
                    $this->input->post('tahun')
                ]);

            $this->session->set_flashdata(
                'success',
                'Tahun ajaran berhasil diubah'
            );

            redirect('tahun');
        }

        $data['title'] = 'Edit Tahun Ajaran';
        $data['tahun'] = $tahun;

        template('admin/tahun/edit', $data);
    }

    // ======================
    // HAPUS
    // ======================
    public function hapus($id)
    {
        $this->db->delete(
            'tahun_ajaran',
            ['id' => $id]
        );

        $this->session->set_flashdata(
            'success',
            'Tahun ajaran berhasil dihapus'
        );

        redirect('tahun');
    }

    // ======================
    // SET AKTIF
    // ======================
    public function aktif($id)
    {
        // nonaktif semua
        $this->db->update(
            'tahun_ajaran',
            ['status' => 'nonaktif']
        );

        // aktifkan pilihan
        $this->db
            ->where('id', $id)
            ->update(
                'tahun_ajaran',
                ['status' => 'aktif']
            );

        $this->session->set_flashdata(
            'success',
            'Tahun ajaran aktif berhasil diubah'
        );

        redirect('tahun');
    }
}