<?php
$belum_pembimbing = isset($belum_pembimbing) ? $belum_pembimbing : 0;
$belum_dudi       = isset($belum_dudi) ? $belum_dudi : 0;
$total_rombel_semua = isset($total_rombel_semua) ? $total_rombel_semua : 0;
?>

<div class="container-fluid">

    <!-- HEADER -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">

        <div>
            <h1 class="h3 mb-1 font-weight-bold text-gray-100">
                Dashboard PEKAEL
            </h1>

            <p class="text-muted mb-0">
                Monitoring pembagian guru pembimbing PKL dan distribusi siswa
            </p>
        </div>

        <div class="text-muted">
            <i class="fas fa-calendar-alt mr-1"></i>
            <?= date('d M Y') ?>
        </div>

    </div>

    <!-- BARIS 1 -->
    <div class="row">

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-2">
                                Total Guru
                            </div>

                            <div class="h2 font-weight-bold text-gray-100">
                                <?= number_format($total_guru) ?>
                            </div>
                        </div>

                        <div class="col-auto">
                            <i class="fas fa-user-tie fa-3x text-gray-400"></i>
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
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-2">
                                Siswa PKL Kelas XII
                            </div>

                            <div class="h2 font-weight-bold text-gray-100">
                                <?= number_format($total_siswa) ?>
                            </div>
                        </div>

                        <div class="col-auto">
                            <i class="fas fa-users fa-3x text-gray-400"></i>
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
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-2">
                                Guru Sebagai Pembimbing
                            </div>

                            <div class="h2 font-weight-bold text-gray-100">
                                <?= number_format($guru_pembimbing) ?>
                            </div>
                        </div>

                        <div class="col-auto">
                            <i class="fas fa-chalkboard-teacher fa-3x text-gray-400"></i>
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
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-2">
                                Koefisien PKL
                            </div>

                            <div class="h4 font-weight-bold text-gray-100">
                                <?= number_format($koefisien, 6) ?>
                            </div>
                        </div>

                        <div class="col-auto">
                            <i class="fas fa-calculator fa-3x text-gray-400"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <!-- BARIS 2 -->
    <div class="row">

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-secondary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-secondary text-uppercase mb-2">
                                Total Rombel XII
                            </div>

                            <div class="h2 font-weight-bold text-gray-100">
                                <?= $total_rombel_semua ?>
                            </div>
                        </div>

                        <div class="col-auto">
                            <i class="fas fa-school fa-3x text-gray-400"></i>
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
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-2">
                                Rombel kelas XII yang PKL
                            </div>

                            <div class="h2 font-weight-bold text-gray-100">
                                <?= $total_rombel ?>
                            </div>
                        </div>

                        <div class="col-auto">
                            <i class="fas fa-layer-group fa-3x text-gray-400"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-danger shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-danger text-uppercase mb-2">
                                Siswa Belum Ada Pembimbing
                            </div>

                            <div class="h2 font-weight-bold text-danger">
                                <?= $belum_pembimbing ?>
                            </div>
                        </div>

                        <div class="col-auto">
                            <i class="fas fa-user-times fa-3x text-gray-400"></i>
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
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-2">
                               Siswa Belum Mapping DUDI
                            </div>

                            <div class="h2 font-weight-bold text-warning">
                                <?= $belum_dudi ?>
                            </div>
                        </div>

                        <div class="col-auto">
                            <i class="fas fa-building fa-3x text-gray-400"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

</div>

