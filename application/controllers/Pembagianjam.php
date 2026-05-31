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

        $data['kelas'] =
    $this->db
    ->where('tingkat','XII')
    ->where('status_pkl','ya')
    ->order_by('nama_kelas','ASC')
    ->get('kelas')
    ->result();

$data['pengaturan_pkl'] =
    $this->db
    ->limit(1)
    ->get('pengaturan_pkl')
    ->row();
    
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
    public function update_ajax()
{
    $guru_id = $this->input->post('guru_id');
    $kelas_id = $this->input->post('kelas_id');
    $jumlah_jam = (int)$this->input->post('jumlah_jam');

    // ambil pengaturan
    $pengaturan = $this->db
        ->limit(1)
        ->get('pengaturan_pkl')
        ->row();

    $jp_maksimal = (int)$pengaturan->jam_pkl;

    // cek data lama guru-kelas
    $cek = $this->db
        ->where('guru_id', $guru_id)
        ->where('kelas_id', $kelas_id)
        ->get('pembagian_jam')
        ->row();

    // total kelas saat ini
    $totalKelas = $this->db
        ->select_sum('jumlah_jam')
        ->where('kelas_id', $kelas_id)
        ->get('pembagian_jam')
        ->row();

    $totalSaatIni = (int)$totalKelas->jumlah_jam;

    $nilaiLama = $cek
        ? (int)$cek->jumlah_jam
        : 0;

    $totalBaru =
        $totalSaatIni
        - $nilaiLama
        + $jumlah_jam;

    if($totalBaru > $jp_maksimal){

        echo json_encode([
            'status' => false,
            'message' =>
                'Maaf, total JP kelas tidak boleh lebih dari '
                .$jp_maksimal
        ]);

        return;
    }

    // hapus jika 0
    if($jumlah_jam <= 0){

        if($cek){

            $this->db
                ->where('id', $cek->id)
                ->delete('pembagian_jam');
        }

        echo json_encode([
            'status' => true
        ]);

        return;
    }

    // tahun aktif
    $tahun = $this->db
        ->where('status','aktif')
        ->get('tahun_ajaran')
        ->row();

    if(!$tahun){

        echo json_encode([
            'status' => false,
            'message' => 'Tahun aktif tidak ditemukan'
        ]);

        return;
    }

    // update
    if($cek){

        $this->db
            ->where('id',$cek->id)
            ->update(
                'pembagian_jam',
                [
                    'jumlah_jam' => $jumlah_jam
                ]
            );

    }else{

        $this->db
            ->insert(
                'pembagian_jam',
                [
                    'guru_id'    => $guru_id,
                    'kelas_id'   => $kelas_id,
                    'tahun_id'   => $tahun->id,
                    'jumlah_jam' => $jumlah_jam
                ]
            );
    }

    echo json_encode([
        'status' => true
    ]);
}
}