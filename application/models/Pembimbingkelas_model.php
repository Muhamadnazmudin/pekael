<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pembimbingkelas_model extends CI_Model {

    public function getAll()
    {
        return $this->db
            ->select('
                pembimbing_pkl_perkelas.*,
                guru.nama_guru,
                guru.nip,
                tahun_ajaran.tahun,
                kelas.nama_kelas
            ')
            ->from(
                'pembimbing_pkl_perkelas'
            )

            ->join(
                'guru',
                'guru.id =
                pembimbing_pkl_perkelas.guru_id'
            )

            ->join(
                'tahun_ajaran',
                'tahun_ajaran.id =
                pembimbing_pkl_perkelas.tahun_id'
            )

            ->join(
                'kelas',
                'kelas.id =
                pembimbing_pkl_perkelas.kelas_id',
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