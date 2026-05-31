<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Guru extends CI_Controller {

    public function __construct()
    {
        parent::__construct();

        if (
            !$this->session->userdata('role')
            ||
            $this->session->userdata('role')
            != 'admin'
        ){
            redirect('login');
        }

        $this->load->model(
            'Guru_model'
        );
    }

    // ======================
    // INDEX
    // ======================
    public function index()
    {
        $data['title'] =
            'Data Guru';

        $data['guru'] =
            $this->Guru_model
            ->getAll();

        template(
            'admin/guru/index',
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

            'nip' =>
                $this->input
                ->post('nip'),

            'nama_guru' =>
                $this->input
                ->post('nama_guru'),

            'jurusan_id' =>
                $this->input
                ->post('jurusan_id')
                ? $this->input
                    ->post('jurusan_id')
                : NULL,

            'jenis_guru' =>
                $this->input
                ->post('jenis_guru'),

            'status' =>
                $this->input
                ->post('status')
        ];

        $this->Guru_model
            ->insert($data);

        redirect('guru');
    }

    $data['jurusan'] =
        $this->db
        ->get('jurusan')
        ->result();

    template(
        'admin/guru/tambah',
        $data
    );
}

    // ======================
    // EDIT
    // ======================
    public function edit($id)
    {
        $guru =
            $this->Guru_model
            ->getById($id);

        if (!$guru) {
            show_404();
        }

        if ($this->input->post()) {

            $data = [
                'nip' =>
                    $this->input
                    ->post('nip'),

                'nama_guru' =>
                    $this->input
                    ->post('nama_guru'),

                'jurusan_id' =>
$this->input->post('jurusan_id')
? $this->input->post('jurusan_id')
: NULL,

                'jenis_guru' =>
                    $this->input
                    ->post('jenis_guru'),

                'status' =>
                    $this->input
                    ->post('status')
            ];

            $this->Guru_model
                ->update($id, $data);

            redirect('guru');
        }

        $data['guru'] = $guru;

        $data['jurusan'] =
            $this->db
            ->get('jurusan')
            ->result();

        template(
            'admin/guru/edit',
            $data
        );
    }

    // ======================
    // HAPUS
    // ======================
    public function hapus($id)
{
    $guru = $this->Guru_model
        ->getById($id);

    if(!$guru){
        show_404();
    }

    $this->Guru_model
        ->delete($id);

    redirect('guru');
}
}