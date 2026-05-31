<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Mappingdudi extends CI_Controller {

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
            'Mappingdudi_model'
        );
    }

    // ======================
    // INDEX
    // ======================
    public function index()
{
    $data['title'] =
        'Mapping DUDI';

    $data['dudi'] =
        $this->Mappingdudi_model
        ->getAll();

    // ambil daftar siswa per DUDI
    foreach(
        $data['dudi']
        as $d
    ){

        $d->list_siswa =
            $this->db
            ->select('
                siswa.nama,

                kelas.nama_kelas
            ')
            ->from('siswa')

            ->join(
                'kelas',
                'kelas.id =
                siswa.id_kelas',
                'left'
            )

            ->where(
                'siswa.dudi_id',
                $d->id
            )

            ->order_by(
                'kelas.nama_kelas',
                'ASC'
            )

            ->order_by(
                'siswa.nama',
                'ASC'
            )

            ->get()
            ->result();
    }

    template(
        'admin/mapping_dudi/index',
        $data
    );
}

    // ======================
    // FORM MAPPING
    // ======================
    public function mapping($dudi_id)
    {
        $tahun = $this->db
            ->get_where(
                'tahun_ajaran',
                ['status'=>'aktif']
            )
            ->row();

        $data['dudi'] =
            $this->db
            ->get_where(
                'dudi',
                ['id'=>$dudi_id]
            )
            ->row();
        $data['all_dudi'] =
    $this->db
    ->order_by(
        'nama_dudi',
        'ASC'
    )
    ->get('dudi')
    ->result();
        // siswa yg sudah punya pembimbing
        // dan belum punya DUDI
        $used = $this->db
            ->select(
                'siswa_id'
            )
            ->get(
                'mapping_dudi'
            )
            ->result_array();

        $used_ids =
            !empty($used)
            ?
            array_column(
                $used,
                'siswa_id'
            )
            :
            [0];

        // semua siswa kelas PKL
$data['siswa'] =
    $this->db
    ->select('
        siswa.*,

        kelas.nama_kelas,
        kelas.tingkat,

        jurusan.nama_jurusan,

        dudi.nama_dudi
        as dudi_sekarang
    ')
    ->from('siswa')

    ->join(
        'kelas',
        'kelas.id =
        siswa.id_kelas',
        'left'
    )

    ->join(
        'jurusan',
        'jurusan.id =
        kelas.jurusan_id',
        'left'
    )

    ->join(
        'dudi',
        'dudi.id =
        siswa.dudi_id',
        'left'
    )

    ->where_in(
        'kelas.tingkat',
        ['XII']
    )

    ->order_by(
        'siswa.nama',
        'ASC'
    )

    ->get()
    ->result();

        template(
            'admin/mapping_dudi/mapping',
            $data
        );
    }

    // ======================
    // SIMPAN
    // ======================
    public function simpan()
{
    $dudi_id =
        $this->input
        ->post('dudi_id');

    $siswa =
        $this->input
        ->post('siswa');

    if(!empty($siswa)){

        foreach(
            $siswa
            as $siswa_id
        ){

            $this->db
                ->where(
                    'id',
                    $siswa_id
                )
                ->update(
                    'siswa',
                    [
                        'dudi_id' =>
                            $dudi_id
                    ]
                );
        }
    }

    $this->session
        ->set_flashdata(
            'success',
            'Mapping DUDI berhasil'
        );

    redirect(
        'mappingdudi'
    );
}
public function pilih(
    $dudi_id,
    $siswa_id
)
{
    $this->db
        ->where(
            'id',
            $siswa_id
        )
        ->update(
            'siswa',
            [
                'dudi_id' =>
                    $dudi_id
            ]
        );

    $this->session
        ->set_flashdata(
            'success',
            'DUDI berhasil di-mapping'
        );

    redirect(
        'mappingdudi/mapping/'
        .$dudi_id
    );
}
public function pindahkan()
{
    $siswa_id =
        $this->input
        ->post('siswa_id');

    $dudi_id =
        $this->input
        ->post('dudi_id');

    $this->db
        ->where(
            'id',
            $siswa_id
        )
        ->update(
            'siswa',
            [
                'dudi_id' =>
                    $dudi_id
            ]
        );

    $this->session
        ->set_flashdata(
            'success',
            'DUDI berhasil dipindahkan'
        );

    redirect(
        $_SERVER['HTTP_REFERER']
    );
}
}