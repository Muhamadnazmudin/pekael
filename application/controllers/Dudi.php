<?php
defined('BASEPATH') OR exit('No direct script access allowed');
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class Dudi extends CI_Controller {

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

        $this->load->model(
            'Dudi_model'
        );
    }

    // ======================
    // INDEX
    // ======================
    public function index()
    {
        $data['title'] =
            'Data DUDI';

        $data['dudi'] =
            $this->Dudi_model
            ->getAll();

        template(
            'admin/dudi/index',
            $data
        );
    }

    // ======================
    // TAMBAH
    // ======================
    public function tambah()
    {
        if($_POST){

            $data = [

                'nama_dudi' =>
                    $this->input
                    ->post('nama_dudi'),

                'bidang_usaha' =>
                    $this->input
                    ->post('bidang_usaha'),

                'alamat' =>
                    $this->input
                    ->post('alamat'),

                'desa_kelurahan' =>
                    $this->input
                    ->post('desa'),

                'kecamatan' =>
                    $this->input
                    ->post('kecamatan'),

                'kabupaten_kota' =>
                    $this->input
                    ->post('kabupaten'),

                'provinsi' =>
                    $this->input
                    ->post('provinsi'),

                'nomor_mou' =>
                    $this->input
                    ->post('nomor_mou'),

                'judul_pks' =>
                    $this->input
                    ->post('judul_pks'),

                'nama_pic' =>
                    $this->input
                    ->post('nama_pic'),

                'no_hp_pic' =>
                    $this->input
                    ->post('no_hp_pic'),

                'status_kerjasama' =>
                    $this->input
                    ->post('status')
            ];

            $this->Dudi_model
                ->insert($data);

            redirect('dudi');
        }

        template(
            'admin/dudi/tambah'
        );
    }

    // ======================
    // EDIT
    // ======================
    public function edit($id)
    {
        if($_POST){

            $data = [

                'nama_dudi' =>
                    $this->input
                    ->post('nama_dudi'),

                'bidang_usaha' =>
                    $this->input
                    ->post('bidang_usaha'),

                'alamat' =>
                    $this->input
                    ->post('alamat'),

                'desa_kelurahan' =>
                    $this->input
                    ->post('desa'),

                'kecamatan' =>
                    $this->input
                    ->post('kecamatan'),

                'kabupaten_kota' =>
                    $this->input
                    ->post('kabupaten'),

                'provinsi' =>
                    $this->input
                    ->post('provinsi'),

                'nomor_mou' =>
                    $this->input
                    ->post('nomor_mou'),

                'judul_pks' =>
                    $this->input
                    ->post('judul_pks'),

                'nama_pic' =>
                    $this->input
                    ->post('nama_pic'),

                'no_hp_pic' =>
                    $this->input
                    ->post('no_hp_pic'),

                'status_kerjasama' =>
                    $this->input
                    ->post('status')
            ];

            $this->Dudi_model
                ->update(
                    $id,
                    $data
                );

            redirect('dudi');
        }

        $data['dudi'] =
            $this->Dudi_model
            ->getById($id);

        template(
            'admin/dudi/edit',
            $data
        );
    }

    // ======================
    // HAPUS
    // ======================
    public function hapus($id)
    {
        $this->Dudi_model
            ->delete($id);

        redirect('dudi');
    }
        // ======================
    // EXPORT EXCEL
    // ======================
    public function export()
    {
        $dudi = $this->Dudi_model->getAll();

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $sheet->setCellValue('A1', 'No');
        $sheet->setCellValue('B1', 'Nama DUDI');
        $sheet->setCellValue('C1', 'Bidang Usaha');
        $sheet->setCellValue('D1', 'Alamat');
        $sheet->setCellValue('E1', 'Desa/Kelurahan');
        $sheet->setCellValue('F1', 'Kecamatan');
        $sheet->setCellValue('G1', 'Kabupaten/Kota');
        $sheet->setCellValue('H1', 'Provinsi');
        $sheet->setCellValue('I1', 'Nomor MOU');
        $sheet->setCellValue('J1', 'Judul PKS');
        $sheet->setCellValue('K1', 'Nama PIC');
        $sheet->setCellValue('L1', 'No HP PIC');
        $sheet->setCellValue('M1', 'Status Kerjasama');

        $row = 2;
        $no  = 1;

        foreach ($dudi as $d) {

            $sheet->setCellValue('A'.$row, $no++);
            $sheet->setCellValue('B'.$row, $d->nama_dudi);
            $sheet->setCellValue('C'.$row, $d->bidang_usaha);
            $sheet->setCellValue('D'.$row, $d->alamat);
            $sheet->setCellValue('E'.$row, $d->desa_kelurahan);
            $sheet->setCellValue('F'.$row, $d->kecamatan);
            $sheet->setCellValue('G'.$row, $d->kabupaten_kota);
            $sheet->setCellValue('H'.$row, $d->provinsi);
            $sheet->setCellValue('I'.$row, $d->nomor_mou);
            $sheet->setCellValue('J'.$row, $d->judul_pks);
            $sheet->setCellValue('K'.$row, $d->nama_pic);
            $sheet->setCellValue('L'.$row, $d->no_hp_pic);
            $sheet->setCellValue('M'.$row, $d->status_kerjasama);

            $row++;
        }

        foreach (range('A', 'M') as $col) {
            $sheet->getColumnDimension($col)
                  ->setAutoSize(true);
        }

        $filename = 'Data_DUDI_'.date('Ymd_His').'.xlsx';

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="'.$filename.'"');
        header('Cache-Control: max-age=0');

        $writer = new Xlsx($spreadsheet);
        $writer->save('php://output');
        exit;
    }
}