<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Mappingdudi_model extends CI_Model {

    public function getAll()
    {
        return $this->db
            ->select('
                dudi.id,
                dudi.nama_dudi,
                dudi.nomor_mou,
                dudi.judul_pks,

                COUNT(
                    siswa.id
                ) as total_siswa
            ')

            ->from('dudi')

            ->join(
                'siswa',
                'siswa.dudi_id =
                dudi.id',
                'left'
            )

            ->group_by(
                'dudi.id'
            )

            ->order_by(
                'dudi.nama_dudi',
                'ASC'
            )

            ->get()
            ->result();
    }
}