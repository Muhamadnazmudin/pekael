<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_laporan_pembimbing_propor extends CI_Model
{
    public function get_laporan()
    {
        $guru = $this->db
            ->where('status', 'aktif')
            ->order_by('nama_guru', 'ASC')
            ->get('guru')
            ->result();

        $hasil = [];

        foreach ($guru as $g) {

            $kelas_guru = $this->db
                ->select('
                    pembimbing_pkl_perkelas.*,
                    kelas.nama_kelas
                ')
                ->from('pembimbing_pkl_perkelas')
                ->join(
                    'kelas',
                    'kelas.id = pembimbing_pkl_perkelas.kelas_id'
                )
                ->where(
                    'pembimbing_pkl_perkelas.guru_id',
                    $g->id
                )
                ->get()
                ->result();

            if (empty($kelas_guru)) {
                continue;
            }

            $kelas_data  = [];
            $total_jam   = 0;
            $total_siswa = 0;

            foreach ($kelas_guru as $k) {

                $siswa = $this->db
                    ->select('siswa.nama')
                    ->from('distribusi_pkl')
                    ->join(
                        'siswa',
                        'siswa.id = distribusi_pkl.siswa_id'
                    )
                    ->where(
                        'distribusi_pkl.guru_id',
                        $g->id
                    )
                    ->where(
                        'distribusi_pkl.kelas_id',
                        $k->kelas_id
                    )
                    ->order_by(
                        'siswa.nama',
                        'ASC'
                    )
                    ->get()
                    ->result();

                $nama_siswa = [];

                foreach ($siswa as $s) {
                    $nama_siswa[] = $s->nama;
                }

                $jumlah_siswa = count($nama_siswa);

                $kelas_data[] = [
                    'nama_kelas' => $k->nama_kelas,
                    'jam'        => $k->total_jam,
                    'siswa'      => $jumlah_siswa,
                    'nama_siswa' => $nama_siswa
                ];

                $total_jam += $k->total_jam;
                $total_siswa += $jumlah_siswa;
            }

            $hasil[] = [
                'guru'        => $g->nama_guru,
                'kelas'       => $kelas_data,
                'total_jam'   => $total_jam,
                'total_siswa' => $total_siswa
            ];
        }

        return $hasil;
    }
}