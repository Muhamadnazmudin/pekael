<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class Importdudi extends CI_Controller {

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
    }

    // ======================
    // IMPORT EXCEL DUDI
    // ======================
    public function proses()
    {
        if(
            empty($_FILES['file']['tmp_name'])
        ){

            $this->session
                ->set_flashdata(
                    'error',
                    'File belum dipilih'
                );

            redirect('dudi');
        }

        try {

            $file =
                $_FILES['file']
                ['tmp_name'];

            $spreadsheet =
                IOFactory::load(
                    $file
                );

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

            foreach(
                $sheet
                as $i => $row
            ){

                // skip header
                if($i == 1){
                    continue;
                }

                // amanin key excel
                $row = array_replace([

                    'A'=>null,
                    'B'=>null,
                    'C'=>null,
                    'D'=>null,
                    'E'=>null,
                    'F'=>null,
                    'G'=>null,
                    'H'=>null,
                    'I'=>null,
                    'J'=>null,
                    'K'=>null,
                    'L'=>null

                ], $row);

                $nama =
                    trim(
                        $row['A']
                    );

                // skip kosong
                if(!$nama){

                    $skip++;
                    continue;
                }

                // insert
                $this->db
                    ->insert(
                        'dudi',
                        [

                            'nama_dudi' =>
                                $row['A'],

                            'bidang_usaha' =>
                                $row['B'],

                            'alamat' =>
                                $row['C'],

                            'desa_kelurahan' =>
                                $row['D'],

                            'kecamatan' =>
                                $row['E'],

                            'kabupaten_kota' =>
                                $row['F'],

                            'provinsi' =>
                                $row['G'],

                            'nomor_mou' =>
                                $row['H'],

                            'judul_pks' =>
                                $row['I'],

                            'nama_pic' =>
                                $row['J'],

                            'no_hp_pic' =>
                                $row['K'],

                            'status_kerjasama' =>

                                !empty(
                                    $row['L']
                                )

                                ?

                                strtolower(
                                    trim(
                                        $row['L']
                                    )
                                )

                                :

                                'aktif'
                        ]
                    );

                $berhasil++;
            }

            $this->session
                ->set_flashdata(
                    'success',

                    'Import selesai.
                    Berhasil:
                    '
                    .$berhasil.
                    '
                    | Skip:
                    '
                    .$skip
                );

        } catch(Exception $e){

            $this->session
                ->set_flashdata(
                    'error',
                    $e->getMessage()
                );
        }

        redirect('dudi');
    }

    // ======================
    // TEMPLATE EXCEL DUDI
    // ======================
    public function template()
{
    $spreadsheet =
        new Spreadsheet();

    $sheet =
        $spreadsheet
        ->getActiveSheet();

    // header excel
    $header = [

        'Nama DUDI',
        'Bidang Usaha',
        'Alamat',
        'Desa/Kelurahan',
        'Kecamatan',
        'Kabupaten/Kota',
        'Provinsi',
        'Nomor MoU',
        'Judul PKS',
        'Nama PIC',
        'No HP PIC',
        'Status'

    ];

    // contoh isi
    $contoh = [

        'Hotel Horison',
        'Hospitality',
        'Jl. Siliwangi No.1',
        'Cijoho',
        'Kuningan',
        'Kuningan',
        'Jawa Barat',
        '001/SMK/2025',
        'PKS Praktik Kerja Lapangan',
        'Bapak Agus',
        '08123456789',
        'aktif'
    ];

    $sheet->fromArray([
        $header,
        $contoh
    ]);

    // auto width kolom
    foreach(
        range('A','L')
        as $col
    ){

        $sheet
            ->getColumnDimension(
                $col
            )
            ->setAutoSize(true);
    }

    $writer =
        new Xlsx(
            $spreadsheet
        );

    // bersihkan output buffer
    if(
        ob_get_length()
    ){
        ob_end_clean();
    }

    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');

    header('Content-Disposition: attachment; filename="template_dudi.xlsx"');

    header('Cache-Control: max-age=0');

    $writer->save(
        'php://output'
    );

    exit;
}
}