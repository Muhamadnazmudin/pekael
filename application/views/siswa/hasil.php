<!DOCTYPE html>
<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Hasil Kelulusan</title>

    <link href="<?= base_url('assets/sbadmin2/css/sb-admin-2.min.css') ?>" rel="stylesheet">

    <style>
        .result-text {
            font-size: 40px;
            font-weight: bold;
            letter-spacing: 2px;
        }
    </style>
</head>

<body class="bg-gradient-success d-flex align-items-center justify-content-center" style="min-height:100vh;">

<div class="container">

    <!-- 🔐 LOGOUT BUTTON -->
    <div class="text-right mb-2">
        <a href="<?= base_url('logout') ?>" class="btn btn-sm btn-light">
            Logout
        </a>
    </div>

    <div class="row justify-content-center">
        <div class="col-lg-5 col-md-8 col-12">

            <div class="card shadow text-center">
                <div class="card-body p-4">

                    <h5 class="mb-3">HASIL KELULUSAN</h5>

                    <hr>

                    <h4 class="font-weight-bold"><?= $siswa->nama ?></h4>
                    <p class="text-muted"><?= $siswa->nisn ?></p>

                    <hr>

                    <!-- 🔥 HASIL (DINAMIS + RAPI) -->
                    <h1 id="hasilText" class="result-text"></h1>

                    <p class="mt-2"><?= $siswa->keterangan ?></p>

                    <?php if($siswa->status == 'lulus'): ?>
                        <a href="<?= base_url('cetak/'.$siswa->nisn) ?>"
                           class="btn btn-primary btn-block mt-3">
                            CETAK SKL
                        </a>
                    <?php endif; ?>

                    <br>
                    <a href="<?= base_url('cek') ?>">Cek Lagi</a>

                </div>
            </div>

        </div>
    </div>

</div>

<!-- 🎉 CONFETTI (RAPI) -->
<script src="https://cdn.jsdelivr.net/npm/canvas-confetti@1.6.0/dist/confetti.browser.min.js"></script>

<script>

let status = "<?= $siswa->status ?>";

setTimeout(function(){

    let el = document.getElementById('hasilText');

    if(status === 'lulus'){
        el.innerHTML = "LULUS";
        el.classList.add('text-success');

        // 🎉 confetti halus
        confetti({
            particleCount: 120,
            spread: 70,
            origin: { y: 0.6 }
        });

    }else{
        el.innerHTML = "TIDAK DITEMUKAN";
        el.classList.add('text-danger');
    }

}, 800);

</script>

</body>
</html>