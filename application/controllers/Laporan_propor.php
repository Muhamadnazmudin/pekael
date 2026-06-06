<?php
defined('BASEPATH') OR exit('No direct script access allowed');
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Dompdf\Dompdf;
class Laporan_propor extends CI_Controller
{
    public function __construct()
{
    parent::__construct();

    if (
        !$this->session->userdata('role')
        || $this->session->userdata('role') != 'admin'
    ) {
        redirect('login');
    }

    $this->load->model('M_laporan_pembimbing_propor');
    $this->load->model('M_rekap_pkl_propor');
}
    public function index()
    {
        redirect('laporan_propor/pembimbing');
    }

    public function pembimbing()
{
    $data['laporan'] =
        $this->M_laporan_pembimbing_propor
        ->get_laporan();

    template(
        'admin/laporan_propor/pembimbing',
        $data
    );
}

    public function rekap()
{
    $data['rekap'] =
        $this->M_rekap_pkl_propor
        ->get_rekap();

    template(
        'admin/laporan_propor/rekap',
        $data
    );
}

    public function excel()
{
    $rekap = $this->M_rekap_pkl_propor->get_rekap();

    $spreadsheet = new Spreadsheet();
    $sheet = $spreadsheet->getActiveSheet();

    foreach(range('A','H') as $col){
        $sheet->getColumnDimension($col)->setAutoSize(true);
    }

    $sheet->setCellValue(
        'A1',
        'REKAP DATA PKL METODE PROPORSIONAL'
    );

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

    header(
        'Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'
    );

    header(
        'Content-Disposition: attachment; filename="rekap_pkl_proporsional.xlsx"'
    );

    $writer = new Xlsx($spreadsheet);
    $writer->save('php://output');
}
public function pdf()
{
    $data['rekap'] =
        $this->M_rekap_pkl_propor->get_rekap();

    $html = $this->load->view(
        'admin/laporan_propor/pdf',
        $data,
        true
    );

    $dompdf = new Dompdf();

    $dompdf->loadHtml($html);
    $dompdf->setPaper(
        'A4',
        'landscape'
    );

    $dompdf->render();

    $dompdf->stream(
        'rekap_pkl_proporsional.pdf',
        ['Attachment' => true]
    );
}
}