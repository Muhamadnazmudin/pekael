<h1 class="h3 mb-4 text-gray-800">
    Laporan Pembimbing PKL (Metode Proporsional)
</h1>

<div class="card shadow-sm border-left-primary">

    <div class="card-body">

        <div class="alert alert-info shadow-sm">
            <i class="fa fa-info-circle"></i>
            Menampilkan jumlah jam mengajar dan siswa bimbingan PKL berdasarkan distribusi metode proporsional.
        </div>

        <?php $no = 1; ?>

        <?php foreach ($laporan as $row): ?>

            <?php
            $total_rowspan = 0;

            foreach ($row['kelas'] as $k) {
                $total_rowspan += max(1, count($k['nama_siswa']));
            }
            ?>

            <div class="card shadow-sm mb-4 border-left-info">

                <div class="card-header py-3 d-flex justify-content-between align-items-center">

                    <h6 class="m-0 font-weight-bold text-info">
                        <i class="fa fa-user"></i>
                        <?= $row['guru'] ?>
                    </h6>

                    <div>
                        <span class="badge badge-primary p-2">
                            Total Jam:
                            <?= $row['total_jam'] ?>
                        </span>

                        <span class="badge badge-success p-2">
                            Total Siswa:
                            <?= $row['total_siswa'] ?>
                        </span>
                    </div>

                </div>

                <div class="card-body">

                    <div class="table-responsive">

                        <table class="table table-bordered table-hover">

                            <thead class="thead-light">
                                <tr class="text-center">
                                    <th width="60">No</th>
                                    <th>Nama Guru</th>
                                    <th width="120">Jumlah Jam</th>
                                    <th>Kelas</th>
                                    <th width="120">Jumlah Siswa</th>
                                    <th>Nama Siswa</th>
                                </tr>
                            </thead>

                            <tbody>

                                <?php $guru_printed = false; ?>

                                <?php foreach ($row['kelas'] as $k): ?>

                                    <?php
                                    $siswa = !empty($k['nama_siswa'])
                                        ? $k['nama_siswa']
                                        : ['-'];

                                    $rowspan_kelas = count($siswa);
                                    ?>

                                    <?php foreach ($siswa as $i => $nama): ?>

                                        <tr>

                                            <?php if (!$guru_printed && $i == 0): ?>

                                                <td rowspan="<?= $total_rowspan ?>"
                                                    class="text-center align-middle">
                                                    <?= $no ?>
                                                </td>

                                                <td rowspan="<?= $total_rowspan ?>"
                                                    class="align-middle font-weight-bold">
                                                    <?= $row['guru'] ?>
                                                </td>

                                                <?php $guru_printed = true; ?>

                                            <?php endif; ?>

                                            <?php if ($i == 0): ?>

                                                <td rowspan="<?= $rowspan_kelas ?>"
                                                    class="text-center align-middle">
                                                    <?= (int) $k['jam'] ?>
                                                </td>

                                                <td rowspan="<?= $rowspan_kelas ?>"
                                                    class="align-middle">
                                                    <?= $k['nama_kelas'] ?>
                                                </td>

                                                <td rowspan="<?= $rowspan_kelas ?>"
                                                    class="text-center align-middle">
                                                    <?= $k['siswa'] ?>
                                                </td>

                                            <?php endif; ?>

                                            <td>
                                                <?= $nama ?>
                                            </td>

                                        </tr>

                                    <?php endforeach; ?>

                                <?php endforeach; ?>

                            </tbody>

                        </table>

                    </div>

                </div>

            </div>

            <?php $no++; ?>

        <?php endforeach; ?>

    </div>

</div>