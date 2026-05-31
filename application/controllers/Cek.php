<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Cek extends CI_Controller {

    public function index()
    {
        $this->load->view('siswa/cek');
    }
    public function dashboard()
{
    if(!$this->session->userdata('nisn')){
        redirect('login');
    }

    $nisn = $this->session->userdata('nisn');

    $data['siswa'] = $this->db->get_where('siswa', [
        'nisn'=>$nisn
    ])->row();

    $this->load->view('siswa/dashboard', $data);
}
    public function hasil()
    {
        $nisn = $this->input->post('nisn');

        $this->db->select('siswa.*, kelulusan.*');
        $this->db->join('kelulusan','kelulusan.id_siswa=siswa.id','left');

        $data['siswa'] = $this->db->get_where('siswa', [
            'nisn' => $nisn
        ])->row();

        if(!$data['siswa']){
            $this->session->set_flashdata('error','NISN tidak ditemukan');
            redirect('cek');
        }

        $this->load->view('siswa/hasil', $data);
    }
    public function bylogin()
{
    if(!$this->session->userdata('nisn')){
        redirect('login');
    }

    $nisn = $this->session->userdata('nisn');

    $this->db->select('siswa.*, kelulusan.*');
    $this->db->join('kelulusan','kelulusan.id_siswa=siswa.id','left');

    $data['siswa'] = $this->db->get_where('siswa', [
        'nisn'=>$nisn
    ])->row();

    $this->load->view('siswa/hasil', $data);
}
}