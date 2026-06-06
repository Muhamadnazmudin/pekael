<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_rekap_pkl_propor extends CI_Model
{
    public function get_rekap()
    {
        return $this->db
            ->select('
                distribusi_pkl.id,

                siswa.nama,
                siswa.nisn,

                kelas.nama_kelas AS kelas,

                guru.nama_guru AS pembimbing,

                dudi.nama_dudi AS dudi,
                dudi.nomor_mou,
                dudi.judul_pks
            ')
            ->from('distribusi_pkl')

            ->join(
                'siswa',
                'siswa.id = distribusi_pkl.siswa_id'
            )

            ->join(
                'guru',
                'guru.id = distribusi_pkl.guru_id'
            )

            ->join(
                'kelas',
                'kelas.id = distribusi_pkl.kelas_id'
            )

            ->join(
                'dudi',
                'dudi.id = siswa.dudi_id',
                'left'
            )

            ->order_by(
                'kelas.nama_kelas',
                'ASC'
            )

            ->order_by(
                'siswa.nama',
                'ASC'
            )

            ->get()
            ->result_array();
    }
}