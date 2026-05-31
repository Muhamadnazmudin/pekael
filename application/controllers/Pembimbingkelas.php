<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pembimbingkelas extends CI_Controller {

    public function __construct()
    {
        parent::__construct();

        if(
            !$this->session->userdata('role')
            ||
            $this->session->userdata('role') != 'admin'
        ){
            redirect('login');
        }

        $this->load->model(
            'Pembimbingkelas_model'
        );
    }

    public function index()
    {
        $data['title'] =
            'Pembimbing PKL Per Kelas';

        $data['pembimbing'] =
            $this->Pembimbingkelas_model
            ->getAll();

        $data['kelas'] =
            $this->db
            ->where(
                'status_pkl',
                'ya'
            )
            ->order_by(
                'nama_kelas',
                'ASC'
            )
            ->get(
                'kelas'
            )
            ->result();

        template(
            'admin/pembimbingkelas/index',
            $data
        );
    }

    public function generate()
    {
        $kelas_id =
            $this->input
            ->post('kelas_id');

        if(!$kelas_id){

            $this->session
            ->set_flashdata(
                'error',
                'Kelas belum dipilih'
            );

            redirect(
                'pembimbingkelas'
            );
        }

        $tahun =
            $this->db
            ->get_where(
                'tahun_ajaran',
                [
                    'status' => 'aktif'
                ]
            )
            ->row();

        if(!$tahun){

            $this->session
            ->set_flashdata(
                'error',
                'Tahun ajaran aktif belum ada'
            );

            redirect(
                'pembimbingkelas'
            );
        }

        $jumlah_siswa =
            $this->db
            ->where(
                'id_kelas',
                $kelas_id
            )
            ->where(
                'id_tahun',
                $tahun->id
            )
            ->count_all_results(
                'siswa'
            );

        if($jumlah_siswa <= 0){

            $this->session
            ->set_flashdata(
                'error',
                'Belum ada siswa pada kelas ini'
            );

            redirect(
                'pembimbingkelas'
            );
        }

        $guru =
            $this->db
            ->select('
                guru_id,
                SUM(jumlah_jam)
                as total_jam
            ')
            ->from(
                'pembagian_jam'
            )
            ->where(
                'tahun_id',
                $tahun->id
            )
            ->where(
                'kelas_id',
                $kelas_id
            )
            ->group_by(
                'guru_id'
            )
            ->order_by(
                'total_jam',
                'DESC'
            )
            ->get()
            ->result();

        if(empty($guru)){

            $this->session
            ->set_flashdata(
                'error',
                'Belum ada pembagian jam pada kelas ini'
            );

            redirect(
                'pembimbingkelas'
            );
        }

        $this->db
    ->delete(
        'pembimbing_pkl_perkelas',
        [
            'kelas_id' =>
                $kelas_id,

            'tahun_id' =>
                $tahun->id
        ]
    );

        $data_generate = [];

        $total_awal = 0;

        foreach($guru as $g){

            $hasil =
                (
                    $jumlah_siswa
                    / 46
                )
                *
                $g->total_jam;

            $jumlah =
                floor(
                    $hasil
                );

            $desimal =
                $hasil
                -
                $jumlah;

            $data_generate[] = [

                'guru_id' =>
                    $g->guru_id,

                'kelas_id' =>
                    $kelas_id,

                'tahun_id' =>
                    $tahun->id,

                'total_jam' =>
                    $g->total_jam,

                'koefisien' =>
                    46,

                'jumlah_bimbingan' =>
                    $jumlah,

                'desimal' =>
                    $desimal
            ];

            $total_awal +=
                $jumlah;
        }

        $sisa =
            $jumlah_siswa
            -
            $total_awal;

        usort(
            $data_generate,

            function($a,$b){

                return
                    $b['desimal']
                    <=>
                    $a['desimal'];
            }
        );

        $i = 0;

        while($sisa > 0){

            if(
                !isset(
                    $data_generate[$i]
                )
            ){
                $i = 0;
            }

            $data_generate[$i]
            ['jumlah_bimbingan']++;

            $sisa--;
            $i++;
        }

        foreach(
            $data_generate
            as $d
        ){

            unset(
                $d['desimal']
            );

            $this->db
->insert(
    'pembimbing_pkl_perkelas',
    $d
);
        }

        $kelas =
            $this->db
            ->get_where(
                'kelas',
                [
                    'id' =>
                        $kelas_id
                ]
            )
            ->row();

        $this->session
        ->set_flashdata(
            'success',
            'Generate Per Kelas '
            .$kelas->nama_kelas.
            ' berhasil'
        );

        redirect(
            'pembimbingkelas'
        );
    }

}