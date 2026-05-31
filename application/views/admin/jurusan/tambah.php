<div class="container-fluid">

    <div class="card shadow">

        <div class="card-header">
            Tambah Jurusan
        </div>

        <div class="card-body">

            <form method="POST">

                <div class="form-group">
                    <label>Kode Jurusan</label>
                    <input type="text"
                           name="kode_jurusan"
                           class="form-control"
                           required>
                </div>

                <div class="form-group">
                    <label>Singkatan</label>
                    <input type="text"
                           name="singkatan"
                           class="form-control"
                           required>
                </div>

                <div class="form-group">
                    <label>Nama Jurusan</label>
                    <input type="text"
                           name="nama_jurusan"
                           class="form-control"
                           required>
                </div>

                <button class="btn btn-primary">
                    Simpan
                </button>

                <a href="<?= base_url('jurusan') ?>"
                   class="btn btn-secondary">

                    Kembali
                </a>

            </form>

        </div>
    </div>
</div>