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

            // cek manual dulu
$manual = $this->db
    ->where('guru_id', $g->id)
    ->where('kelas_id', $k->kelas_id)
    ->count_all_results('distribusi_manual');

if ($manual > 0) {

    // kalau ada mapping manual
    // pakai manual sebagai hasil final
    $jumlah_siswa = $manual;

} else {

    // kalau belum manual
    // ambil hasil generate otomatis
    $jumlah_siswa = $this->db
        ->where('guru_id', $g->id)
        ->where('kelas_id', $k->kelas_id)
        ->count_all_results('pembimbing_pkl');
}

            $kelas_data[] = [
                'nama_kelas' => $k->nama_kelas,
                'jam' => $k->jumlah_jam,
                'siswa' => $jumlah_siswa
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