<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Distribusi_model extends CI_Model {

    private $table = 'distribusi_pkl';

    public function getAll()
    {
        return $this->db
            ->select('
                distribusi_pkl.*,

                guru.nama_guru,
                guru.nip,

                siswa.nama,
                siswa.nisn,

                kelas.nama_kelas,
                jurusan.nama_jurusan,
                jurusan.singkatan,

                tahun_ajaran.tahun
            ')
            ->from(
                'distribusi_pkl'
            )

            ->join(
                'guru',
                'guru.id =
                distribusi_pkl.guru_id'
            )

            ->join(
                'siswa',
                'siswa.id =
                distribusi_pkl.siswa_id'
            )

            ->join(
                'kelas',
                'kelas.id =
                distribusi_pkl.kelas_id'
            )

            ->join(
                'jurusan',
                'jurusan.id =
                kelas.jurusan_id',
                'left'
            )

            ->join(
                'tahun_ajaran',
                'tahun_ajaran.id =
                distribusi_pkl.tahun_id'
            )

            ->order_by(
                'kelas.nama_kelas',
                'ASC'
            )

            ->order_by(
                'guru.nama_guru',
                'ASC'
            )

            ->get()
            ->result();
    }
}