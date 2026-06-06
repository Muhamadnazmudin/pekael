<h1 class="h3 mb-4 text-gray-800">
    Rekap PKL (Metode Proporsional)
</h1>

<div class="card shadow-sm border-left-primary">

    <div class="card-body">

        <div class="mb-3">

            <a href="<?= base_url('laporan_propor/excel') ?>"
               class="btn btn-success shadow-sm">

                <i class="fa fa-file-excel"></i>
                Download Excel

            </a>

            <a href="<?= base_url('laporan_propor/pdf') ?>"
               class="btn btn-danger shadow-sm">

                <i class="fa fa-file-pdf"></i>
                Download PDF

            </a>

        </div>

        <div class="table-responsive">

            <table class="table table-bordered table-hover">

                <thead class="thead-light">

                    <tr class="text-center">
                        <th width="60">No</th>
                        <th>Nama Siswa</th>
                        <th>NISN</th>
                        <th>Kelas</th>
                        <th>Nama DUDI</th>
                        <th>Nomor MoU</th>
                        <th>Judul PKS</th>
                        <th>Nama Pembimbing</th>
                    </tr>

                </thead>

                <tbody>

                    <?php if(empty($rekap)): ?>

                        <tr>
                            <td colspan="8" class="text-center">
                                Data tidak ditemukan
                            </td>
                        </tr>

                    <?php else: ?>

                        <?php $no = 1; ?>

                        <?php foreach($rekap as $r): ?>

                            <tr>

                                <td class="text-center">
                                    <?= $no++ ?>
                                </td>

                                <td><?= $r['nama'] ?></td>

                                <td><?= $r['nisn'] ?></td>

                                <td><?= $r['kelas'] ?? '-' ?></td>

                                <td><?= $r['dudi'] ?? '-' ?></td>

                                <td><?= $r['nomor_mou'] ?? '-' ?></td>

                                <td><?= $r['judul_pks'] ?? '-' ?></td>

                                <td><?= $r['pembimbing'] ?? '-' ?></td>

                            </tr>

                        <?php endforeach; ?>

                    <?php endif; ?>

                </tbody>

            </table>

        </div>

    </div>

</div>