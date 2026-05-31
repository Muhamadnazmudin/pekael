<h1 class="h3 mb-4 text-gray-800">
    Rekap PKL
</h1>

<div class="card shadow-sm border-left-primary">

    <div class="card-body">

        <div class="mb-3">

            <a href="<?= base_url('rekappkl/excel') ?>"
               class="btn btn-success shadow-sm">

                <i class="fa fa-file-excel"></i>
                Download Excel
            </a>

            <a href="<?= base_url('rekappkl/pdf') ?>"
               class="btn btn-danger shadow-sm">

                <i class="fa fa-file-pdf"></i>
                Download PDF
            </a>

        </div>

        <div class="table-responsive">

            <table class="table table-hover table-bordered">

                <thead class="thead-light">

                    <tr class="text-center">
                        <th width="50">No</th>
                        <th>Nama Siswa</th>
                        <th>Kelas</th>
                        <th>Nama DUDI</th>
                        <th>Nama Pembimbing</th>
                    </tr>

                </thead>

               <tbody>

    <?php $no = 1; ?>

    <?php foreach($rekap as $r): ?>

    <tr>

        <td class="text-center">
            <?= $no++ ?>
        </td>

        <td>
            <?= $r['nama'] ?>
        </td>

        <td>
            <?= $r['nama_kelas'] ?? '-' ?>
        </td>

        <td>
            <?= $r['nama_dudi'] ?? '-' ?>
        </td>

        <td>
            <?= $r['nama_guru'] ?? '-' ?>
        </td>

    </tr>

    <?php endforeach; ?>

</tbody>
            </table>

        </div>

    </div>

</div>