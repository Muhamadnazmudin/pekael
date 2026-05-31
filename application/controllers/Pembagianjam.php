<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pembagianjam extends CI_Controller {

    public function __construct()
    {
        parent::__construct();

        if(
            !$this->session
            ->userdata('role')
            ||
            $this->session
            ->userdata('role')
            != 'admin'
        ){
            redirect('login');
        }

        $this->load->model(
            'Pembagianjam_model'
        );
    }

    // ======================
    // INDEX
    // ======================
    public function index()
    {
        $data['title'] =
            'Pembagian Jam';

        $data['jam'] =
            $this->Pembagianjam_model
            ->getAll();

        // guru aktif
        $data['guru'] =
            $this->db
            ->where(
                'status',
                'aktif'
            )
            ->order_by(
                'nama_guru',
                'ASC'
            )
            ->get('guru')
            ->result();

        template(
            'admin/pembagian_jam/index',
            $data
        );
    }

    // ======================
    // SIMPAN AJAX
    // ======================
    public function simpan_ajax()
{
    try {

        $guru_id =
            $this->input
            ->post(
                'guru_id'
            );

        $kelas_id =
            $this->input
            ->post(
                'kelas_id'
            );

        $jumlah_jam =
            $this->input
            ->post(
                'jumlah_jam'
            );

        // validasi
        if(
            empty($guru_id)
            ||
            empty($kelas_id)
            ||
            empty($jumlah_jam)
        ){

            echo json_encode([
                'status' => false,
                'message' =>
                    'Data tidak lengkap'
            ]);

            return;
        }

        // cari tahun aktif
        $tahun =
            $this->db
            ->where(
                'status',
                'aktif'
            )
            ->get(
                'tahun_ajaran'
            )
            ->row();

        // jika tidak ada tahun aktif
        if(!$tahun){

            echo json_encode([
                'status' => false,
                'message' =>
                    'Tahun aktif belum ada'
            ]);

            return;
        }

        // simpan
        $save =
            $this->Pembagianjam_model
            ->insert([

                'guru_id' =>
                    $guru_id,

                'kelas_id' =>
                    $kelas_id,

                'tahun_id' =>
                    $tahun->id,

                'jumlah_jam' =>
                    $jumlah_jam
            ]);

        echo json_encode([
            'status' => $save
        ]);

    } catch(Exception $e){

        echo json_encode([

            'status' => false,

            'message' =>
                $e->getMessage()
        ]);
    }
}

    // ======================
    // TAMBAH (lama)
    // ======================
    public function tambah()
    {
        if($_POST){

            $this->Pembagianjam_model
                ->insert([

                    'guru_id' =>
                        $this->input
                        ->post(
                            'guru'
                        ),

                    'kelas_id' =>
                        $this->input
                        ->post(
                            'kelas'
                        ),

                    'tahun_id' =>
                        $this->input
                        ->post(
                            'tahun'
                        ),

                    'jumlah_jam' =>
                        $this->input
                        ->post(
                            'jumlah_jam'
                        )
                ]);

            redirect(
                'pembagianjam'
            );
        }

        $data['guru'] =
            $this->db
            ->where(
                'status',
                'aktif'
            )
            ->order_by(
                'nama_guru',
                'ASC'
            )
            ->get('guru')
            ->result();

        $data['kelas'] =
            $this->db
            ->where(
                'tingkat',
                'XII'
            )
            ->where(
                'status_pkl',
                'ya'
            )
            ->get('kelas')
            ->result();

        $data['tahun'] =
            $this->db
            ->get(
                'tahun_ajaran'
            )
            ->result();

        template(
            'admin/pembagian_jam/tambah',
            $data
        );
    }

    // ======================
    // HAPUS
    // ======================
    public function hapus($id)
    {
        $this->Pembagianjam_model
            ->delete($id);

        $this->session
            ->set_flashdata(
                'success',
                'Data berhasil dihapus'
            );

        redirect(
            'pembagianjam'
        );
    }
}