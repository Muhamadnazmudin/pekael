<h1 class="h3 mb-4 text-gray-800">
    Pusat Unduhan
</h1>

<div class="card shadow mb-4">

    <div class="card-header py-3">

        <button
            class="btn btn-primary"
            data-toggle="modal"
            data-target="#modalUpload">

            <i class="fa fa-upload"></i>
            Upload File

        </button>

    </div>

    <div class="card-body">

        <div class="table-responsive">

            <table class="table table-bordered">

                <thead>

                    <tr>
                        <th>No</th>
                        <th>Judul</th>
                        <th>Kategori</th>
                        <th>Ukuran</th>
                        <th>Aksi</th>
                    </tr>

                </thead>

                <tbody>

                <?php
                $no=1;
                foreach($files as $f):
                ?>

                <tr>

                    <td><?= $no++ ?></td>

                    <td><?= $f->judul ?></td>

                    <td>
                        <?= $f->kategori ?>
                    </td>

                    <td>
                        <?= $f->ukuran_file ?>
                    </td>

                    <td width="180">

                        <a href="<?= base_url(
                            'pusatunduhan/download/'.$f->id
                        ) ?>"
                           class="btn btn-success btn-sm">

                            Download

                        </a>

                        <a href="<?= base_url(
                            'pusatunduhan/hapus/'.$f->id
                        ) ?>"
                           onclick="return confirm('Hapus file?')"
                           class="btn btn-danger btn-sm">

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
<div class="modal fade" id="modalUpload">

    <div class="modal-dialog">

        <form
            method="post"
            enctype="multipart/form-data"
            action="<?= base_url(
                'pusatunduhan/upload'
            ) ?>">

            <div class="modal-content">

                <div class="modal-header">

                    <h5>
                        Upload File
                    </h5>

                </div>

                <div class="modal-body">

                    <div class="form-group">

                        <label>
                            Judul
                        </label>

                        <input
                            type="text"
                            name="judul"
                            class="form-control"
                            required>

                    </div>

                    <div class="form-group">

                        <label>
                            Kategori
                        </label>

                        <select
                            name="kategori"
                            class="form-control">

                            <option>
                                Panduan
                            </option>

                            <option>
                                Juknis
                            </option>

                            <option>
                                Template
                            </option>

                            <option>
                                Surat
                            </option>

                        </select>

                    </div>

                    <div class="form-group">

                        <label>
                            File
                        </label>

                        <input
                            type="file"
                            name="file"
                            class="form-control"
                            required>

                    </div>

                </div>

                <div class="modal-footer">

                    <button
                        type="submit"
                        class="btn btn-primary">

                        Upload

                    </button>

                </div>

            </div>

        </form>

    </div>

</div>