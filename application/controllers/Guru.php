<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Guru extends CI_Controller {

    public function __construct()
    {
        parent::__construct();

        if (
            !$this->session->userdata('role')
            ||
            $this->session->userdata('role')
            != 'admin'
        ){
            redirect('login');
        }

        $this->load->model(
            'Guru_model'
        );
        $this->load->library('pagination');
    }

    // ======================
    // INDEX
    // ======================
    public function index()
{
    $data['title'] = 'Data Guru';
    $keyword = trim($this->input->get('keyword'));

    $this->db->from('guru');

if ($keyword) {
    $this->db->group_start();
    $this->db->like('nama_guru', $keyword);
    $this->db->or_like('nip', $keyword);
    $this->db->group_end();
}

$jumlah_data = $this->db->count_all_results();

    $config['base_url'] = base_url('guru/index');
    $config['reuse_query_string'] = TRUE;
    $config['total_rows'] = $jumlah_data;
    $config['per_page'] = 20;
    $config['uri_segment'] = 3;

    // Bootstrap SB Admin
    $config['full_tag_open'] = '<nav><ul class="pagination justify-content-center">';
$config['full_tag_close'] = '</ul></nav>';

$config['first_link'] = 'First';
$config['last_link']  = 'Last';
$config['next_link']  = '&raquo;';
$config['prev_link']  = '&laquo;';

$config['first_tag_open'] = '<li class="page-item">';
$config['first_tag_close'] = '</li>';

$config['last_tag_open'] = '<li class="page-item">';
$config['last_tag_close'] = '</li>';

$config['next_tag_open'] = '<li class="page-item">';
$config['next_tag_close'] = '</li>';

$config['prev_tag_open'] = '<li class="page-item">';
$config['prev_tag_close'] = '</li>';

$config['cur_tag_open'] = '<li class="page-item active"><span class="page-link">';
$config['cur_tag_close'] = '</span></li>';

$config['num_tag_open'] = '<li class="page-item">';
$config['num_tag_close'] = '</li>';

$config['attributes'] = ['class' => 'page-link'];

    $this->pagination->initialize($config);

    $page = $this->uri->segment(3);

    if (!$page) {
        $page = 0;
    }

    $this->db
    ->select('guru.*, jurusan.singkatan')
    ->from('guru')
    ->join(
        'jurusan',
        'jurusan.id = guru.jurusan_id',
        'left'
    );

if ($keyword) {

    $this->db->group_start();
    $this->db->like('nama_guru', $keyword);
    $this->db->or_like('nip', $keyword);
    $this->db->group_end();
}

$data['guru'] = $this->db
    ->limit(
        $config['per_page'],
        $page
    )
    ->get()
    ->result();

    $data['pagination'] =
        $this->pagination->create_links();

    $data['no'] = $page + 1;

    template(
        'admin/guru/index',
        $data
    );
}

    // ======================
    // TAMBAH
    // ======================
    public function tambah()
{
    if ($this->input->post()) {

        $data = [

            'nip' =>
                $this->input
                ->post('nip'),

            'nama_guru' =>
                $this->input
                ->post('nama_guru'),

            'jurusan_id' =>
                $this->input
                ->post('jurusan_id')
                ? $this->input
                    ->post('jurusan_id')
                : NULL,

            'jenis_guru' =>
                $this->input
                ->post('jenis_guru'),

            'status' =>
                $this->input
                ->post('status')
        ];

        $this->Guru_model
            ->insert($data);

        redirect('guru');
    }

    $data['jurusan'] =
        $this->db
        ->get('jurusan')
        ->result();

    template(
        'admin/guru/tambah',
        $data
    );
}

    // ======================
    // EDIT
    // ======================
    public function edit($id)
    {
        $guru =
            $this->Guru_model
            ->getById($id);

        if (!$guru) {
            show_404();
        }

        if ($this->input->post()) {

            $data = [
                'nip' =>
                    $this->input
                    ->post('nip'),

                'nama_guru' =>
                    $this->input
                    ->post('nama_guru'),

                'jurusan_id' =>
$this->input->post('jurusan_id')
? $this->input->post('jurusan_id')
: NULL,

                'jenis_guru' =>
                    $this->input
                    ->post('jenis_guru'),

                'status' =>
                    $this->input
                    ->post('status')
            ];

            $this->Guru_model
                ->update($id, $data);

            redirect('guru');
        }

        $data['guru'] = $guru;

        $data['jurusan'] =
            $this->db
            ->get('jurusan')
            ->result();

        template(
            'admin/guru/edit',
            $data
        );
    }

    // ======================
    // HAPUS
    // ======================
    public function hapus($id)
{
    $guru = $this->Guru_model
        ->getById($id);

    if(!$guru){
        show_404();
    }

    $this->Guru_model
        ->delete($id);

    redirect('guru');
}
}