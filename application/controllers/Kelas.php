<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Kelas extends CI_Controller {

    public function __construct()
    {
        parent::__construct();

        // 🔐 proteksi admin
        if(!$this->session->userdata('role') || $this->session->userdata('role') != 'admin'){
            redirect('login');
        }
    }

    // ======================
    // LIST DATA
    // ======================
  public function index()
{
    $data['title'] = 'Kelas';

    $data['kelas'] = $this->db
        ->select('
            kelas.*,
            jurusan.nama_jurusan,
            jurusan.singkatan
        ')
        ->from('kelas')
        ->join(
            'jurusan',
            'jurusan.id = kelas.jurusan_id',
            'left'
        )
        ->order_by('kelas.id', 'DESC')
        ->get()
        ->result();

    template('admin/kelas/index', $data);
}

    // ======================
    // TAMBAH
    // ======================
   public function tambah()
{
    if ($this->input->post()) {

        $data = [
            'nama_kelas' =>
                $this->input->post('nama_kelas'),

            'jurusan_id' =>
                $this->input->post('jurusan_id'),

            'tingkat' =>
                $this->input->post('tingkat'),

            'status_pkl' =>
                $this->input->post('status_pkl')
        ];

        $this->db->insert(
            'kelas',
            $data
        );

        redirect('kelas');
    }

    // ambil data jurusan
    $data['jurusan'] =
        $this->db
        ->order_by('nama_jurusan','ASC')
        ->get('jurusan')
        ->result();

    template(
        'admin/kelas/tambah',
        $data
    );
}

    // ======================
    // EDIT
    // ======================
    public function edit($id)
{
    $kelas = $this->db
        ->get_where(
            'kelas',
            ['id' => $id]
        )
        ->row();

    if (!$kelas) {
        show_404();
    }

    if ($this->input->post()) {

        $data = [
            'nama_kelas' =>
                $this->input->post('nama_kelas'),

            'jurusan_id' =>
                $this->input->post('jurusan_id'),

            'tingkat' =>
                $this->input->post('tingkat'),

            'status_pkl' =>
                $this->input->post('status_pkl')
        ];

        $this->db
            ->where('id', $id)
            ->update('kelas', $data);

        redirect('kelas');
    }

    $data['kelas'] = $kelas;

    $data['jurusan'] = $this->db
        ->order_by(
            'nama_jurusan',
            'ASC'
        )
        ->get('jurusan')
        ->result();

    template(
        'admin/kelas/edit',
        $data
    );
}

    // ======================
    // HAPUS
    // ======================
    public function hapus($id)
    {
        $this->db->delete('kelas',['id'=>$id]);
        redirect('kelas');
    }
}