<div class="row">

    <div class="col-lg-12">

        <div class="card shadow mb-4">

            <div class="card-header py-3 d-flex justify-content-between align-items-center">

                <h6 class="m-0 font-weight-bold text-primary">
                    Monitoring Rombel PKL
                </h6>

                <span class="badge badge-info">
                    <?= count($monitoring_rombel) ?> Rombel
                </span>

            </div>

            <div class="card-body p-0">

                <div class="table-responsive">

                    <table class="table table-hover mb-0">

                        <thead class="thead-light">

                            <tr>
                                <th width="60">#</th>
                                <th>Rombel</th>
                                <th width="140">Total Siswa</th>
                                <th width="180">Belum Dapat DUDI</th>
                                <th width="220">Progress</th>
                                <th width="140">Status</th>
                            </tr>

                        </thead>

                        <tbody>

                            <?php if(empty($monitoring_rombel)): ?>

                                <tr>
                                    <td colspan="6" class="text-center text-muted py-4">
                                        Tidak ada data
                                    </td>
                                </tr>

                            <?php else: ?>

                                <?php $no = 1; ?>

                                <?php foreach($monitoring_rombel as $r): ?>

                                    <?php
                                        $sudah_dudi =
                                            $r->total_siswa - $r->belum_dudi;

                                        $persen =
                                            $r->total_siswa > 0
                                            ? round(($sudah_dudi / $r->total_siswa) * 100)
                                            : 0;
                                    ?>

                                    <tr>

                                        <td>
                                            <?= $no++ ?>
                                        </td>

                                        <td>
                                            <strong>
                                                <?= $r->nama_kelas ?>
                                            </strong>
                                        </td>

                                        <td>
                                            <?= $r->total_siswa ?>
                                        </td>

                                        <td>

                                            <?php if($r->belum_dudi > 0): ?>

                                                <button
                                                    class="btn btn-sm btn-danger"
                                                    data-toggle="modal"
                                                    data-target="#modalDudi<?= $r->id ?>">

                                                    <i class="fas fa-exclamation-circle"></i>

                                                    <?= $r->belum_dudi ?>

                                                </button>

                                            <?php else: ?>

                                                <span class="badge badge-success px-3 py-2">
                                                    0
                                                </span>

                                            <?php endif; ?>

                                        </td>

                                        <td>

                                            <div class="progress">

                                                <div
                                                    class="progress-bar bg-success"
                                                    role="progressbar"
                                                    style="width: <?= $persen ?>%;">

                                                    <?= $persen ?>%

                                                </div>

                                            </div>

                                        </td>

                                        <td>

                                            <?php if($r->belum_dudi > 0): ?>

                                                <span class="badge badge-warning px-3 py-2">
                                                    Belum Selesai
                                                </span>

                                            <?php else: ?>

                                                <span class="badge badge-success px-3 py-2">
                                                    Selesai
                                                </span>

                                            <?php endif; ?>

                                        </td>

                                    </tr>

                                <?php endforeach; ?>

                            <?php endif; ?>

                        </tbody>

                    </table>
<?php foreach($monitoring_rombel as $r): ?>

<div
    class="modal fade"
    id="modalDudi<?= $r->id ?>"
    tabindex="-1">

    <div class="modal-dialog modal-lg">

        <div class="modal-content">

            <div class="modal-header">

                <h5 class="modal-title">

                    <?= $r->nama_kelas ?>

                </h5>

                <button
                    type="button"
                    class="close"
                    data-dismiss="modal">

                    <span>&times;</span>

                </button>

            </div>

           <div class="modal-body">

    <?php if(empty($r->siswa_belum_dudi)): ?>

        <div class="alert alert-success mb-0">
            Semua siswa sudah mendapatkan DUDI.
        </div>

    <?php else: ?>

        <div class="table-responsive">

            <table class="table table-sm table-striped">

                <thead>
                    <tr>
                        <th width="60">No</th>
                        <th>Nama Siswa</th>
                    </tr>
                </thead>

                <tbody>

                    <?php $no = 1; ?>

                    <?php foreach($r->siswa_belum_dudi as $s): ?>

                        <tr>
                            <td><?= $no++ ?></td>
                            <td><?= $s->nama ?></td>
                        </tr>

                    <?php endforeach; ?>

                </tbody>

            </table>

        </div>

    <?php endif; ?>

</div>

        </div>

    </div>

</div>

<?php endforeach; ?>
                </div>

            </div>

        </div>

    </div>

</div>
