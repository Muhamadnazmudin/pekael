<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Jurusan extends CI_Controller {

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

        $this->load->model('Jurusan_model');
    }

    // ======================
    // LIST
    // ======================
    public function index()
    {
        $data['title'] = 'Data Jurusan';

        $data['jurusan'] =
            $this->Jurusan_model->getAll();

        template(
            'admin/jurusan/index',
            $data
        );
    }

    // ======================
    // TAMBAH
    // ======================
    public function tambah()
    {
        if ($this->input->post()) {

            $data = [
                'kode_jurusan' =>
                    $this->input->post('kode_jurusan'),

                'nama_jurusan' =>
                    $this->input->post('nama_jurusan'),

                'singkatan' =>
                    $this->input->post('singkatan')
            ];

            $this->Jurusan_model
                ->insert($data);

            redirect('jurusan');
        }

        $data['title'] =
            'Tambah Jurusan';

        template(
            'admin/jurusan/tambah',
            $data
        );
    }

    // ======================
    // EDIT
    // ======================
    public function edit($id)
    {
        $jurusan =
            $this->Jurusan_model
            ->getById($id);

        if (!$jurusan) {
            show_404();
        }

        if ($this->input->post()) {

            $data = [
                'kode_jurusan' =>
                    $this->input->post('kode_jurusan'),

                'nama_jurusan' =>
                    $this->input->post('nama_jurusan'),

                'singkatan' =>
                    $this->input->post('singkatan')
            ];

            $this->Jurusan_model
                ->update($id, $data);

            redirect('jurusan');
        }

        $data['title'] =
            'Edit Jurusan';

        $data['jurusan'] =
            $jurusan;

        template(
            'admin/jurusan/edit',
            $data
        );
    }

    // ======================
    // HAPUS
    // ======================
    public function hapus($id)
    {
        $this->Jurusan_model
            ->delete($id);

        redirect('jurusan');
    }
}