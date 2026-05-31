<h1 class="h3 mb-4 text-gray-800">
    Tambah Guru
</h1>

<div class="card shadow">

    <div class="card-body">

        <form method="post">

            <div class="form-group">
                <label>NIP</label>

                <input type="text"
                       name="nip"
                       class="form-control"
                       placeholder="Masukkan NIP">
            </div>

            <div class="form-group">
                <label>Nama Guru</label>

                <input type="text"
                       name="nama_guru"
                       class="form-control"
                       required>
            </div>

            <div class="form-group">
                <label>Jurusan</label>

                <select name="jurusan_id"
                        class="form-control">

                    <option value="">
                        -- Pilih Jurusan --
                    </option>

                    <?php foreach($jurusan as $j): ?>

                    <option value="<?= $j->id ?>">

                        <?= $j->singkatan ?>
                        -
                        <?= $j->nama_jurusan ?>

                    </option>

                    <?php endforeach; ?>

                </select>

                <small class="text-muted">
                    Kosongkan jika guru umum/normatif
                </small>
            </div>

            <div class="form-group">
                <label>Jenis Guru</label>

                <select name="jenis_guru"
                        class="form-control"
                        required>

                    <option value="produktif">
                        Produktif
                    </option>

                    <option value="normatif">
                        Normatif
                    </option>

                    <option value="adaptif">
                        Adaptif
                    </option>

                </select>
            </div>

            <div class="form-group">
                <label>Status</label>

                <select name="status"
                        class="form-control"
                        required>

                    <option value="aktif">
                        Aktif
                    </option>

                    <option value="nonaktif">
                        Nonaktif
                    </option>

                </select>
            </div>

            <button class="btn btn-primary">
                Simpan
            </button>

            <a href="<?= base_url('guru') ?>"
               class="btn btn-secondary">

                Kembali
            </a>

        </form>

    </div>

</div>