<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {

    public function __construct()
    {
        parent::__construct();

        // ======================
        // CEK LOGIN ADMIN
        // ======================
        if (
            !$this->session
            ->userdata('role')
            ||
            $this->session
            ->userdata('role')
            != 'admin'
        ){
            redirect('login');
        }
    }

    // ======================
    // DASHBOARD
    // ======================
    public function index()
    {
        $data['title'] =
            'Dashboard';

        // ======================
        // TOTAL GURU
        // ======================
        $data['total_guru'] =
            $this->db
            ->count_all(
                'guru'
            );

        // ======================
        // GURU PEMBIMBING
        // guru yg punya jam
        // di kelas XII PKL
        // ======================
        $data[
            'guru_pembimbing'
        ] =
            $this->db
            ->distinct()

            ->select(
                'pembagian_jam.guru_id'
            )

            ->from(
                'pembagian_jam'
            )

            ->join(
                'kelas',
                'kelas.id =
                pembagian_jam.kelas_id'
            )

            ->where(
                'kelas.tingkat',
                'XII'
            )

            ->where(
                'kelas.status_pkl',
                'ya'
            )

            ->count_all_results();

        // ======================
        // TOTAL SISWA PKL
        // kelas XII PKL
        // ======================
        $data['total_siswa'] =
            $this->db

            ->join(
                'kelas',
                'kelas.id =
                siswa.id_kelas'
            )

            ->where(
                'kelas.tingkat',
                'XII'
            )

            ->where(
                'kelas.status_pkl',
                'ya'
            )

            ->count_all_results(
                'siswa'
            );

        // ======================
        // TOTAL ROMBEL PKL
        // ======================
        $data['total_rombel'] =
            $this->db

            ->where(
                'tingkat',
                'XII'
            )

            ->where(
                'status_pkl',
                'ya'
            )

            ->count_all_results(
                'kelas'
            );

        // ======================
        // KOEFISIEN PKL
        // ======================
        $koef =
            $this->db
            ->get(
                'v_koefisien'
            )
            ->row();

        $data['koefisien'] =
            $koef
            ? $koef->koefisien
            : 0;
        // ======================
// SISWA BELUM DAPAT
// PEMBIMBING
// ======================
$data['belum_pembimbing'] =
    $this->db
    ->select('COUNT(*) as total')
    ->from('siswa')
    ->join(
        'kelas',
        'kelas.id = siswa.id_kelas'
    )
    ->join(
        'distribusi_manual',
        'distribusi_manual.siswa_id = siswa.id',
        'left'
    )
    ->where('kelas.tingkat', 'XII')
    ->where('kelas.status_pkl', 'ya')
    ->where('distribusi_manual.id IS NULL', null, false)
    ->get()
    ->row()
    ->total;
    // ======================
// TOTAL ROMBEL XII
// ======================
$data['total_rombel_semua'] =
    $this->db
    ->where('tingkat', 'XII')
    ->count_all_results('kelas');
    // ======================
// SISWA BELUM DAPAT DUDI
// ======================
$data['belum_dudi'] =
    $this->db
    ->join(
        'kelas',
        'kelas.id = siswa.id_kelas'
    )
    ->where('kelas.tingkat', 'XII')
    ->where('kelas.status_pkl', 'ya')
    ->group_start()
        ->where('siswa.dudi_id IS NULL', null, false)
        ->or_where('siswa.dudi_id', 0)
    ->group_end()
    ->count_all_results('siswa');


    //tampilkan data spesifik

    // ======================
// MONITORING ROMBEL PKL
// ======================

$data['monitoring_rombel'] = $this->db
    ->select("
        kelas.id,
        kelas.nama_kelas,
        COUNT(DISTINCT siswa.id) AS total_siswa,

        SUM(
            CASE
                WHEN siswa.dudi_id IS NULL
                     OR siswa.dudi_id = 0
                THEN 1
                ELSE 0
            END
        ) AS belum_dudi,

        SUM(
            CASE
                WHEN distribusi_manual.id IS NULL
                THEN 1
                ELSE 0
            END
        ) AS belum_pembimbing
    ")
    ->from('kelas')
    ->join(
        'siswa',
        'siswa.id_kelas = kelas.id',
        'left'
    )
    ->join(
        'distribusi_manual',
        'distribusi_manual.siswa_id = siswa.id',
        'left'
    )
    ->where('kelas.tingkat', 'XII')
    ->where('kelas.status_pkl', 'ya')
    ->group_by([
        'kelas.id',
        'kelas.nama_kelas'
    ])
    ->order_by('kelas.id', 'ASC')
    ->get()
    ->result();


// ======================
// DAFTAR SISWA BELUM DUDI
// ======================

foreach ($data['monitoring_rombel'] as &$r) {

    $r->siswa_belum_dudi = $this->db
        ->select('id, nama')
        ->from('siswa')
        ->where('id_kelas', $r->id)
        ->group_start()
            ->where('dudi_id IS NULL', null, false)
            ->or_where('dudi_id', 0)
        ->group_end()
        ->order_by('nama', 'ASC')
        ->get()
        ->result();

    $r->siswa_belum_pembimbing = $this->db
        ->select('siswa.id, siswa.nama')
        ->from('siswa')
        ->join(
            'distribusi_manual',
            'distribusi_manual.siswa_id = siswa.id',
            'left'
        )
        ->where('siswa.id_kelas', $r->id)
        ->where('distribusi_manual.id IS NULL', null, false)
        ->order_by('siswa.nama', 'ASC')
        ->get()
        ->result();
}

unset($r);
// ======================
// TOTAL DUDI AKTIF
// ======================
$data['total_dudi'] = $this->db
    ->where('status_kerjasama', 'aktif')
    ->count_all_results('dudi');
        // ======================
        // LOAD VIEW
        // ======================
        template(
            'admin/dashboard',
            $data
        );
    }
}