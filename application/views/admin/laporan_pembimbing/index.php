<h1 class="h3 mb-4 text-gray-800">
    Laporan Pembimbing PKL
</h1>

<div class="card shadow-sm border-left-primary">

    <div class="card-body">

        <div class="alert alert-info shadow-sm">
            <i class="fa fa-info-circle"></i>
            Menampilkan jumlah jam mengajar dan siswa bimbingan PKL berdasarkan kelas yang diampu guru.
        </div>

        <?php $no = 1; ?>

        <?php foreach ($laporan as $row): ?>

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

                                    <th rowspan="2"
                                        class="align-middle"
                                        width="70">
                                        No
                                    </th>

                                    <th rowspan="2"
                                        class="align-middle">
                                        Nama Guru
                                    </th>

                                    <th colspan="<?= count($row['kelas']) ?>"
                                        class="bg-primary text-white">
                                        Jumlah Jam
                                    </th>

                                    <th colspan="<?= count($row['kelas']) ?>"
                                        class="bg-success text-white">
                                        Jumlah Siswa Bimbingan Per Kelas
                                    </th>

                                </tr>

                                <tr class="text-center">

                                    <?php foreach ($row['kelas'] as $k): ?>
                                        <th>
                                            <?= $k['nama_kelas'] ?>
                                        </th>
                                    <?php endforeach; ?>

                                    <?php foreach ($row['kelas'] as $k): ?>
                                        <th>
                                            <?= $k['nama_kelas'] ?>
                                        </th>
                                    <?php endforeach; ?>

                                </tr>

                            </thead>

                            <tbody>

                                <tr>

                                    <td class="text-center align-middle">
                                        <?= $no++ ?>
                                    </td>

                                    <td class="align-middle font-weight-bold">
                                        <?= $row['guru'] ?>
                                    </td>

                                    <!-- jumlah jam -->
                                    <?php foreach ($row['kelas'] as $k): ?>
                                        <td class="text-center align-middle">
                                            <?= $k['jam'] ?>
                                        </td>
                                    <?php endforeach; ?>

                                    <!-- jumlah siswa -->
                                    <?php foreach ($row['kelas'] as $k): ?>
                                        <td class="text-center align-middle">
                                            <?= $k['siswa'] ?>
                                        </td>
                                    <?php endforeach; ?>

                                </tr>

                            </tbody>

                        </table>

                    </div>

                </div>

            </div>

        <?php endforeach; ?>

    </div>

</div>