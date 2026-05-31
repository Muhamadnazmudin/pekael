<h1 class="h3 mb-4 text-gray-800">
    Distribusi Siswa PKL
</h1>

<div class="mb-4">

    <a href="<?= base_url('distribusi/generate') ?>"
       class="btn btn-primary">

        Generate Distribusi

    </a>

    <a href="<?= base_url('distribusi/reset') ?>"
       class="btn btn-danger"
       onclick="return confirm('Reset distribusi?')">

        Reset Distribusi

    </a>

</div>

<!-- =======================
MANUAL MAPPING
======================= -->
<div class="card shadow mb-4">

    <div class="card-header">

        <strong>
            Manual Mapping Pembimbing
        </strong>

    </div>

    <div class="card-body">

        <div class="row">

        <?php

        $guruSudah = [];

        foreach($distribusi as $d):

            if(
                in_array(
                    $d->guru_id,
                    $guruSudah
                )
            ){
                continue;
            }

            $guruSudah[] =
                $d->guru_id;
        ?>

            <div class="col-md-3 mb-2">

                <a href="<?= base_url(
                    'distribusi/manual/'
                    .$d->guru_id
                ) ?>"
                class="btn btn-warning btn-block">

                    <?= $d->nama_guru ?>

                </a>

            </div>

        <?php endforeach; ?>

        </div>

    </div>

</div>

<!-- =======================
TABEL DISTRIBUSI
======================= -->

<div class="card shadow">

    <div class="card-body">

        <table class="table table-bordered table-striped">

            <thead class="thead-light">

                <tr>

                    <th>No</th>

                    <th>Kelas</th>

                    <th>Jurusan</th>

                    <th>Guru Pembimbing</th>

                    <th>NIP</th>

                    <th>Siswa</th>

                    <th>NISN</th>

                    <th>Metode</th>

                    <th>Tahun</th>

                </tr>

            </thead>

            <tbody>

            <?php
            $no=1;

            foreach(
                $distribusi
                as $d
            ):
            ?>

            <tr>

                <td>
                    <?= $no++ ?>
                </td>

                <td>
                    <?= $d->nama_kelas ?>
                </td>

                <td>
                    <?= $d->singkatan ?>
                </td>

                <td>
                    <?= $d->nama_guru ?>
                </td>

                <td>
                    <?= $d->nip ?>
                </td>

                <td>
                    <?= $d->nama ?>
                </td>

                <td>
                    <?= $d->nisn ?>
                </td>

                <td>

                    <?php if(
                        $d->metode
                        ==
                        'manual'
                    ): ?>

                        <span class="badge badge-success">

                            Manual

                        </span>

                    <?php else: ?>

                        <span class="badge badge-info">

                            Otomatis

                        </span>

                    <?php endif; ?>

                </td>

                <td>
                    <?= $d->tahun ?>
                </td>

            </tr>

            <?php endforeach; ?>

            </tbody>

        </table>

    </div>

</div>