<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Distribusi_proporsional extends CI_Controller {

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
            'Distribusi_proporsional_model'
        );
    }

    public function index()
    {
        $data['title'] =
            'Distribusi Proporsional';

        $data['data'] =
            $this->Distribusi_proporsional_model
            ->getAll();

        template(
            'admin/distribusi_proporsional/index',
            $data
        );
    }

    public function mapping($guru_id)
{
    $tahun =
        $this->db
        ->get_where(
            'tahun_ajaran',
            [
                'status' => 'aktif'
            ]
        )
        ->row();

    if(!$tahun){
        redirect('tahun');
    }

    $data['guru'] =
        $this->db
        ->get_where(
            'guru',
            [
                'id' => $guru_id
            ]
        )
        ->row();

    if(!$data['guru']){
        redirect(
            'distribusi_proporsional'
        );
    }

    $jam =
        $this->db
        ->select('
            p.*,
            kelas.nama_kelas
        ')
        ->from(
            'pembimbing_pkl_perkelas p'
        )
        ->join(
            'kelas',
            'kelas.id = p.kelas_id'
        )
        ->where(
            'p.guru_id',
            $guru_id
        )
        ->where(
            'p.tahun_id',
            $tahun->id
        )
        ->order_by(
            'kelas.nama_kelas',
            'ASC'
        )
        ->get()
        ->result();

    $used_siswa =
        $this->db
        ->select(
            'siswa_id'
        )
        ->from(
            'distribusi_pkl'
        )
        ->where(
            'tahun_id',
            $tahun->id
        )
        ->get()
        ->result_array();

    $used_ids =
        array_column(
            $used_siswa,
            'siswa_id'
        );

    foreach($jam as &$j){

        $j->jatah =
            $j->jumlah_bimbingan;

        $j->real_kelas_id =
            $j->kelas_id;

        $j->selected =
            $this->db
            ->select(
                'siswa_id'
            )
            ->from(
                'distribusi_pkl'
            )
            ->where(
                'guru_id',
                $guru_id
            )
            ->where(
                'kelas_id',
                $j->kelas_id
            )
            ->where(
                'tahun_id',
                $tahun->id
            )
            ->get()
            ->result_array();

        $selected_ids =
            array_column(
                $j->selected,
                'siswa_id'
            );

        $this->db
            ->where(
                'id_kelas',
                $j->kelas_id
            )
            ->where(
                'id_tahun',
                $tahun->id
            );

        if(!empty($used_ids)){

            $this->db
            ->group_start();

                $this->db
                ->where_not_in(
                    'id',
                    $used_ids
                );

                if(
                    !empty(
                        $selected_ids
                    )
                ){

                    $this->db
                    ->or_where_in(
                        'id',
                        $selected_ids
                    );
                }

            $this->db
            ->group_end();
        }

        $j->siswa =
            $this->db
            ->order_by(
                'nama',
                'ASC'
            )
            ->get(
                'siswa'
            )
            ->result();
    }

    $data['jam'] =
        $jam;

    $data['title'] =
        'Mapping Distribusi Proporsional';

    template(
        'admin/distribusi_proporsional/mapping',
        $data
    );
}

   public function simpan()
{
    $guru_id =
        $this->input->post(
            'guru_id'
        );

    $tahun =
        $this->db
        ->get_where(
            'tahun_ajaran',
            [
                'status' => 'aktif'
            ]
        )
        ->row();

    if(!$tahun){
        redirect('tahun');
    }

    $this->db
        ->where(
            'guru_id',
            $guru_id
        )
        ->where(
            'tahun_id',
            $tahun->id
        )
        ->delete(
            'distribusi_pkl'
        );

    $siswa =
        $this->input->post(
            'siswa'
        );

    if($siswa){

        foreach(
            $siswa
            as $kelas_id => $list_siswa
        ){

            foreach(
                $list_siswa
                as $siswa_id
            ){

                $this->db
                ->insert(
                    'distribusi_pkl',
                    [

                        'guru_id' =>
                            $guru_id,

                        'siswa_id' =>
                            $siswa_id,

                        'kelas_id' =>
                            $kelas_id,

                        'tahun_id' =>
                            $tahun->id
                    ]
                );
            }
        }
    }

    $this->session
    ->set_flashdata(
        'success',
        'Mapping berhasil disimpan'
    );

    redirect(
        'distribusi_proporsional/mapping/'
        .$guru_id
    );
}
    public function reset()
    {
        $tahun =
            $this->db
            ->get_where(
                'tahun_ajaran',
                [
                    'status' => 'aktif'
                ]
            )
            ->row();

        if($tahun){

            $this->db
->where(
    'tahun_id',
    $tahun->id
)
->delete(
    'distribusi_pkl'
);
        }

        $this->session
        ->set_flashdata(
            'success',
            'Distribusi proporsional berhasil direset'
        );

        redirect(
            'distribusi_proporsional'
        );
    }

    public function hapus($id)
    {
        $row =
    $this->db
    ->get_where(
        'distribusi_pkl',
        [
            'id' => $id
        ]
    )
    ->row();

        if(!$row){

            redirect(
                'distribusi_proporsional'
            );
        }

        $guru_id =
            $row->guru_id;

        $this->db
            ->delete(
                'distribusi_pkl',
                [
                    'id' => $id
                ]
            );

        redirect(
            'distribusi_proporsional/mapping/'
            .$guru_id
        );
    }
}