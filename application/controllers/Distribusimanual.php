<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Distribusimanual extends CI_Controller {

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
            'Distribusimanual_model'
        );
    }

    // ======================
    // INDEX
    // ======================
    public function index()
    {
        $data['title'] =
            'Distribusi Manual';

        $data['distribusi'] =
            $this->Distribusimanual_model
            ->getAll();

        $tahun = $this->db
            ->get_where(
                'tahun_ajaran',
                ['status'=>'aktif']
            )
            ->row();

        $data['pembimbing'] = $this->db
    ->select('
        guru.id as guru_id,
        guru.nama_guru,
        guru.nip,
        SUM(pembimbing_pkl.jumlah_bimbingan) as kuota
    ')
    ->from('pembimbing_pkl')
    ->join(
        'guru',
        'guru.id = pembimbing_pkl.guru_id'
    )
    ->where(
        'pembimbing_pkl.tahun_id',
        $tahun->id
    )
    ->group_by('guru.id')
    ->order_by('guru.nama_guru','ASC')
    ->get()
    ->result();

        template(
            'admin/distribusi_manual/index',
            $data
        );
    }

    // ======================
    // FORM MAPPING
    // ======================
    public function mapping($guru_id)
    {
        $tahun = $this->db
            ->get_where(
                'tahun_ajaran',
                ['status'=>'aktif']
            )
            ->row();

        $data['guru'] =
            $this->db
            ->get_where(
                'guru',
                ['id'=>$guru_id]
            )
            ->row();

        // koefisien
        $koef = $this->db
            ->get_where(
                'koefisien_pkl',
                [
                    'tahun_id' =>
                    $tahun->id
                ]
            )
            ->row();

        // siswa yg SUDAH dibimbing guru lain
        $used = $this->db
            ->select('siswa_id')
            ->from(
                'distribusi_manual'
            )
            ->where(
                'guru_id !=',
                $guru_id
            )
            ->where(
                'tahun_id',
                $tahun->id
            )
            ->get()
            ->result_array();

        $used_ids =
            !empty($used)
            ?
            array_column(
                $used,
                'siswa_id'
            )
            :
            [0];

        // pembagian jam
        $data['jam'] = $this->db
            ->select('
                pembagian_jam.id,

                pembagian_jam.guru_id,

                pembagian_jam.kelas_id
                AS real_kelas_id,

                pembagian_jam.jumlah_jam,

                kelas.nama_kelas
            ')
            ->from(
                'pembagian_jam'
            )
            ->join(
                'kelas',
                'kelas.id =
                pembagian_jam.kelas_id'
            )
            ->where(
                'pembagian_jam.guru_id',
                $guru_id
            )
            ->where(
                'pembagian_jam.tahun_id',
                $tahun->id
            )
            ->get()
            ->result();

        foreach(
    $data['jam']
    as &$j
){

    // ======================
    // AMBIL JATAH
    // DARI PEMBIMBING PKL
    // ======================
    $pembimbing =
        $this->db
        ->get_where(
            'pembimbing_pkl',
            [

                'guru_id' =>
                    $guru_id,

                'kelas_id' =>
                    $j->real_kelas_id,

                'tahun_id' =>
                    $tahun->id
            ]
        )
        ->row();

    $j->jatah =
        $pembimbing
        ?
        $pembimbing
            ->jumlah_bimbingan
        :
        0;

    // ======================
    // SISWA KELAS
    // ======================
    $this->db
        ->where(
            'id_kelas',
            $j->real_kelas_id
        );

    $this->db
        ->where(
            'id_tahun',
            $tahun->id
        );

    // hide siswa guru lain
    if(!empty($used_ids)){

        $this->db
            ->where_not_in(
                'id',
                $used_ids
            );
    }

    $j->siswa =
        $this->db
        ->get(
            'siswa'
        )
        ->result();

    // ======================
    // MAPPING SUDAH ADA
    // ======================
    $j->selected =
        $this->db
        ->select(
            'siswa_id'
        )
        ->from(
            'distribusi_manual'
        )
        ->where(
            'guru_id',
            $guru_id
        )
        ->where(
            'kelas_id',
            $j->real_kelas_id
        )
        ->where(
            'tahun_id',
            $tahun->id
        )
        ->get()
        ->result_array();
}

        template(
            'admin/distribusi_manual/mapping',
            $data
        );
    }

    // ======================
    // SIMPAN
    // ======================
    public function simpan()
{
    $guru_id =
        $this->input
        ->post('guru_id');

    $tahun = $this->db
        ->get_where(
            'tahun_ajaran',
            ['status'=>'aktif']
        )
        ->row();

    $siswa =
        $this->input
        ->post('siswa');

    if(empty($siswa)){

        $this->session
            ->set_flashdata(
                'error',
                'Tidak ada siswa dipilih'
            );

        redirect(
            'distribusimanual'
        );
    }

    // transaction
    $this->db
        ->trans_start();

    // ======================
    // HAPUS MAPPING GURU
    // ======================
    $this->db->delete(
        'distribusi_manual',
        [
            'guru_id' =>
                $guru_id,

            'tahun_id' =>
                $tahun->id
        ]
    );

    // ======================
    // INSERT BARU
    // ======================
    foreach(
        $siswa
        as $kelas_id
        => $list_siswa
    ){

        foreach(
            $list_siswa
            as $siswa_id
        ){

            // skip jika siswa
            // sudah dibimbing guru lain
            $cek =
                $this->db
                ->where(
                    'siswa_id',
                    $siswa_id
                )
                ->where(
                    'guru_id !=',
                    $guru_id
                )
                ->where(
                    'tahun_id',
                    $tahun->id
                )
                ->get(
                    'distribusi_manual'
                )
                ->row();

            if($cek){
                continue;
            }

            $insert = [

                'guru_id' =>
                    $guru_id,

                'siswa_id' =>
                    $siswa_id,

                'kelas_id' =>
                    $kelas_id,

                'tahun_id' =>
                    $tahun->id
            ];

            $this->db
                ->insert(
                    'distribusi_manual',
                    $insert
                );
        }
    }

    $this->db
        ->trans_complete();

    // cek transaksi
    if(
        $this->db
        ->trans_status()
        === FALSE
    ){

        echo $this->db->error()['message'];
        die;
    }

    $this->session
        ->set_flashdata(
            'success',
            'Mapping berhasil disimpan'
        );

    redirect(
        'distribusimanual'
    );
}
}