<div class="container-fluid">

    <div class="d-sm-flex
                align-items-center
                justify-content-between
                mb-4">

        <div>

            <h1 class="h3 text-gray-800 mb-1">

                Dashboard PEKAEL

            </h1>

            <p class="text-muted mb-0">

                Monitoring pembagian
                guru PKL dan distribusi siswa

            </p>

        </div>

        <div class="text-muted">

            <i class="fas fa-calendar-alt"></i>

            <?= date('d F Y') ?>

        </div>

    </div>


    <!-- KARTU -->
    <div class="row">

        <div class="col-xl-3 col-md-6 mb-4">

            <div class="card border-left-primary shadow h-100 py-2">

                <div class="card-body">

                    <div class="row no-gutters align-items-center">

                        <div class="col mr-2">

                            <div class="text-xs
                                        font-weight-bold
                                        text-primary
                                        text-uppercase
                                        mb-1">

                                Total Guru

                            </div>

                            <div class="h4
                                        mb-0
                                        font-weight-bold
                                        text-gray-800">

                                <?= $total_guru ?>

                            </div>

                        </div>

                        <div class="col-auto">

                            <i class="fas fa-user-tie
                                      fa-2x
                                      text-gray-300"></i>

                        </div>

                    </div>

                </div>

            </div>

        </div>


        <div class="col-xl-3 col-md-6 mb-4">

            <div class="card border-left-success shadow h-100 py-2">

                <div class="card-body">

                    <div class="row no-gutters align-items-center">

                        <div class="col mr-2">

                            <div class="text-xs
                                        font-weight-bold
                                        text-success
                                        text-uppercase
                                        mb-1">

                                Siswa PKL

                            </div>

                            <div class="h4
                                        mb-0
                                        font-weight-bold
                                        text-gray-800">

                                <?= $total_siswa ?>

                            </div>

                        </div>

                        <div class="col-auto">

                            <i class="fas fa-users
                                      fa-2x
                                      text-gray-300"></i>

                        </div>

                    </div>

                </div>

            </div>

        </div>


        <div class="col-xl-3 col-md-6 mb-4">

            <div class="card border-left-info shadow h-100 py-2">

                <div class="card-body">

                    <div class="row no-gutters align-items-center">

                        <div class="col mr-2">

                            <div class="text-xs
                                        font-weight-bold
                                        text-info
                                        text-uppercase
                                        mb-1">

                                Rombel PKL

                            </div>

                            <div class="h4
                                        mb-0
                                        font-weight-bold
                                        text-gray-800">

                                <?= $total_rombel ?>

                            </div>

                        </div>

                        <div class="col-auto">

                            <i class="fas fa-school
                                      fa-2x
                                      text-gray-300"></i>

                        </div>

                    </div>

                </div>

            </div>

        </div>


        <div class="col-xl-3 col-md-6 mb-4">

            <div class="card border-left-warning shadow h-100 py-2">

                <div class="card-body">

                    <div class="row no-gutters align-items-center">

                        <div class="col mr-2">

                            <div class="text-xs
                                        font-weight-bold
                                        text-warning
                                        text-uppercase
                                        mb-1">

                                Koefisien PKL

                            </div>

                            <div class="h4
                                        mb-0
                                        font-weight-bold
                                        text-gray-800">

                                <?= number_format(
                                    $koefisien,
                                    6
                                ) ?>

                            </div>

                        </div>

                        <div class="col-auto">

                            <i class="fas fa-calculator
                                      fa-2x
                                      text-gray-300"></i>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>


    <!-- INFO -->
    <div class="row">

        <div class="col-lg-8 mb-4">

            <div class="card shadow">

                <div class="card-header
                            py-3">

                    <h6 class="m-0
                               font-weight-bold
                               text-primary">

                        Informasi Sistem

                    </h6>

                </div>

                <div class="card-body">

                    <div class="row text-center">

                        <div class="col-md-4">

                            <h4 class="font-weight-bold text-primary">

                                <?= $guru_pembimbing ?>

                            </h4>

                            <small class="text-muted">

                                Guru Pembimbing

                            </small>

                        </div>

                        <div class="col-md-4">

                            <h4 class="font-weight-bold text-success">

                                <?= $total_siswa ?>

                            </h4>

                            <small class="text-muted">

                                Siswa PKL

                            </small>

                        </div>

                        <div class="col-md-4">

                            <h4 class="font-weight-bold text-info">

                                <?= $total_rombel ?>

                            </h4>

                            <small class="text-muted">

                                Rombel PKL

                            </small>

                        </div>

                    </div>

                </div>

            </div>

        </div>


        <div class="col-lg-4 mb-4">

            <div class="card shadow">

                <div class="card-header py-3">

                    <h6 class="m-0
                               font-weight-bold
                               text-primary">

                        Status Sistem

                    </h6>

                </div>

                <div class="card-body">

                    <p class="mb-2">

                        <strong>
                            Tahun Aktif:
                        </strong>

                        2025/2026

                    </p>

                    <p class="mb-2">

                        <strong>
                            Koefisien:
                        </strong>

                        <?= number_format(
                            $koefisien,
                            6
                        ) ?>

                    </p>

                    <span class="badge badge-success p-2">

                        Sistem Aktif

                    </span>

                </div>

            </div>

        </div>

    </div>

</div>