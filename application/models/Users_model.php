<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Users_model extends CI_Model {

    public function getAll()
    {
        return $this->db
            ->order_by(
                'id',
                'DESC'
            )
            ->get(
                'users'
            )
            ->result();
    }
}