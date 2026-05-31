<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Login</title>

    <link href="<?= base_url('assets/sbadmin2/vendor/fontawesome-free/css/all.min.css') ?>" rel="stylesheet">
    <link href="<?= base_url('assets/sbadmin2/css/sb-admin-2.min.css') ?>" rel="stylesheet">

    <style>
    body{
        min-height:100vh;
        display:flex;
        align-items:center;
        justify-content:center;

        background:
        linear-gradient(
            135deg,
            #1f2937 0%,
            #2d3748 100%
        );
    }

    .login-card{
        border:none;
        border-radius:20px;
        overflow:hidden;
        background:#ffffff;
        box-shadow:
        0 20px 40px rgba(
            0,0,0,.25
        );
    }

    .login-header{
        background:
        linear-gradient(
            135deg,
            #4e73df,
            #224abe
        );

        color:#fff;
        padding:30px;
        text-align:center;
    }

    .login-header i{
        font-size:50px;
        margin-bottom:10px;
    }

    .login-header h4{
        margin:0;
        font-weight:700;
    }

    .card-body{
        padding:35px;
    }

    .form-control{
        height:48px;
        border-radius:12px;
        border:1px solid #d1d5db;
    }

    .form-control:focus{
        box-shadow:none;
        border-color:#4e73df;
    }

    .input-group-text{
        background:#fff;
        border-radius:0 12px 12px 0;
        cursor:pointer;
    }

    .btn-login{
        height:48px;
        border:none;
        border-radius:12px;

        background:
        linear-gradient(
            135deg,
            #4e73df,
            #224abe
        );

        font-weight:600;
        color:#fff;
    }

    .btn-login:hover{
        opacity:.95;
    }

    .login-footer{
        text-align:center;
        margin-top:20px;
    }

    .login-footer a{
        color:#4e73df;
        text-decoration:none;
        font-weight:600;
    }

    .login-footer a:hover{
        text-decoration:underline;
    }

    .brand-text{
        font-size:14px;
        color:#6b7280;
    }

    @media(max-width:576px){

        .card-body{
            padding:25px;
        }

        .login-header{
            padding:25px;
        }

        .login-header h4{
            font-size:22px;
        }
    }
</style>
</head>

<body class="bg-gradient-primary">

<div class="container">
    <div class="row justify-content-center">
        <div class="col-lg-5 col-md-7 col-sm-10">

            <div class="card login-card">

    <div class="login-header">

        <i class="fas fa-user-graduate"></i>

        <h4>PEKAEL</h4>

        <small>
            Sistem Perhitungan PKL
        </small>

    </div>

    <div class="card-body">

        <?php if($this->session->flashdata('error')): ?>

            <div class="alert alert-danger">

                <?= $this->session->flashdata('error') ?>

            </div>

        <?php endif; ?>

        <form method="post"
              action="<?= base_url('auth/login') ?>">

            <div class="form-group">

                <input
                    type="text"
                    name="username"
                    class="form-control"
                    placeholder="Username "
                    required>

            </div>

            <div class="form-group">

                <div class="input-group">

                    <input
                        type="password"
                        name="password"
                        id="password"
                        class="form-control"
                        placeholder="Password"
                        required>

                    <div class="input-group-append">

                        <span
                            class="input-group-text"
                            onclick="togglePassword()">

                            <i
                                class="fas fa-eye"
                                id="icon-eye"></i>

                        </span>

                    </div>

                </div>

            </div>

            <small
                class="brand-text d-block text-center mb-3">

                

            </small>

            <button
                class="btn btn-login btn-block">

                Login

            </button>

        </form>

        <div class="login-footer">

            <a href="<?= base_url() ?>">

                ← Kembali ke Beranda

            </a>

        </div>

    </div>

</div>

        </div>
    </div>
</div>

<script>
function togglePassword() {
    var pass = document.getElementById("password");
    var icon = document.getElementById("icon-eye");

    if (pass.type === "password") {
        pass.type = "text";
        icon.classList.remove("fa-eye");
        icon.classList.add("fa-eye-slash");
    } else {
        pass.type = "password";
        icon.classList.remove("fa-eye-slash");
        icon.classList.add("fa-eye");
    }
}
</script>

</body>
</html>