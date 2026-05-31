<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dudi extends CI_Controller {

    public function __construct()
    {
        parent::__construct();

        if(
            !$this->session
            ->userdata('role')
            ||
            $this->session
            ->userdata('role')
            != 'admin'
        ){
            redirect('login');
        }

        $this->load->model(
            'Dudi_model'
        );
    }

    // ======================
    // INDEX
    // ======================
    public function index()
    {
        $data['title'] =
            'Data DUDI';

        $data['dudi'] =
            $this->Dudi_model
            ->getAll();

        template(
            'admin/dudi/index',
            $data
        );
    }

    // ======================
    // TAMBAH
    // ======================
    public function tambah()
    {
        if($_POST){

            $data = [

                'nama_dudi' =>
                    $this->input
                    ->post('nama_dudi'),

                'bidang_usaha' =>
                    $this->input
                    ->post('bidang_usaha'),

                'alamat' =>
                    $this->input
                    ->post('alamat'),

                'desa_kelurahan' =>
                    $this->input
                    ->post('desa'),

                'kecamatan' =>
                    $this->input
                    ->post('kecamatan'),

                'kabupaten_kota' =>
                    $this->input
                    ->post('kabupaten'),

                'provinsi' =>
                    $this->input
                    ->post('provinsi'),

                'nomor_mou' =>
                    $this->input
                    ->post('nomor_mou'),

                'judul_pks' =>
                    $this->input
                    ->post('judul_pks'),

                'nama_pic' =>
                    $this->input
                    ->post('nama_pic'),

                'no_hp_pic' =>
                    $this->input
                    ->post('no_hp_pic'),

                'status_kerjasama' =>
                    $this->input
                    ->post('status')
            ];

            $this->Dudi_model
                ->insert($data);

            redirect('dudi');
        }

        template(
            'admin/dudi/tambah'
        );
    }

    // ======================
    // EDIT
    // ======================
    public function edit($id)
    {
        if($_POST){

            $data = [

                'nama_dudi' =>
                    $this->input
                    ->post('nama_dudi'),

                'bidang_usaha' =>
                    $this->input
                    ->post('bidang_usaha'),

                'alamat' =>
                    $this->input
                    ->post('alamat'),

                'desa_kelurahan' =>
                    $this->input
                    ->post('desa'),

                'kecamatan' =>
                    $this->input
                    ->post('kecamatan'),

                'kabupaten_kota' =>
                    $this->input
                    ->post('kabupaten'),

                'provinsi' =>
                    $this->input
                    ->post('provinsi'),

                'nomor_mou' =>
                    $this->input
                    ->post('nomor_mou'),

                'judul_pks' =>
                    $this->input
                    ->post('judul_pks'),

                'nama_pic' =>
                    $this->input
                    ->post('nama_pic'),

                'no_hp_pic' =>
                    $this->input
                    ->post('no_hp_pic'),

                'status_kerjasama' =>
                    $this->input
                    ->post('status')
            ];

            $this->Dudi_model
                ->update(
                    $id,
                    $data
                );

            redirect('dudi');
        }

        $data['dudi'] =
            $this->Dudi_model
            ->getById($id);

        template(
            'admin/dudi/edit',
            $data
        );
    }

    // ======================
    // HAPUS
    // ======================
    public function hapus($id)
    {
        $this->Dudi_model
            ->delete($id);

        redirect('dudi');
    }
}