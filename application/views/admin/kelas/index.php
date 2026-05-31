<h1 class="h3 mb-4 text-gray-800">
    Data Kelas
</h1>

<a href="<?= base_url('kelas/tambah') ?>"
   class="btn btn-primary mb-3">

    <i class="fas fa-plus"></i>
    Tambah
</a>

<table class="table table-bordered table-hover">

    <thead>
        <tr>
            <th>No</th>
            <th>Nama Kelas</th>
            <th>Jurusan</th>
            <th>Tingkat</th>
            <th>Status PKL</th>
            <th>Aksi</th>
        </tr>
    </thead>

    <tbody>

    <?php $no=1; ?>
    <?php foreach($kelas as $k): ?>

    <tr>

        <td><?= $no++ ?></td>

        <td>
            <?= $k->nama_kelas ?>
        </td>

        <td>
            <?= $k->singkatan ?? '-' ?>
        </td>

        <td>
            <?= $k->tingkat ?>
        </td>

        <td class="text-center">

            <?php if($k->status_pkl == 'ya'): ?>

                <span class="badge badge-success">
                    PKL
                </span>

            <?php else: ?>

                <span class="badge badge-secondary">
                    Tidak PKL
                </span>

            <?php endif; ?>

        </td>

        <td>

            <a href="<?= base_url('kelas/edit/'.$k->id) ?>"
               class="btn btn-warning btn-sm">

                Edit
            </a>

            <a href="<?= base_url('kelas/hapus/'.$k->id) ?>"
               class="btn btn-danger btn-sm"
               onclick="return confirm('Yakin hapus data?')">

                Hapus
            </a>

        </td>

    </tr>

    <?php endforeach; ?>

    </tbody>

</table>