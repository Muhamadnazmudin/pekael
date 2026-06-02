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
    $db = $this->db;

    $sql = '';

    $sql .= "-- Backup Database PEKAEL\n";
    $sql .= "-- Tanggal: " . date('Y-m-d H:i:s') . "\n\n";

    $sql .= "SET FOREIGN_KEY_CHECKS=0;\n\n";

    /*
    |--------------------------------------------------------------------------
    | Backup TABLE
    |--------------------------------------------------------------------------
    */
    $tables = $db->list_tables();

    foreach ($tables as $table) {

        // Skip VIEW
        $cek = $db->query("
            SELECT TABLE_TYPE
            FROM information_schema.TABLES
            WHERE TABLE_SCHEMA = DATABASE()
            AND TABLE_NAME = '{$table}'
        ")->row();

        if (
            isset($cek->TABLE_TYPE)
            &&
            $cek->TABLE_TYPE == 'VIEW'
        ) {
            continue;
        }

        $create = $db->query(
            "SHOW CREATE TABLE `{$table}`"
        )->row_array();

        $sql .= "\n";
        $sql .= "-- --------------------------------------------------\n";
        $sql .= "-- TABLE : {$table}\n";
        $sql .= "-- --------------------------------------------------\n\n";

        $sql .= "DROP TABLE IF EXISTS `{$table}`;\n";
        $sql .= $create['Create Table'] . ";\n\n";

        $rows = $db->get($table)->result_array();

        foreach ($rows as $row) {

            $values = [];

            foreach ($row as $value) {

                if ($value === null) {
                    $values[] = "NULL";
                } else {
                    $values[] =
                        "'" .
                        $db->escape_str($value) .
                        "'";
                }
            }

            $sql .=
                "INSERT INTO `{$table}` VALUES (" .
                implode(',', $values) .
                ");\n";
        }

        $sql .= "\n";
    }

    /*
    |--------------------------------------------------------------------------
    | Backup VIEW
    |--------------------------------------------------------------------------
    */
    $views = $db->query("
        SELECT TABLE_NAME
        FROM information_schema.VIEWS
        WHERE TABLE_SCHEMA = DATABASE()
    ")->result();

    foreach ($views as $view) {

        $viewName = $view->TABLE_NAME;

        $createView = $db->query(
            "SHOW CREATE VIEW `{$viewName}`"
        )->row_array();

        $sql .= "\n";
        $sql .= "-- --------------------------------------------------\n";
        $sql .= "-- VIEW : {$viewName}\n";
        $sql .= "-- --------------------------------------------------\n\n";

        $sql .=
            "DROP VIEW IF EXISTS `{$viewName}`;\n";

        $viewSql =
            $createView['Create View'];

        // hapus DEFINER agar aman dipindah server
        $viewSql = preg_replace(
            '/DEFINER=`[^`]+`@`[^`]+`/i',
            '',
            $viewSql
        );

        $sql .= $viewSql . ";\n\n";
    }

    $sql .= "\nSET FOREIGN_KEY_CHECKS=1;\n";

    $filename =
        'backup_pekael_' .
        date('Ymd_His') .
        '.sql';

    force_download(
        $filename,
        $sql
    );
}
    // =====================
    // RESTORE DATABASE
    // =====================
    public function restore()
{
    if (empty($_FILES['database']['name'])) {

        $this->session->set_flashdata(
            'error',
            'Pilih file SQL terlebih dahulu'
        );

        redirect('backup');
    }

    $ext = pathinfo(
        $_FILES['database']['name'],
        PATHINFO_EXTENSION
    );

    if (strtolower($ext) != 'sql') {

        $this->session->set_flashdata(
            'error',
            'File harus berformat SQL'
        );

        redirect('backup');
    }

    $sql = file_get_contents(
        $_FILES['database']['tmp_name']
    );

    if (empty(trim($sql))) {

        $this->session->set_flashdata(
            'error',
            'File SQL kosong'
        );

        redirect('backup');
    }

    try {

        $conn = $this->db->conn_id;

        mysqli_query(
            $conn,
            "SET FOREIGN_KEY_CHECKS=0"
        );

        if (!mysqli_multi_query($conn, $sql)) {

            throw new Exception(
                mysqli_error($conn)
            );
        }

        while (mysqli_more_results($conn)) {

            if (!mysqli_next_result($conn)) {

                throw new Exception(
                    mysqli_error($conn)
                );
            }
        }

        mysqli_query(
            $conn,
            "SET FOREIGN_KEY_CHECKS=1"
        );

        $this->session->set_flashdata(
            'success',
            'Restore database berhasil'
        );

    } catch (Throwable $e) {

        if (isset($conn)) {

            mysqli_query(
                $conn,
                "SET FOREIGN_KEY_CHECKS=1"
            );
        }

        $this->session->set_flashdata(
            'error',
            'Restore gagal : ' .
            $e->getMessage()
        );
    }

    redirect('backup');
}
}