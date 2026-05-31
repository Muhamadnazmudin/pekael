<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Backup extends CI_Controller {

    public function __construct()
    {
        parent::__construct();

        if(
            !$this->session->userdata('role')
            ||
            $this->session->userdata('role') != 'admin'
        ){
            redirect('login');
        }

        $this->load->dbutil();

        $this->load->helper([
            'file',
            'download'
        ]);
    }

    public function index()
    {
        $data['title'] =
            'Backup & Restore Database';

        template(
            'admin/backup/index',
            $data
        );
    }

    // =====================
    // BACKUP DATABASE
    // =====================
    public function database()
    {
        $prefs = [

            'format'     => 'txt',
            'filename'   => 'pekael.sql',
            'add_drop'   => TRUE,
            'add_insert' => TRUE,
            'newline'    => "\n"

        ];

        $backup =
            $this->dbutil
            ->backup($prefs);

        $nama_file =
            'backup_pekael_'.
            date('Ymd_His').
            '.sql';

        force_download(
            $nama_file,
            $backup
        );
    }

    // =====================
    // RESTORE DATABASE
    // =====================
    public function restore()
    {
        if(
            empty(
                $_FILES['database']['name']
            )
        ){

            $this->session
            ->set_flashdata(
                'error',
                'Pilih file SQL terlebih dahulu'
            );

            redirect('backup');
        }

        $ext =
            pathinfo(
                $_FILES['database']['name'],
                PATHINFO_EXTENSION
            );

        if(
            strtolower($ext)
            != 'sql'
        ){

            $this->session
            ->set_flashdata(
                'error',
                'File harus berformat SQL'
            );

            redirect('backup');
        }

        $sql =
            file_get_contents(
                $_FILES['database']['tmp_name']
            );

        if(
            empty(
                trim($sql)
            )
        ){

            $this->session
            ->set_flashdata(
                'error',
                'File SQL kosong'
            );

            redirect('backup');
        }

        try {

            $queries =
                explode(
                    ';',
                    $sql
                );

            foreach(
                $queries
                as $query
            ){

                $query =
                    trim(
                        $query
                    );

                if(
                    !empty(
                        $query
                    )
                ){

                    $this->db
                    ->query(
                        $query
                    );
                }
            }

            $this->session
            ->set_flashdata(
                'success',
                'Restore database berhasil'
            );

        } catch(Exception $e){

            $this->session
            ->set_flashdata(
                'error',
                'Restore gagal'
            );
        }

        redirect('backup');
    }
}