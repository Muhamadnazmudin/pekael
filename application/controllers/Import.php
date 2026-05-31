<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
class Import extends CI_Controller {

    public function __construct()
    {
        parent::__construct();

        if($this->session->userdata('role') != 'admin'){
            redirect('login');
        }

        // ❌ HAPUS PHPExcel lama
        // require APPPATH.'libraries/PHPExcel/Classes/PHPExcel.php';
    }

    public function proses()
{
    $file = $_FILES['file']['tmp_name'];

    $spreadsheet =
        IOFactory::load($file);

    $sheet =
        $spreadsheet
        ->getActiveSheet()
        ->toArray(
            null,
            true,
            true,
            true
        );

    $berhasil = 0;
    $skip = 0;

    foreach($sheet as $i => $row){

        // skip header
        if($i == 1){
            continue;
        }

        $row = array_replace([
            'A'=>null,
            'B'=>null,
            'C'=>null,
            'D'=>null,
            'E'=>null,
            'F'=>null,
            'G'=>null,
            'H'=>null,
            'I'=>null
        ], $row);

        $nisn =
            trim($row['A']);

        // nisn kosong
        if(!$nisn){
            $skip++;
            continue;
        }

        // siswa sudah ada
        $cek = $this->db
            ->get_where(
                'siswa',
                [
                    'nisn' => $nisn
                ]
            )
            ->row();

        if($cek){
            $skip++;
            continue;
        }

        // validasi kelas
        $kelas = $this->db
            ->get_where(
                'kelas',
                [
                    'id' => $row['H']
                ]
            )
            ->row();

        if(!$kelas){
            $skip++;
            continue;
        }

        // validasi tahun
        $tahun = $this->db
            ->get_where(
                'tahun_ajaran',
                [
                    'id' => $row['I']
                ]
            )
            ->row();

        if(!$tahun){
            $skip++;
            continue;
        }

        // format tanggal
        $tanggal =
            $row['F'];

        if(is_numeric($tanggal)){

            $tanggal =
                \PhpOffice\PhpSpreadsheet\Shared\Date
                ::excelToDateTimeObject(
                    $tanggal
                )
                ->format('Y-m-d');
        }

        // insert siswa
        $insert =
            $this->db
            ->insert(
                'siswa',
                [

                    'nisn' =>
                        $row['A'],

                    'nis' =>
                        $row['B'],

                    'nama' =>
                        $row['C'],

                    'jenis_kelamin' =>
                        $row['D'],

                    'tempat_lahir' =>
                        $row['E'],

                    'tanggal_lahir' =>
                        $tanggal,

                    'nama_ortu' =>
                        $row['G'],

                    'id_kelas' =>
                        $row['H'],

                    'id_tahun' =>
                        $row['I'],

                    'foto' =>
                        'default.png'
                ]
            );

        if($insert){

            // update jumlah siswa kelas
            $jumlah =
                $this->db
                ->where(
                    'id_kelas',
                    $row['H']
                )
                ->count_all_results(
                    'siswa'
                );

            $this->db
                ->where(
                    'id',
                    $row['H']
                )
                ->update(
                    'kelas',
                    [
                        'jumlah_siswa' =>
                            $jumlah
                    ]
                );

            $berhasil++;

        } else {

            $skip++;
        }
    }

    $this->session
        ->set_flashdata(
            'success',
            "Import selesai. Berhasil: $berhasil | Skip: $skip"
        );

    redirect('siswa');
}
    public function template()
{
    $spreadsheet = new Spreadsheet();
    $sheet = $spreadsheet->getActiveSheet();

    // HEADER
    $sheet->fromArray([

        [
            'NISN',
            'NIS',
            'Nama',
            'JK',
            'Tempat Lahir',
            'Tanggal Lahir',
            'Ortu',
            'ID Kelas',
            'ID Tahun'
        ],

        [
            '11111',
            '12321',
            'Budak Angon',
            'L',
            'Jakarta',
            '2006-01-01',
            'Slamet',
            '1',
            '1'
        ]

    ]);

    $writer = new Xlsx($spreadsheet);

    header(
        'Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'
    );

    header(
        'Content-Disposition: attachment; filename="template_siswa_pekael.xlsx"'
    );

    $writer->save('php://output');
}
}