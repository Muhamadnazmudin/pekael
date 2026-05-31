<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class LaporanPembimbing extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();

        if(
            !$this->session->userdata('role')
            || $this->session->userdata('role') != 'admin'
        ){
            redirect('login');
        }

        $this->load->model(
            'M_laporan_pembimbing'
        );
    }

    public function index()
    {
        $data['laporan'] =
            $this->M_laporan_pembimbing
            ->get_laporan();

        // active sidebar
        $data['laporan_menu'] = true;
        $data['sub'] = 'pembimbing';

        template(
            'admin/laporan_pembimbing/index',
            $data
        );
    }
}