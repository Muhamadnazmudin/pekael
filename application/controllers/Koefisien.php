<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Koefisien extends CI_Controller {

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
            'Koefisien_model'
        );
    }

    // ======================
    // INDEX
    // ======================
    public function index()
    {
        $data['title'] =
            'Koefisien PKL';

        $data['koefisien'] =
            $this->Koefisien_model
            ->getAll();

        template(
            'admin/koefisien/index',
            $data
        );
    }

    // ======================
    // HITUNG
    // ======================
    public function hitung()
    {
        $tahun_aktif =
            $this->db
            ->get_where(
                'tahun_ajaran',
                [
                    'status' =>
                        'aktif'
                ]
            )
            ->row();

        if(!$tahun_aktif){

            $this->session
            ->set_flashdata(
                'error',
                'Tahun ajaran aktif belum ada'
            );

            redirect(
                'koefisien'
            );
        }

        $jp =
            $this->input
            ->post('jp')
            ?: 46;

        $hasil =
            $this->Koefisien_model
            ->hitung(
                $tahun_aktif->id,
                $jp
            );

        // cek sudah ada
        $cek =
            $this->db
            ->get_where(
                'koefisien_pkl',
                [
                    'tahun_id' =>
                        $tahun_aktif->id
                ]
            )
            ->row();

        $data = [

            'tahun_id' =>
                $tahun_aktif->id,

            'jumlah_siswa' =>
                $hasil[
                    'jumlah_siswa'
                ],

            'jumlah_rombel' =>
                $hasil[
                    'jumlah_rombel'
                ],

            'jp' =>
                $hasil[
                    'jp'
                ],

            'koefisien' =>
                $hasil[
                    'koefisien'
                ]
        ];

        if($cek){

            $this->db
            ->where(
                'id',
                $cek->id
            )
            ->update(
                'koefisien_pkl',
                $data
            );

        } else {

            $this->db
            ->insert(
                'koefisien_pkl',
                $data
            );
        }

        redirect(
            'koefisien'
        );
    }
}