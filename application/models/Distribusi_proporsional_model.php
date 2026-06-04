<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Distribusi_proporsional_model extends CI_Model {

    public function getAll()
{
    return $this->db
        ->select('
            p.guru_id,
            g.nama_guru,
            g.nip,
            SUM(p.jumlah_bimbingan) as kuota,
            SUM(p.total_jam) as total_jam
        ')
        ->from(
            'pembimbing_pkl_perkelas p'
        )
        ->join(
            'guru g',
            'g.id = p.guru_id'
        )
        ->group_by(
            'p.guru_id'
        )
        ->order_by(
            'g.nama_guru',
            'ASC'
        )
        ->get()
        ->result();
}

}