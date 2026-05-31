<h1 class="h3 mb-4 text-gray-800">
    Data Guru
</h1>

<a href="<?= base_url('guru/tambah') ?>"
   class="btn btn-primary mb-3">

    Tambah Guru
</a>
<a href="<?= base_url('importguru/template') ?>"
   class="btn btn-success mb-3">

    <i class="fas fa-download"></i>
    Template Excel
</a>

<button class="btn btn-primary mb-3"
        data-toggle="modal"
        data-target="#modalImport">

    <i class="fas fa-file-excel"></i>
    Import Excel
</button>
<div class="d-flex justify-content-end mb-3">

    <form method="get"
          action="<?= base_url('guru') ?>">

        <div class="input-group" style="width:350px;">

            <input type="text"
                   name="keyword"
                   class="form-control"
                   placeholder="Cari guru..."
                   value="<?= $this->input->get('keyword') ?>">

            <div class="input-group-append">

                <button class="btn btn-primary"
                        type="submit">
                    Cari
                </button>

                <a href="<?= base_url('guru') ?>"
                   class="btn btn-secondary">
                    Reset
                </a>

            </div>

        </div>

    </form>

</div>
<table class="table table-bordered">

    <thead>
        <tr>
            <th>No</th>
            <th>NIP</th>
            <th>Nama Guru</th>
            <th>Jurusan</th>
            <th>Jenis</th>
            <th>Status</th>
            <th>Aksi</th>
        </tr>
    </thead>

    <tbody>

    <?php $no = isset($no) ? $no : 1; ?>
    <?php foreach($guru as $g): ?>

    <tr>

        <td><?= $no++ ?></td>

        <td>
            <?= $g->nip ?>
        </td>

        <td>
            <?= $g->nama_guru ?>
        </td>

        <td>
            <?= $g->singkatan ?? '-' ?>
        </td>

        <td>
            <?= ucfirst($g->jenis_guru) ?>
        </td>

        <td>

            <?php if($g->status=='aktif'): ?>

                <span class="badge badge-success">
                    Aktif
                </span>

            <?php else: ?>

                <span class="badge badge-secondary">
                    Nonaktif
                </span>

            <?php endif; ?>

        </td>

        <td>
            <a href="<?= base_url('guru/edit/'.$g->id) ?>"
               class="btn btn-warning btn-sm">

                Edit
            </a>

            <a href="<?= base_url('guru/hapus/'.$g->id) ?>"
               class="btn btn-danger btn-sm"
               onclick="return confirm('Hapus data?')">

                Hapus
            </a>
        </td>

    </tr>

    <?php endforeach; ?>

    </tbody>

</table>
<div class="mt-3">
    <?= $pagination ?>
</div>

<div class="modal fade"
     id="modalImport">

    <div class="modal-dialog">

        <div class="modal-content">

            <form action="<?= base_url('importguru/proses') ?>"
                  method="POST"
                  enctype="multipart/form-data">

                <div class="modal-header">
                    <h5 class="modal-title">
                        Import Data Guru
                    </h5>

                    <button type="button"
                            class="close"
                            data-dismiss="modal">

                        &times;
                    </button>
                </div>

                <div class="modal-body">

                    <div class="alert alert-info">

                        Format:
                        <br>

                        NIP |
                        Nama Guru |
                        Jurusan |
                        Jenis Guru |
                        Status

                    </div>

                    <input type="file"
                           name="file"
                           class="form-control"
                           accept=".xls,.xlsx"
                           required>

                </div>

                <div class="modal-footer">

                    <button type="submit"
                            class="btn btn-primary">

                        Import
                    </button>

                </div>

            </form>

        </div>

    </div>

</div>