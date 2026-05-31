<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pusatunduhan_model extends CI_Model {

    private $table = 'pusat_unduhan';

    public function get_all()
    {
        return $this->db
            ->order_by('id', 'DESC')
            ->get($this->table)
            ->result();
    }

    public function get($id)
    {
        return $this->db
            ->get_where(
                $this->table,
                ['id' => $id]
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

    public function delete($id)
    {
        return $this->db
            ->delete(
                $this->table,
                ['id' => $id]
            );
    }
}