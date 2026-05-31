<?php
class Pengaturan extends CI_Controller {

    public function __construct()
    {
        parent::__construct();

        if($this->session->userdata('role') != 'admin'){
            redirect('login');
        }
    }

    public function index()
{
    $data['pengaturan'] = $this->db->get('pengaturan')->result();

    template('admin/pengaturan/index', $data);
}
    public function update()
{
    $post = $this->input->post();

    foreach($post as $nama => $value){

        // khusus tanggal biar format benar
        if($nama == 'tanggal_pengumuman'){
            $value = str_replace('T',' ', $value) . ':00';
        }

        $this->db->where('nama_pengaturan', $nama);
        $this->db->update('pengaturan', [
            'value' => $value
        ]);
    }

    // hapus cache kalau pakai helper tadi
    $this->load->driver('cache', ['adapter' => 'file']);
    $this->cache->delete('settings');

    redirect('pengaturan');
}
public function toggle_theme()
{
    $row = $this->db
        ->get_where(
            'pengaturan',
            [
                'nama_pengaturan' =>
                'tema_aplikasi'
            ]
        )
        ->row();

    $tema_baru =
        ($row->value == 'dark')
        ? 'light'
        : 'dark';

    $this->db
        ->where(
            'nama_pengaturan',
            'tema_aplikasi'
        )
        ->update(
            'pengaturan',
            [
                'value' => $tema_baru
            ]
        );

    redirect(
        $_SERVER['HTTP_REFERER']
    );
}
}