<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Laporan_propor extends CI_Controller
{
    public function __construct()
{
    parent::__construct();

    if (
        !$this->session->userdata('role')
        || $this->session->userdata('role') != 'admin'
    ) {
        redirect('login');
    }

    $this->load->model('M_laporan_pembimbing_propor');
    $this->load->model('M_rekap_pkl_propor');
}
    public function index()
    {
        redirect('laporan_propor/pembimbing');
    }

    public function pembimbing()
{
    $data['laporan'] =
        $this->M_laporan_pembimbing_propor
        ->get_laporan();

    template(
        'admin/laporan_propor/pembimbing',
        $data
    );
}

    public function rekap()
{
    $data['rekap'] =
        $this->M_rekap_pkl_propor
        ->get_rekap();

    template(
        'admin/laporan_propor/rekap',
        $data
    );
}

    public function excel()
    {
        redirect('laporan_propor/rekap');
    }

    public function pdf()
    {
        redirect('laporan_propor/rekap');
    }
}