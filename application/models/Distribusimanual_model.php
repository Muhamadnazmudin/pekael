<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Distribusimanual_model extends CI_Model {

    public function getAll()
    {
        return $this->db
            ->select('
                distribusi_manual.*,

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
                'distribusi_manual'
            )

            ->join(
                'guru',
                'guru.id =
                distribusi_manual.guru_id'
            )

            ->join(
                'siswa',
                'siswa.id =
                distribusi_manual.siswa_id'
            )

            ->join(
                'kelas',
                'kelas.id =
                distribusi_manual.kelas_id'
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
                distribusi_manual.tahun_id'
            )

            ->order_by(
                'kelas.nama_kelas',
                'ASC'
            )

            ->get()
            ->result();
    }
}