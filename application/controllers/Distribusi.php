<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Distribusi extends CI_Controller {

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
            'Distribusi_model'
        );
    }

    // ======================
    // INDEX
    // ======================
    public function index()
    {
        $data['title'] =
            'Distribusi PKL';

        $data['distribusi'] =
            $this->Distribusi_model
            ->getAll();

        template(
            'admin/distribusi/index',
            $data
        );
    }

    // ======================
    // GENERATE
    // ======================
    public function generate()
{
    $tahun = $this->db
        ->get_where(
            'tahun_ajaran',
            ['status'=>'aktif']
        )
        ->row();

    if(!$tahun){
        redirect('tahun');
    }

    // reset distribusi lama
    $this->db->delete(
        'distribusi_pkl',
        [
            'tahun_id' =>
            $tahun->id
        ]
    );

    // ambil koefisien aktif
    $koef = $this->db
        ->get_where(
            'koefisien_pkl',
            [
                'tahun_id' =>
                $tahun->id
            ]
        )
        ->row();

    if(!$koef){
        redirect('koefisien');
    }

    // pembagian jam
    $jam = $this->db
        ->select('
            pembagian_jam.*,
            guru.jurusan_id
        ')
        ->from(
            'pembagian_jam'
        )
        ->join(
            'guru',
            'guru.id =
            pembagian_jam.guru_id'
        )
        ->where(
            'pembagian_jam.tahun_id',
            $tahun->id
        )
        ->order_by(
            'kelas_id',
            'ASC'
        )
        ->get()
        ->result();

    // penampung siswa yg sudah kebagi
    $used_siswa = [];

    foreach($jam as $j){

        // ======================
        // HITUNG JATAH SISWA
        // ======================
        $jatah = 0;

        if(
            $koef->koefisien > 0
        ){

            $jatah =
                round(
                    $j->jumlah_jam
                    /
                    $koef->koefisien
                );
        }

        // ======================
        // AMBIL SISWA KELAS
        // ======================
        $this->db
            ->where(
                'id_kelas',
                $j->kelas_id
            );

        $this->db
            ->where(
                'id_tahun',
                $tahun->id
            );

        // jangan ambil siswa yg sudah kebagi
        if(
            !empty(
                $used_siswa
            )
        ){

            $this->db
                ->where_not_in(
                    'id',
                    $used_siswa
                );
        }

        $siswa = $this->db
            ->get('siswa')
            ->result();

        $ambil = 0;

        foreach($siswa as $s){

            if(
                $ambil >=
                $jatah
            ){
                break;
            }

            $this->db
                ->insert(
                    'distribusi_pkl',
                    [

                        'guru_id' =>
                            $j->guru_id,

                        'siswa_id' =>
                            $s->id,

                        'kelas_id' =>
                            $j->kelas_id,

                        'tahun_id' =>
                            $tahun->id
                    ]
                );

            // tandai siswa sudah kebagi
            $used_siswa[] =
                $s->id;

            $ambil++;
        }
    }

    redirect(
        'distribusi'
    );
}
public function reset()
{
    $tahun = $this->db
        ->get_where(
            'tahun_ajaran',
            ['status'=>'aktif']
        )
        ->row();

    if($tahun){

        $this->db->delete(
            'distribusi_pkl',
            [
                'tahun_id' =>
                $tahun->id
            ]
        );
    }

    redirect('distribusi');
}
}