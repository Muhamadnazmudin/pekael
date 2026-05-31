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
        // LOAD VIEW
        // ======================
        template(
            'admin/dashboard',
            $data
        );
    }
}