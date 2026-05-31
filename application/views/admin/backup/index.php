<?php if($this->session->flashdata('success')): ?>

<div class="alert alert-success">
    <?= $this->session->flashdata('success') ?>
</div>

<?php endif; ?>

<?php if($this->session->flashdata('error')): ?>

<div class="alert alert-danger">
    <?= $this->session->flashdata('error') ?>
</div>

<?php endif; ?>

<h1 class="h3 mb-4 text-gray-800">
    Backup & Restore Database
</h1>

<div class="row">

    <!-- BACKUP -->
    <div class="col-md-6">

        <div class="card shadow mb-4">

            <div class="card-header">

                <h6 class="m-0 font-weight-bold text-success">
                    Backup Database
                </h6>

            </div>

            <div class="card-body">

                <p>
                    Download seluruh database PEKAEL
                    dalam format SQL.
                </p>

                <a href="<?= base_url(
                    'backup/database'
                ) ?>"
                class="btn btn-success">

                    <i class="fas fa-download"></i>

                    Download Backup

                </a>

            </div>

        </div>

    </div>

    <!-- RESTORE -->
    <div class="col-md-6">

        <div class="card shadow mb-4">

            <div class="card-header">

                <h6 class="m-0 font-weight-bold text-primary">
                    Restore Database
                </h6>

            </div>

            <div class="card-body">

                <div class="alert alert-warning">

                    <strong>Peringatan!</strong>

                    Restore akan menimpa data
                    yang ada saat ini.

                </div>

                <form
                    action="<?= base_url(
                        'backup/restore'
                    ) ?>"
                    method="post"
                    enctype="multipart/form-data">

                    <div class="form-group">

                        <label>
                            File SQL
                        </label>

                        <input
                            type="file"
                            name="database"
                            class="form-control"
                            accept=".sql"
                            required>

                    </div>

                    <button
                        type="submit"
                        class="btn btn-primary">

                        <i class="fas fa-upload"></i>

                        Restore Database

                    </button>

                </form>

            </div>

        </div>

    </div>

</div>