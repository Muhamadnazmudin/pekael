<!DOCTYPE html>
<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Kelulusan</title>
    <link href="<?= base_url('assets/sbadmin2/css/sb-admin-2.min.css') ?>" rel="stylesheet">
</head>

<body class="bg-gradient-primary d-flex align-items-center" style="min-height:100vh;">

<div class="container text-center">

    <div class="card shadow p-4">

        <h4>
            Selamat datang <b><?= $siswa->nama ?></b>
        </h4>

        <p>
            Di Web Kelulusan Siswa Kelas XII<br>
            Silahkan cek kelulusan Anda dengan klik tombol dibawah
        </p>

        <button onclick="mulaiCek()" class="btn btn-success btn-lg">
            CEK KELULUSAN
        </button>

    </div>

</div>

<!-- LOADING MODAL -->
<div id="loadingBox" style="display:none; position:fixed; top:0; left:0; width:100%; height:100%; background:black; color:white; text-align:center; padding-top:30%; font-size:20px; z-index:9999;">

    <div id="textLoading">Memproses Data...</div>

</div>

<script>

function mulaiCek(){

    document.getElementById('loadingBox').style.display = 'block';

    let teks = [
        "Memverifikasi Data...",
        "Menghitung Nilai...",
        "Menentukan Kelulusan...",
        "Harap Bersabar...",
        "Hasil Akan Ditampilkan..."
    ];

    let i = 0;

    let interval = setInterval(function(){
        document.getElementById('textLoading').innerHTML = teks[i];
        i++;

        if(i >= teks.length){
            clearInterval(interval);

            // redirect ke hasil setelah delay
            setTimeout(function(){
                window.location.href = "<?= base_url('cek/bylogin') ?>";
            }, 1500);
        }

    }, 1500);

}
</script>

</body>
</html>