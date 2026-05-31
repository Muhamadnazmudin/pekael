<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pusatunduhan extends CI_Controller {

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
            'Pusatunduhan_model',
            'unduhan'
        );
    }

    public function index()
    {
        $data['title'] = 'Pusat Unduhan';

        $data['files'] =
            $this->unduhan->get_all();

        template(
            'admin/pusat_unduhan/index',
            $data
        );
    }

    public function upload()
    {
        $config['upload_path'] =
            './uploads/unduhan/';

        $config['allowed_types'] =
            'pdf|doc|docx|xls|xlsx|zip|rar';

        $config['encrypt_name'] =
            TRUE;

        $this->load->library(
            'upload',
            $config
        );

        if(
            !$this->upload->do_upload('file')
        ){
            $this->session->set_flashdata(
                'error',
                $this->upload->display_errors()
            );

            redirect('pusatunduhan');
        }

        $upload =
            $this->upload->data();

        $data = [
            'judul' =>
                $this->input->post('judul'),

            'kategori' =>
                $this->input->post('kategori'),

            'file' =>
                $upload['file_name'],

            'ukuran_file' =>
                round(
                    $upload['file_size']/1024,
                    2
                ).' MB'
        ];

        $this->unduhan->insert($data);

        $this->session->set_flashdata(
            'success',
            'File berhasil diupload'
        );

        redirect('pusatunduhan');
    }

    public function download($id)
{
    $file = $this->unduhan->get($id);

    if (!$file) {
        show_404();
    }

    $path = FCPATH . 'uploads/unduhan/' . $file->file;

    if (!file_exists($path)) {
        show_error('File tidak ditemukan.');
    }

    header('Content-Description: File Transfer');
    header('Content-Type: application/octet-stream');
    header('Content-Disposition: attachment; filename="' . basename($path) . '"');
    header('Content-Length: ' . filesize($path));

    readfile($path);
    exit;
}

    public function hapus($id)
    {
        $file =
            $this->unduhan->get($id);

        if($file){

            @unlink(
                './uploads/unduhan/'.
                $file->file
            );

            $this->unduhan->delete($id);
        }

        redirect('pusatunduhan');
    }
}