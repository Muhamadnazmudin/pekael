<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_laporan_pembimbing extends CI_Model
{
    public function get_kelas()
    {
        return $this->db
            ->order_by('nama_kelas', 'ASC')
            ->get('kelas')
            ->result();
    }

    public function get_laporan()
{
    $guru = $this->db
        ->where('status', 'aktif')
        ->order_by('nama_guru', 'ASC')
        ->get('guru')
        ->result();

    $hasil = [];

    foreach ($guru as $g) {

        // ambil hanya kelas yg dia pegang
        $kelas_guru = $this->db
            ->select('pembagian_jam.*, kelas.nama_kelas')
            ->from('pembagian_jam')
            ->join('kelas', 'kelas.id = pembagian_jam.kelas_id')
            ->where('pembagian_jam.guru_id', $g->id)
            ->where('pembagian_jam.jumlah_jam >', 0)
            ->get()
            ->result();

        if (empty($kelas_guru)) {
            continue;
        }

        $kelas_data = [];
        $total_jam = 0;
        $total_siswa = 0;

        foreach ($kelas_guru as $k) {

            $siswa = $this->db
    ->select('siswa.nama')
    ->from('distribusi_manual')
    ->join('siswa', 'siswa.id = distribusi_manual.siswa_id')
    ->where('distribusi_manual.guru_id', $g->id)
    ->where('distribusi_manual.kelas_id', $k->kelas_id)
    ->get()
    ->result();

$nama_siswa = [];

foreach ($siswa as $s) {
    $nama_siswa[] = $s->nama;
}

$jumlah_siswa = count($nama_siswa);

$kelas_data[] = [
    'nama_kelas' => $k->nama_kelas,
    'jam'        => $k->jumlah_jam,
    'siswa'      => $jumlah_siswa,
    'nama_siswa' => $nama_siswa
];

$total_jam += $k->jumlah_jam;
$total_siswa += $jumlah_siswa;
        }

        $hasil[] = [
            'guru' => $g->nama_guru,
            'kelas' => $kelas_data,
            'total_jam' => $total_jam,
            'total_siswa' => $total_siswa
        ];
    }

    return $hasil;
}
}