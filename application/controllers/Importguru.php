<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class Importguru extends CI_Controller {

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
    // IMPORT EXCEL GURU
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

            redirect('guru');
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

                // amankan key excel
                $row = array_replace([

                    'A'=>null,
                    'B'=>null,
                    'C'=>null,
                    'D'=>null,
                    'E'=>null

                ], $row);

                $nip =
                    trim(
                        $row['A']
                    );

                $nama =
                    trim(
                        $row['B']
                    );

                $jurusan =
                    trim(
                        $row['C']
                    );

                // skip kosong
                if(!$nama){

                    $skip++;
                    continue;
                }

                // cari jurusan
                $jurusanData =
                    $this->db
                    ->where(
                        'nama_jurusan',
                        $jurusan
                    )
                    ->get('jurusan')
                    ->row();

                $jurusan_id =
                    $jurusanData
                    ? $jurusanData->id
                    : NULL;

                // cek nip duplicate
                $cek =
                    $this->db
                    ->where(
                        'nip',
                        $nip
                    )
                    ->get('guru')
                    ->row();

                if($cek){

                    $skip++;
                    continue;
                }

                // insert
                $this->db
                    ->insert(
                        'guru',
                        [

                            'nip' =>
                                $nip,

                            'nama_guru' =>
                                $nama,

                            'jurusan_id' =>
                                $jurusan_id,

                            'jenis_guru' =>
                                !empty(
                                    $row['D']
                                )

                                ?

                                strtolower(
                                    trim(
                                        $row['D']
                                    )
                                )

                                :

                                'normatif',

                            'status' =>

                                !empty(
                                    $row['E']
                                )

                                ?

                                strtolower(
                                    trim(
                                        $row['E']
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

        redirect('guru');
    }

    // ======================
    // TEMPLATE EXCEL GURU
    // ======================
    public function template()
    {
        $spreadsheet =
            new Spreadsheet();

        $sheet =
            $spreadsheet
            ->getActiveSheet();

        // header
        $header = [

            'NIP',
            'Nama Guru',
            'Jurusan',
            'Jenis Guru',
            'Status'

        ];

        // contoh
        $contoh = [

            '19881201',
            'Budi Santoso',
            'RPL',
            'produktif',
            'aktif'
        ];

        $sheet->fromArray([
            $header,
            $contoh
        ]);

        // auto width
        foreach(
            range('A','E')
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

        if(
            ob_get_length()
        ){
            ob_end_clean();
        }

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');

        header('Content-Disposition: attachment; filename="template_guru.xlsx"');

        header('Cache-Control: max-age=0');

        $writer->save(
            'php://output'
        );

        exit;
    }
}