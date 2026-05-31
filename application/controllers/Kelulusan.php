<?php
defined('BASEPATH') OR exit('No direct script access allowed');
use Dompdf\Dompdf;
class Kelulusan extends CI_Controller {

    public function __construct()
    {
        parent::__construct();

        if(!$this->session->userdata('role') || $this->session->userdata('role') != 'admin'){
            redirect('login');
        }
    }

    // ======================
    // LIST DATA
    // ======================
    public function index()
    {
        $this->db->select('kelulusan.*, siswa.nama, siswa.nisn');
        $this->db->join('siswa','siswa.id=kelulusan.id_siswa');

        $data['kelulusan'] = $this->db->get('kelulusan')->result();

        template('admin/kelulusan/index', $data);
    }

    // ======================
    // TAMBAH / SET KELULUSAN
    // ======================
    public function tambah()
    {
        if($_POST){

            $this->db->insert('kelulusan', [
                'id_siswa' => $this->input->post('siswa'),
                'status' => $this->input->post('status'),
                'nomor_skl' => $this->input->post('nomor_skl'),
                'tanggal_lulus' => $this->input->post('tanggal'),
                'keterangan' => $this->input->post('keterangan')
            ]);

            redirect('kelulusan');
        }

        // ambil siswa yang BELUM ada kelulusan
        $this->db->where('id NOT IN (SELECT id_siswa FROM kelulusan)', NULL, FALSE);
        $data['siswa'] = $this->db->get('siswa')->result();

        template('admin/kelulusan/tambah', $data);
    }

    // ======================
    // EDIT
    // ======================
    public function edit($id)
    {
        if($_POST){

            $this->db->where('id',$id)->update('kelulusan', [
                'status' => $this->input->post('status'),
                'nomor_skl' => $this->input->post('nomor_skl'),
                'tanggal_lulus' => $this->input->post('tanggal'),
                'keterangan' => $this->input->post('keterangan')
            ]);

            redirect('kelulusan');
        }

        $data['kelulusan'] = $this->db->get_where('kelulusan',['id'=>$id])->row();

        template('admin/kelulusan/edit', $data);
    }

    // ======================
    // HAPUS
    // ======================
    public function hapus($id)
    {
        $this->db->delete('kelulusan',['id'=>$id]);
        redirect('kelulusan');
    }
    public function print($id)
{
    // ======================
    // 🔥 AMBIL DATA
    // ======================
    $this->db->select('
        kelulusan.*,
        siswa.nama,
        siswa.nisn,
        siswa.nis,
        siswa.jurusan,
        siswa.tempat_lahir,
        siswa.tanggal_lahir,
        siswa.nama_ortu,
        siswa.rata_nilai,
        siswa.foto
    ');
    $this->db->join('siswa','siswa.id=kelulusan.id_siswa');
    $data['k'] = $this->db->get_where('kelulusan',['kelulusan.id'=>$id])->row();

    // ======================
    // 🔥 AMBIL TEMPLATE
    // ======================
    $template = $this->db->get('template_skl')->row();

    // ======================
    // 🔥 FORMAT DATA
    // ======================
    $ttl = $data['k']->tempat_lahir.', '.date('d-m-Y', strtotime($data['k']->tanggal_lahir));

    // ======================
    // 🔥 TANGGAL KELULUSAN
    // ======================
    $tgl = $this->db
        ->get_where('pengaturan',['nama_pengaturan'=>'tanggal_pengumuman'])
        ->row();

    $tanggal = $tgl 
        ? date('d-m-Y', strtotime($tgl->value)) 
        : date('d-m-Y');

    // ======================
    // 🔥 ISI TEMPLATE (INI YANG WAJIB ADA)
    // ======================
    $isi = $template->isi;

    $isi = str_replace('{nama}', $data['k']->nama, $isi);
    $isi = str_replace('{nisn}', $data['k']->nisn, $isi);
    $isi = str_replace('{nis}', $data['k']->nis, $isi);
    $isi = str_replace('{ttl}', $ttl, $isi);
    $isi = str_replace('{ortu}', $data['k']->nama_ortu, $isi);
    $isi = str_replace('{jurusan}', $data['k']->jurusan, $isi);
    $isi = str_replace('{nilai}', $data['k']->rata_nilai ?? '-', $isi);
    $isi = str_replace('{tanggal}', $tanggal, $isi);
    $isi = str_replace('{status}', strtoupper($data['k']->status), $isi);

    // ======================
    // 🔥 KIRIM KE VIEW
    // ======================
    $data['template'] = $template;
    $data['isi'] = $isi;
    $data['tanggal'] = $tanggal;

    // ======================
    // 🔥 LOAD HTML
    // ======================
    $html = $this->load->view('admin/kelulusan/print', $data, true);

    // ======================
    // 🔥 DOMPDF
    // ======================
    $dompdf = new Dompdf();
    $dompdf->loadHtml($html);
    $dompdf->setPaper('A4', 'portrait');
    $dompdf->render();

    $dompdf->stream("SKL_".$data['k']->nisn.".pdf", array("Attachment"=>false));
}
public function print_all()
{
    // ambil data
    $this->db->select('
        kelulusan.*,
        siswa.nama,
        siswa.nisn,
        siswa.nis,
        siswa.jurusan,
        siswa.tempat_lahir,
        siswa.tanggal_lahir,
        siswa.nama_ortu,
        siswa.rata_nilai,
        siswa.foto
    ');
    $this->db->join('siswa','siswa.id=kelulusan.id_siswa');

    $data_siswa = $this->db->get('kelulusan')->result();

    // template
    $template = $this->db->get('template_skl')->row();

    // tanggal
    $tgl = $this->db
        ->get_where('pengaturan',['nama_pengaturan'=>'tanggal_pengumuman'])
        ->row();

    $tanggal = $tgl 
        ? date('d-m-Y', strtotime($tgl->value)) 
        : date('d-m-Y');

    // ======================
    // 🔥 HTML WRAPPER
    // ======================
    $html = '
    <html>
    <head>
        <style>
            body { font-family: "Times New Roman"; }
            .page { page-break-after: always; }
        </style>
    </head>
    <body>
    ';

    foreach($data_siswa as $k){

        $ttl = $k->tempat_lahir.', '.date('d-m-Y', strtotime($k->tanggal_lahir));

        $isi = $template->isi;

        $isi = str_replace('{nama}', $k->nama, $isi);
        $isi = str_replace('{nisn}', $k->nisn, $isi);
        $isi = str_replace('{nis}', $k->nis, $isi);
        $isi = str_replace('{ttl}', $ttl, $isi);
        $isi = str_replace('{ortu}', $k->nama_ortu, $isi);
        $isi = str_replace('{jurusan}', $k->jurusan, $isi);
        $isi = str_replace('{nilai}', $k->rata_nilai ?? '-', $isi);
        $isi = str_replace('{tanggal}', $tanggal, $isi);
        $isi = str_replace('{status}', strtoupper($k->status), $isi);

        // render PARTIAL
        $html .= '<div class="page">';
        $html .= $this->load->view('admin/kelulusan/print', [
            'k' => $k,
            'isi' => $isi,
            'template' => $template,
            'tanggal' => $tanggal
        ], true);
        $html .= '</div>';
    }

    $html .= '</body></html>';

    // ======================
    // 🔥 DOMPDF
    // ======================
    $dompdf = new Dompdf();
    $dompdf->loadHtml($html);
    $dompdf->setPaper('A4', 'portrait');
    $dompdf->render();

    $dompdf->stream("SKL_SEMUA.pdf", ["Attachment"=>false]);
}
}