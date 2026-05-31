<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Pekael Admin</title>

    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Font -->
    <link href="<?= base_url('assets/sbadmin2/vendor/fontawesome-free/css/all.min.css') ?>" rel="stylesheet">

    <!-- SB Admin CSS -->
    <link href="<?= base_url('assets/sbadmin2/css/sb-admin-2.min.css') ?>" rel="stylesheet">
    <?php
$CI =& get_instance();

$tema = 'light';

$row = $CI->db
    ->get_where(
        'pengaturan',
        [
            'nama_pengaturan' =>
                'tema_aplikasi'
        ]
    )
    ->row();

if($row){
    $tema = $row->value;
}
?>

<link href="<?= base_url('assets/sbadmin2/css/sb-admin-2.min.css') ?>"
      rel="stylesheet">

<?php if($tema == 'dark'): ?>

<link href="<?= base_url('assets/css/theme-dark.css') ?>"
      rel="stylesheet">

<?php endif; ?>
</head>

<body id="page-top">

<div id="wrapper">