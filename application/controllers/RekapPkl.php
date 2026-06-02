<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Dompdf\Dompdf;

class RekapPkl extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->load->model('M_rekap_pkl');
    }

    public function index()
    {
        $data['rekap'] = $this->M_rekap_pkl->get_rekap();

        $data['laporan_menu'] = true;
        $data['sub'] = 'rekap';

        template(
            'admin/rekap_pkl/index',
            $data
        );
    }

    public function excel()
    {
        $rekap = $this->M_rekap_pkl->get_rekap();

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        foreach(range('A','H') as $col){
    $sheet->getColumnDimension($col)->setAutoSize(true);
}
        $sheet->setCellValue('A1', 'REKAP DATA PKL');

        $sheet->fromArray([
    'No',
    'Nama Siswa',
    'NISN',
    'Kelas',
    'Nama DUDI',
    'Nomor MoU',
    'Judul PKS',
    'Pembimbing'
], null, 'A3');

        $row = 4;
        $no  = 1;

        foreach ($rekap as $r) {

            $sheet->setCellValue('A'.$row, $no++);
$sheet->setCellValue('B'.$row, $r['nama']);
$sheet->setCellValue('C'.$row, $r['nisn']);
$sheet->setCellValue('D'.$row, $r['kelas']);
$sheet->setCellValue('E'.$row, $r['dudi']);
$sheet->setCellValue('F'.$row, $r['nomor_mou']);
$sheet->setCellValue('G'.$row, $r['judul_pks']);
$sheet->setCellValue('H'.$row, $r['pembimbing']);

            $row++;
        }

        foreach(range('A','F') as $col){
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="rekap_pkl.xlsx"');

        $writer = new Xlsx($spreadsheet);
        $writer->save('php://output');
    }

    public function pdf()
    {
        $data['rekap'] = $this->M_rekap_pkl->get_rekap();

        $html = $this->load->view(
            'admin/rekap_pkl/pdf',
            $data,
            true
        );

        $dompdf = new Dompdf();

        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'landscape');
        $dompdf->render();

        $dompdf->stream(
            'rekap_pkl.pdf',
            ['Attachment' => true]
        );
    }
}