<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Pengumuman Kelulusan</title>

    <link href="<?= base_url('assets/sbadmin2/css/sb-admin-2.min.css') ?>" rel="stylesheet">

    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">

    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, #4e73df, #1c3faa);
            color: #fff;
        }

        .hero {
            min-height: 100vh;
            display: flex;
            align-items: center;
        }

        .logo {
            width: 70px;
            margin-bottom: 15px;
        }

        .title {
            font-size: 36px;
            font-weight: 600;
            letter-spacing: 0.5px;
        }

        .subtitle {
            font-size: 15px;
            opacity: 0.9;
        }

        .countdown {
            font-size: 28px;
            font-weight: 600;
            letter-spacing: 1px;
            margin: 20px 0;
        }

        .btn-main {
            font-size: 16px;
            padding: 12px;
            border-radius: 10px;
            transition: 0.3s;
        }

        .btn-main:hover {
            transform: translateY(-2px);
        }

        .glass-box {
            background: rgba(255,255,255,0.08);
            border-radius: 12px;
            backdrop-filter: blur(10px);
            padding: 20px;
        }

        .sambutan {
            font-size: 14px;
            line-height: 1.7;
            opacity: 0.95;
        }

        .divider {
            height: 1px;
            background: rgba(255,255,255,0.2);
            margin: 20px 0;
        }

        @media (min-width:768px){
            .title { font-size: 44px; }
            .countdown { font-size: 34px; }
        }
    </style>
</head>

<body>

<!-- LOGIN -->
<div class="position-fixed" style="top:20px; right:20px;">
    <a href="<?= base_url('login') ?>" class="btn btn-light btn-sm shadow">
        Login Admin
    </a>
</div>

<div class="container hero">

    <div class="row justify-content-center text-center w-100">
        <div class="col-lg-6">

            <!-- LOGO (optional) -->
            <!-- <img src="<?= base_url('assets/logo.png') ?>" class="logo"> -->

            <!-- TITLE -->
            <h1 class="title">
                <?= $sekolah->nama_sekolah ?? 'Nama Sekolah' ?>
            </h1>

            <p class="subtitle mt-2">
                <?= $pengumuman ?>
            </p>

            <!-- COUNTDOWN -->
            <div id="countdown" class="countdown"></div>

            <!-- BUTTON -->
            <div class="mb-4">
                <?php if(strtotime($tanggal_pengumuman) <= time()): ?>
                    <a href="<?= base_url('login') ?>" class="btn btn-success btn-main btn-block shadow">
                        🎓 Lihat Hasil Kelulusan
                    </a>
                <?php else: ?>
                    <button class="btn btn-light btn-main btn-block" disabled>
                        ⏳ Pengumuman Belum Dibuka
                    </button>
                <?php endif; ?>
            </div>

            <!-- SAMBUTAN -->
            <div class="glass-box text-left">

                <small class="text-uppercase d-block mb-2">Sambutan Kepala Sekolah</small>

                <div class="divider"></div>

                <div class="sambutan">
                    <?= $sambutan ? nl2br($sambutan) : 'Sambutan belum diisi.' ?>
                </div>

            </div>

        </div>
    </div>

</div>

<!-- COUNTDOWN SCRIPT -->
<script>
var countDate = new Date("<?= $tanggal_pengumuman ?>").getTime();

var x = setInterval(function() {

    var now = new Date().getTime();
    var distance = countDate - now;

    if(distance <= 0){
        clearInterval(x);
        document.getElementById("countdown").innerHTML = "🎉 Pengumuman Sudah Dibuka";
        return;
    }

    var days = Math.floor(distance / (1000*60*60*24));
    var hours = Math.floor((distance % (1000*60*60*24)) / (1000*60*60));
    var minutes = Math.floor((distance % (1000*60*60)) / (1000*60));
    var seconds = Math.floor((distance % (1000*60)) / 1000);

    document.getElementById("countdown").innerHTML =
        days+" Hari • "+hours+" Jam • "+minutes+" Menit • "+seconds+" Detik";

}, 1000);
</script>

</body>
</html>