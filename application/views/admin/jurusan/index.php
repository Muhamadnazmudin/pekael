<div class="container-fluid">

    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">
            Data Jurusan
        </h1>

        <a href="<?= base_url('jurusan/tambah') ?>"
           class="btn btn-primary">

            <i class="fas fa-plus"></i>
            Tambah
        </a>
    </div>

    <div class="card shadow mb-4">

        <div class="card-body">

            <div class="table-responsive">

                <table class="table table-bordered">

                    <thead>
                        <tr>
                            <th width="50">No</th>
                            <th>Kode</th>
                            <th>Singkatan</th>
                            <th>Nama Jurusan</th>
                            <th width="150">Aksi</th>
                        </tr>
                    </thead>

                    <tbody>

                    <?php $no=1; ?>
                    <?php foreach($jurusan as $j): ?>

                        <tr>
                            <td><?= $no++ ?></td>
                            <td><?= $j->kode_jurusan ?></td>
                            <td><?= $j->singkatan ?></td>
                            <td><?= $j->nama_jurusan ?></td>

                            <td>
                                <a href="<?= base_url('jurusan/edit/'.$j->id) ?>"
                                   class="btn btn-warning btn-sm">

                                   Edit
                                </a>

                                <a href="<?= base_url('jurusan/hapus/'.$j->id) ?>"
                                   class="btn btn-danger btn-sm"
                                   onclick="return confirm('Hapus data?')">

                                   Hapus
                                </a>
                            </td>
                        </tr>

                    <?php endforeach; ?>

                    </tbody>

                </table>

            </div>
        </div>
    </div>
</div>