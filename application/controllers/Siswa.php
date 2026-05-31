<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Siswa extends CI_Controller {

    public function __construct()
    {
        parent::__construct();

        if(!$this->session->userdata('role') || $this->session->userdata('role') != 'admin'){
            redirect('login');
        }
        $this->load->library('pagination');
    }

    // ======================
    // LIST DATA
    // ======================
    public function index()
{
    $keyword = trim(
    $this->input->get('keyword')
);
    $this->db->from('siswa');

if ($keyword) {

    $this->db->group_start();
    $this->db->like('nama', $keyword);
    $this->db->or_like('nisn', $keyword);
    $this->db->group_end();

}

$jumlah_data =
    $this->db
    ->count_all_results();

    $config['base_url'] = base_url('siswa/index');
    $config['reuse_query_string'] = TRUE;
    $config['total_rows'] = $jumlah_data;
    $config['per_page'] = 20;
    $config['uri_segment'] = 3;

    // Bootstrap
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

    $this->db->select('
        siswa.*,
        kelas.nama_kelas,
        kelas.tingkat,
        jurusan.nama_jurusan,
        jurusan.singkatan,
        tahun_ajaran.tahun
    ');

    $this->db->from('siswa');

    $this->db->join(
        'kelas',
        'kelas.id=siswa.id_kelas',
        'left'
    );

    $this->db->join(
        'jurusan',
        'jurusan.id=kelas.jurusan_id',
        'left'
    );

    $this->db->join(
        'tahun_ajaran',
        'tahun_ajaran.id=siswa.id_tahun',
        'left'
    );
    if ($keyword) {

    $this->db->group_start();
    $this->db->like('siswa.nama', $keyword);
    $this->db->or_like('siswa.nisn', $keyword);
    $this->db->group_end();

}

    $data['siswa'] = $this->db
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
        'admin/siswa/index',
        $data
    );
}

    // ======================
    // TAMBAH
    // ======================
    public function tambah()
{
    if($_POST){

        $nisn = $this->input->post('nisn');

        // cek duplikat nisn
        $cek = $this->db
            ->get_where(
                'siswa',
                ['nisn'=>$nisn]
            )
            ->row();

        if($cek){

            $this->session
                ->set_flashdata(
                    'error',
                    'NISN sudah terdaftar'
                );

            redirect('siswa/tambah');
        }

        // upload foto
        $config['upload_path'] =
            './uploads/foto/';

        $config['allowed_types'] =
            'jpg|jpeg|png';

        $config['max_size'] = 2048;

        $this->load->library(
            'upload',
            $config
        );

        $foto = 'default.png';

        if(
            $this->upload
            ->do_upload('foto')
        ){
            $foto =
                $this->upload
                ->data('file_name');
        }

        // insert siswa
        $this->db->insert(
            'siswa',
            [
                'nisn' =>
                    $nisn,

                'nis' =>
                    $this->input
                    ->post('nis'),

                'nama' =>
                    $this->input
                    ->post('nama'),

                'jenis_kelamin' =>
                    $this->input
                    ->post('jk'),

                'tempat_lahir' =>
                    $this->input
                    ->post('tempat_lahir'),

                'tanggal_lahir' =>
                    $this->input
                    ->post('tanggal_lahir'),

                'nama_ortu' =>
                    $this->input
                    ->post('nama_ortu'),

                'id_kelas' =>
                    $this->input
                    ->post('kelas'),

                'id_tahun' =>
                    $this->input
                    ->post('tahun'),

                'foto' =>
                    $foto
            ]
        );

        // update jumlah siswa kelas
        $kelas_id =
            $this->input
            ->post('kelas');

        $jumlah =
            $this->db
            ->where(
                'id_kelas',
                $kelas_id
            )
            ->count_all_results(
                'siswa'
            );

        $this->db
            ->where(
                'id',
                $kelas_id
            )
            ->update(
                'kelas',
                [
                    'jumlah_siswa' =>
                        $jumlah
                ]
            );

        redirect('siswa');
    }

    $data['kelas'] =
        $this->db
        ->order_by(
            'nama_kelas',
            'ASC'
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
        'admin/siswa/tambah',
        $data
    );
}
    // ======================
    // EDIT
    // ======================
    public function edit($id)
{
    if($_POST){

        // ambil data lama
        $siswa = $this->db->get_where('siswa',['id'=>$id])->row();

        // config upload
        $config['upload_path'] = './uploads/foto/';
        $config['allowed_types'] = 'jpg|jpeg|png';
        $config['max_size'] = 2048;

        $this->load->library('upload', $config);

        $foto = $siswa->foto; // default = foto lama

        // kalau upload baru
        if($this->upload->do_upload('foto')){
            
            // hapus foto lama (kecuali default)
            if($siswa->foto != 'default.png' && file_exists('./uploads/foto/'.$siswa->foto)){
                unlink('./uploads/foto/'.$siswa->foto);
            }

            $foto = $this->upload->data('file_name');
        }

        // update data
        $this->db
->where('id',$id)
->update('siswa', [

    'nis' =>
        $this->input->post('nis'),

    'nama' =>
        $this->input->post('nama'),

    'jenis_kelamin' =>
        $this->input->post('jk'),

    'tempat_lahir' =>
        $this->input->post('tempat_lahir'),

    'tanggal_lahir' =>
        $this->input->post('tanggal_lahir'),

    'nama_ortu' =>
        $this->input->post('nama_ortu'),

    'id_kelas' =>
        $this->input->post('kelas'),

    'id_tahun' =>
        $this->input->post('tahun'),

    'foto' =>
        $foto
]);

        redirect('siswa');
    }

    $data['siswa'] = $this->db->get_where('siswa',['id'=>$id])->row();
    $data['kelas'] = $this->db->get('kelas')->result();
    $data['tahun'] = $this->db->get('tahun_ajaran')->result();

    template('admin/siswa/edit', $data);
}

    // ======================
    // HAPUS
    // ======================
    public function hapus($id)
{
    $siswa = $this->db
        ->get_where(
            'siswa',
            ['id'=>$id]
        )
        ->row();

    if(!$siswa){
        show_404();
    }

    // hapus foto jika bukan default
    if(
        !empty($siswa->foto)
        &&
        $siswa->foto != 'default.png'
    ){

        $path =
            './uploads/foto/' .
            $siswa->foto;

        if(file_exists($path)){
            unlink($path);
        }
    }

    // ambil id kelas
    $kelas_id =
        $siswa->id_kelas;

    // hapus siswa
    $this->db->delete(
        'siswa',
        ['id'=>$id]
    );

    // update jumlah siswa kelas
    $jumlah =
        $this->db
        ->where(
            'id_kelas',
            $kelas_id
        )
        ->count_all_results(
            'siswa'
        );

    $this->db
        ->where(
            'id',
            $kelas_id
        )
        ->update(
            'kelas',
            [
                'jumlah_siswa' =>
                    $jumlah
            ]
        );

    redirect('siswa');
}
    public function upload_foto_massal()
{
    if(isset($_FILES['zip']['name'])){

        $zip_name = $_FILES['zip']['tmp_name'];

        $zip = new ZipArchive;
        if($zip->open($zip_name) === TRUE){

            $extract_path = FCPATH.'uploads/tmp/';
            if(!is_dir($extract_path)){
                mkdir($extract_path, 0777, true);
            }

            $zip->extractTo($extract_path);
            $zip->close();

            $files = scandir($extract_path);

            $berhasil = 0;
            $gagal = 0;

            foreach($files as $file){

                if($file == '.' || $file == '..') continue;

                $ext = pathinfo($file, PATHINFO_EXTENSION);
                $nisn = pathinfo($file, PATHINFO_FILENAME);

                // cek siswa
                $siswa = $this->db->get_where('siswa', ['nisn'=>$nisn])->row();

                if($siswa){

                    $new_name = $nisn.'.'.$ext;
                    $source = $extract_path.$file;
                    $dest = FCPATH.'uploads/foto/'.$new_name;

                    rename($source, $dest);

                    // update DB
                    $this->db->where('nisn', $nisn)->update('siswa', [
                        'foto' => $new_name
                    ]);

                    $berhasil++;
                } else {
                    $gagal++;
                }
            }

            // bersihkan folder tmp
            array_map('unlink', glob($extract_path.'*.*'));

            $this->session->set_flashdata('success',
                "Upload selesai: $berhasil berhasil, $gagal gagal"
            );

        } else {
            $this->session->set_flashdata('error','Gagal membuka ZIP');
        }

        redirect('siswa');
    }
}
public function view($id)
{
    $data['siswa'] = $this->db
        ->select('
            siswa.*,
            kelas.nama_kelas,
            kelas.tingkat,
            jurusan.nama_jurusan,
            jurusan.singkatan,
            tahun_ajaran.tahun
        ')
        ->from('siswa')
        ->join(
            'kelas',
            'kelas.id = siswa.id_kelas',
            'left'
        )
        ->join(
            'jurusan',
            'jurusan.id = kelas.jurusan_id',
            'left'
        )
        ->join(
            'tahun_ajaran',
            'tahun_ajaran.id = siswa.id_tahun',
            'left'
        )
        ->where(
            'siswa.id',
            $id
        )
        ->get()
        ->row();

    template(
        'admin/siswa/view',
        $data
    );
}
}