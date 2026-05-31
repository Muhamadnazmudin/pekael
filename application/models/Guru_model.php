<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Guru_model extends CI_Model {

    private $table = 'guru';

    public function getAll()
    {
        return $this->db
            ->select('
                guru.*,
                jurusan.nama_jurusan,
                jurusan.singkatan
            ')
            ->from('guru')
            ->join(
                'jurusan',
                'jurusan.id = guru.jurusan_id',
                'left'
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
                ['id' => $id]
            )
            ->row();
    }

    public function insert($data)
    {
        return $this->db
            ->insert($this->table, $data);
    }

    public function update($id, $data)
    {
        return $this->db
            ->where('id', $id)
            ->update($this->table, $data);
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