<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Koefisien_model extends CI_Model {

    private $table =
        'koefisien_pkl';

    public function getAll()
    {
        return $this->db
            ->select('
                koefisien_pkl.*,
                tahun_ajaran.tahun
            ')
            ->from(
                'koefisien_pkl'
            )
            ->join(
                'tahun_ajaran',
                'tahun_ajaran.id = koefisien_pkl.tahun_id'
            )
            ->order_by(
                'id',
                'DESC'
            )
            ->get()
            ->result();
    }

    public function hitung($tahun_id, $jp = 46)
    {
        // jumlah rombel PKL
        $jumlah_rombel =
            $this->db
            ->where(
                'status_pkl',
                'ya'
            )
            ->count_all_results(
                'kelas'
            );

        // jumlah siswa PKL
        $jumlah_siswa =
            $this->db
            ->where(
                'id_tahun',
                $tahun_id
            )
            ->count_all_results(
                'siswa'
            );

        // hitung koefisien
        $koefisien = 0;

        if(
            $jumlah_siswa > 0
        ){
            $koefisien =
                (
                    $jumlah_rombel
                    *
                    $jp
                )
                /
                $jumlah_siswa;
        }

        return [
            'jumlah_siswa' =>
                $jumlah_siswa,

            'jumlah_rombel' =>
                $jumlah_rombel,

            'jp' =>
                $jp,

            'koefisien' =>
                round(
                    $koefisien,
                    6
                )
        ];
    }
}