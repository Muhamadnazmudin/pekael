<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pembagianjam_model extends CI_Model {

    private $table =
        'pembagian_jam';

    public function getAll()
    {
        return $this->db
            ->select('
                pembagian_jam.*,

                guru.nama_guru,

                kelas.nama_kelas,
                kelas.tingkat,

                jurusan.nama_jurusan,
                jurusan.singkatan,

                tahun_ajaran.tahun,

                koefisien_pkl.jp
            ')
            ->from(
                'pembagian_jam'
            )

            ->join(
                'guru',
                'guru.id =
                pembagian_jam.guru_id'
            )

            ->join(
                'kelas',
                'kelas.id =
                pembagian_jam.kelas_id'
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
                pembagian_jam.tahun_id'
            )

            ->join(
                'koefisien_pkl',
                'koefisien_pkl.tahun_id =
                pembagian_jam.tahun_id',
                'left'
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

    public function getById($id)
    {
        return $this->db
            ->get_where(
                $this->table,
                [
                    'id' => $id
                ]
            )
            ->row();
    }

    public function insert($data)
    {
        return $this->db
            ->insert(
                $this->table,
                $data
            );
    }

    public function update($id, $data)
    {
        return $this->db
            ->where(
                'id',
                $id
            )
            ->update(
                $this->table,
                $data
            );
    }

    public function delete($id)
    {
        return $this->db
            ->delete(
                $this->table,
                [
                    'id' => $id
                ]
            );
    }
}