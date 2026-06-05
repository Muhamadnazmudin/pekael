<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pembimbing extends CI_Controller {

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
            'Pembimbing_model'
        );
    }

    // ======================
    // INDEX
    // ======================
    public function index()
    {
        $data['title'] =
            'Pembimbing PKL';

        $data['pembimbing'] =
            $this->Pembimbing_model
            ->getAll();

        $data['kelas'] =
            $this->db
            ->where(
                'status_pkl',
                'ya'
            )
            ->order_by(
                'nama_kelas',
                'ASC'
            )
            ->get(
                'kelas'
            )
            ->result();

        template(
            'admin/pembimbing/index',
            $data
        );
    }

    // ======================
    // GENERATE PER KELAS
    // ======================
    public function generate()
{
    // ======================
    // AMBIL KELAS
    // ======================
    $kelas_id =
        $this->input
        ->post(
            'kelas_id'
        );

    if(!$kelas_id){

        $this->session
        ->set_flashdata(
            'error',
            'Kelas belum dipilih'
        );

        redirect(
            'pembimbing'
        );
    }

    // ======================
    // TAHUN AJARAN AKTIF
    // ======================
    $tahun =
        $this->db
        ->get_where(
            'tahun_ajaran',
            [
                'status' =>
                    'aktif'
            ]
        )
        ->row();

    if(!$tahun){

        $this->session
        ->set_flashdata(
            'error',
            'Tahun ajaran aktif belum ada'
        );

        redirect(
            'pembimbing'
        );
    }

    // ======================
    // KOEFISIEN AKTIF
    // ======================
    $koef =
        $this->db
        ->get_where(
            'koefisien_pkl',
            [
                'tahun_id' =>
                    $tahun->id
            ]
        )
        ->row();

    if(!$koef){

        $this->session
        ->set_flashdata(
            'error',
            'Koefisien PKL belum dihitung'
        );

        redirect(
            'koefisien'
        );
    }

    // ======================
    // JUMLAH SISWA KELAS
    // ======================
    $jumlah_siswa =
        $this->db
        ->where(
            'id_kelas',
            $kelas_id
        )
        ->where(
            'id_tahun',
            $tahun->id
        )
        ->count_all_results(
            'siswa'
        );

    if($jumlah_siswa <= 0){

        $this->session
        ->set_flashdata(
            'error',
            'Belum ada siswa di kelas ini'
        );

        redirect(
            'pembimbing'
        );
    }

    // ======================
    // AMBIL GURU
    // SESUAI KELAS
    // ======================
    $guru =
        $this->db
        ->select('
            guru_id,
            SUM(jumlah_jam)
            as total_jam
        ')
        ->from(
            'pembagian_jam'
        )

        ->where(
            'tahun_id',
            $tahun->id
        )

        ->where(
            'kelas_id',
            $kelas_id
        )

        ->group_by(
            'guru_id'
        )

        ->order_by(
            'total_jam',
            'DESC'
        )

        ->get()
        ->result();

    if(empty($guru)){

        $this->session
        ->set_flashdata(
            'error',
            'Belum ada pembagian jam pada kelas ini'
        );

        redirect(
            'pembimbing'
        );
    }
// ======================
// VALIDASI TOTAL JP
// HARUS SESUAI KOEFISIEN
// ======================
$total_jam_kelas = 0;

foreach(
    $guru
    as $g
){

    $total_jam_kelas +=
        $g->total_jam;
}

// ambil JP wajib
$jp_wajib =
    $koef->jp;

// jika belum sesuai
if(
    $total_jam_kelas
    !=
    $jp_wajib
){

    $kelas =
        $this->db
        ->get_where(
            'kelas',
            [
                'id' =>
                    $kelas_id
            ]
        )
        ->row();

    $this->session
    ->set_flashdata(
        'error',

        'Kelas '
        .$kelas->nama_kelas.
        ' belum bisa digenerate. 
        Total jam saat ini: '
        .$total_jam_kelas.
        ' JP, sedangkan wajib '
        .$jp_wajib.
        ' JP. 
        Silahkan lengkapi pembagian jam terlebih dahulu.'
    );

    redirect(
        'pembimbing'
    );
}
    // ======================
    // HAPUS DATA KELAS INI
    // ======================
    $this->db
        ->delete(
            'pembimbing_pkl',
            [

                'kelas_id' =>
                    $kelas_id,

                'tahun_id' =>
                    $tahun->id
            ]
        );

    $data_generate = [];
    $total_awal = 0;

    // ======================
    // HITUNG AWAL
    // ======================
    foreach($guru as $g){

        $hasil =
            $g->total_jam
            /
            $koef->koefisien;

        // bulat bawah dulu
        $jumlah =
    round(
        $hasil
    );

$desimal =
    $hasil
    -
    floor($hasil);
            if($g->total_jam >= 20){

    $bobot = 3;

}elseif($g->total_jam >= 10){

    $bobot = 2;

}elseif($g->total_jam >= 5){

    $bobot = 1;

}else{

    $bobot = 0;
}

        $data_generate[] = [

            'guru_id' =>
                $g->guru_id,

            'kelas_id' =>
                $kelas_id,

            'tahun_id' =>
                $tahun->id,

            'total_jam' =>
                $g->total_jam,

            'koefisien' =>
                $koef
                ->koefisien,

            'jumlah_bimbingan' =>
                $jumlah,

            'desimal' =>
    $desimal,

'bobot' =>
    $bobot
        ];

        $total_awal +=
            $jumlah;
    }

    // ======================
    // SELISIH SISWA
    // ======================
    $sisa =
        $jumlah_siswa
        -
        $total_awal;
        // ======================
if($sisa < 0){

    // total hasil koefisien
    $total_hasil = 0;

    foreach($data_generate as $g){

        $total_hasil +=
            $g['jumlah_bimbingan'];
    }

    // normalisasi proporsional
    $total_baru = 0;

    foreach($data_generate as $k => $g){

        $ideal =
            (
                $g['jumlah_bimbingan']
                /
                $total_hasil
            )
            *
            $jumlah_siswa;

        $data_generate[$k]['jumlah_bimbingan']
            = floor($ideal);

        $data_generate[$k]['sisa_desimal']
            = $ideal - floor($ideal);

        $total_baru +=
            $data_generate[$k]['jumlah_bimbingan'];
    }

    // sisa pembulatan
    $sisa_bagi =
        $jumlah_siswa
        -
        $total_baru;

    usort(
        $data_generate,
        function($a, $b){

            return
                $b['sisa_desimal']
                <=>
                $a['sisa_desimal'];
        }
    );

    while($sisa_bagi > 0){

        foreach($data_generate as $k => $g){

            $data_generate[$k]
            ['jumlah_bimbingan']++;

            $sisa_bagi--;

            if($sisa_bagi <= 0){
                break 2;
            }
        }
    }
}

    // pecahan terbesar
    usort(
    $data_generate,

    function($a, $b){

        // bobot lebih tinggi dulu
        if(
            $a['bobot']
            !=
            $b['bobot']
        ){

            return
                $b['bobot']
                <=>
                $a['bobot'];
        }

        // lalu jam terbesar
        if(
            $a['total_jam']
            !=
            $b['total_jam']
        ){

            return
                $b['total_jam']
                <=>
                $a['total_jam'];
        }

        // terakhir pecahan
        return
            $b['desimal']
            <=>
            $a['desimal'];
    }
);

    // ======================
    // BAGI SISA
    // ======================
    $i = 0;

    while($sisa > 0){

    foreach($data_generate as $k => $g){

        // hanya guru >= 5 jam
        if($g['total_jam'] < 5){
            continue;
        }

        $data_generate[$k]
        ['jumlah_bimbingan']++;

        $sisa--;

        if($sisa <= 0){
            break 2;
        }
    }
}

    // ======================
    // INSERT DB
    // ======================
    foreach(
        $data_generate
        as $d
    ){
unset($d['sisa_desimal']);
        unset(
    $d['desimal']
);

unset(
    $d['bobot']
);
        $this->db
        ->insert(
            'pembimbing_pkl',
            $d
        );
    }

    $kelas =
        $this->db
        ->get_where(
            'kelas',
            [
                'id' =>
                    $kelas_id
            ]
        )
        ->row();

    $this->session
    ->set_flashdata(
        'success',
        'Generate pembimbing kelas '
        .$kelas->nama_kelas
        .' berhasil'
    );

    redirect(
        'pembimbing'
    );
}

}