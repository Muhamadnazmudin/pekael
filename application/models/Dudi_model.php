<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dudi_model extends CI_Model {

    public function getAll()
    {
        return $this->db
            ->order_by(
                'nama_dudi',
                'ASC'
            )
            ->get('dudi')
            ->result();
    }

    public function getById($id)
    {
        return $this->db
            ->get_where(
                'dudi',
                ['id'=>$id]
            )
            ->row();
    }

    public function insert($data)
    {
        return $this->db
            ->insert(
                'dudi',
                $data
            );
    }

    public function update($id, $data)
    {
        return $this->db
            ->where('id',$id)
            ->update(
                'dudi',
                $data
            );
    }

    public function delete($id)
    {
        return $this->db
            ->delete(
                'dudi',
                ['id'=>$id]
            );
    }
}