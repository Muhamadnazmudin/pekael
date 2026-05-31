<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pembimbing_model extends CI_Model {

    public function getAll()
    {
        return $this->db
            ->select('
                pembimbing_pkl.*,
                guru.nama_guru,
                guru.nip,
                tahun_ajaran.tahun,
                kelas.nama_kelas
            ')
            ->from(
                'pembimbing_pkl'
            )

            ->join(
                'guru',
                'guru.id =
                pembimbing_pkl.guru_id'
            )

            ->join(
                'tahun_ajaran',
                'tahun_ajaran.id =
                pembimbing_pkl.tahun_id'
            )

            ->join(
                'kelas',
                'kelas.id =
                pembimbing_pkl.kelas_id',
                'left'
            )

            ->order_by(
                'kelas.nama_kelas',
                'ASC'
            )

            ->order_by(
                'jumlah_bimbingan',
                'DESC'
            )

            ->get()
            ->result();
    }
}