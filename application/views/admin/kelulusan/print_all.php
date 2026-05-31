<!DOCTYPE html>
<html>
<head>
    <title>Cetak Semua SKL</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }

        .page {
            page-break-after: always;
            min-height: 100vh;
        }

        .center {
            text-align: center;
        }

        .foto {
            width: 100px;
            height: 120px;
            object-fit: cover;
            margin-top: 10px;
        }

        @media print {
            .page {
                page-break-after: always;
            }
        }
    </style>
</head>

<body>

<?php foreach($kelulusan as $k): ?>

<div class="page">

    <h3 class="center">SURAT KETERANGAN LULUS</h3>

    <hr style="width:200px; margin:auto;">

    <br>

    <table>
        <tr>
            <td width="150">Nama</td>
            <td>: <?= $k->nama ?></td>
        </tr>
        <tr>
            <td>NISN</td>
            <td>: <?= $k->nisn ?></td>
        </tr>
        <tr>
            <td>Status</td>
            <td>: <?= strtoupper($k->status) ?></td>
        </tr>
        <tr>
            <td>Nomor SKL</td>
            <td>: <?= $k->nomor_skl ?></td>
        </tr>
    </table>

    <br>

    <?php 
    $foto = !empty($k->foto) ? $k->foto : 'default.png';
    ?>

    <img src="<?= base_url('uploads/foto/'.$foto) ?>" class="foto">

</div>

<?php endforeach; ?>

<!-- 🔥 AUTO PRINT (AMAN) -->
<script>
window.onload = function(){
    setTimeout(function(){
        window.print();
    }, 800); // delay biar semua halaman kebentuk dulu
}
</script>

</body>
</html>