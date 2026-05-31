<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Users extends CI_Controller {

    public function __construct()
    {
        parent::__construct();

        if(
            !$this->session->userdata('role')
            ||
            $this->session->userdata('role') != 'admin'
        ){
            redirect('login');
        }

        $this->load->model(
            'Users_model'
        );
    }

    public function index()
    {
        $data['title'] =
            'Manajemen User';

        $data['users'] =
            $this->Users_model
            ->getAll();

        template(
            'admin/users/index',
            $data
        );
    }

    public function tambah()
    {
        $insert = [

            'username' =>
                $this->input->post('username'),

            'password' =>
                password_hash(
                    $this->input->post('password'),
                    PASSWORD_DEFAULT
                ),

            'role' =>
                $this->input->post('role'),

            'created_at' =>
                date('Y-m-d H:i:s')
        ];

        $this->db
            ->insert(
                'users',
                $insert
            );

        $this->session
            ->set_flashdata(
                'success',
                'User berhasil ditambahkan'
            );

        redirect('users');
    }

    public function edit($id)
    {
        $user =
            $this->db
            ->get_where(
                'users',
                [
                    'id' => $id
                ]
            )
            ->row();

        if(!$user){
            show_404();
        }

        $update = [

            'username' =>
                $this->input->post('username'),

            'role' =>
                $this->input->post('role')
        ];

        if(
            !empty(
                $this->input
                ->post('password')
            )
        ){
            $update['password'] =
                password_hash(
                    $this->input->post('password'),
                    PASSWORD_DEFAULT
                );
        }

        $this->db
            ->where(
                'id',
                $id
            )
            ->update(
                'users',
                $update
            );

        $this->session
            ->set_flashdata(
                'success',
                'User berhasil diupdate'
            );

        redirect('users');
    }

    public function hapus($id)
    {
        if(
            $id ==
            $this->session
            ->userdata('user_id')
        ){

            $this->session
            ->set_flashdata(
                'error',
                'Tidak dapat menghapus akun sendiri'
            );

            redirect('users');
        }

        $this->db
            ->delete(
                'users',
                [
                    'id' => $id
                ]
            );

        $this->session
            ->set_flashdata(
                'success',
                'User berhasil dihapus'
            );

        redirect('users');
    }
}