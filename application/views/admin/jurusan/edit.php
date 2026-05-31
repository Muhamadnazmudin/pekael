<div class="container-fluid">

    <div class="card shadow">

        <div class="card-header">
            Edit Jurusan
        </div>

        <div class="card-body">

            <form method="POST">

                <div class="form-group">
                    <label>Kode Jurusan</label>
                    <input type="text"
                           name="kode_jurusan"
                           class="form-control"
                           value="<?= $jurusan->kode_jurusan ?>"
                           required>
                </div>

                <div class="form-group">
                    <label>Singkatan</label>
                    <input type="text"
                           name="singkatan"
                           class="form-control"
                           value="<?= $jurusan->singkatan ?>"
                           required>
                </div>

                <div class="form-group">
                    <label>Nama Jurusan</label>
                    <input type="text"
                           name="nama_jurusan"
                           class="form-control"
                           value="<?= $jurusan->nama_jurusan ?>"
                           required>
                </div>

                <button class="btn btn-primary">
                    Update
                </button>

                <a href="<?= base_url('jurusan') ?>"
                   class="btn btn-secondary">

                    Kembali
                </a>

            </form>

        </div>
    </div>
</div>