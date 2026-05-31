<h3 class="mb-4">
    Tambah Siswa
</h3>

<div class="card shadow">

    <div class="card-body">

        <form method="post"
              enctype="multipart/form-data">

            <!-- NISN -->
            <div class="form-group">
                <label>NISN</label>

                <input type="text"
                       name="nisn"
                       class="form-control"
                       required>
            </div>

            <!-- NIS -->
            <div class="form-group">
                <label>NIS</label>

                <input type="text"
                       name="nis"
                       class="form-control">
            </div>

            <!-- Nama -->
            <div class="form-group">
                <label>Nama Lengkap</label>

                <input type="text"
                       name="nama"
                       class="form-control"
                       required>
            </div>

            <!-- Jenis Kelamin -->
            <div class="form-group">
                <label>
                    Jenis Kelamin
                </label>

                <select name="jk"
                        class="form-control"
                        required>

                    <option value="L">
                        Laki-laki
                    </option>

                    <option value="P">
                        Perempuan
                    </option>

                </select>
            </div>

            <!-- Tempat Lahir -->
            <div class="form-group">
                <label>
                    Tempat Lahir
                </label>

                <input type="text"
                       name="tempat_lahir"
                       class="form-control">
            </div>

            <!-- Tanggal Lahir -->
            <div class="form-group">
                <label>
                    Tanggal Lahir
                </label>

                <input type="date"
                       name="tanggal_lahir"
                       class="form-control">
            </div>

            <!-- Orang Tua -->
            <div class="form-group">
                <label>
                    Nama Orang Tua / Wali
                </label>

                <input type="text"
                       name="nama_ortu"
                       class="form-control">
            </div>

            <!-- Kelas -->
            <div class="form-group">
                <label>Kelas</label>

                <select name="kelas"
                        class="form-control"
                        required>

                    <option value="">
                        -- Pilih Kelas --
                    </option>

                    <?php foreach($kelas as $k): ?>

                    <option value="<?= $k->id ?>">

                        <?= $k->nama_kelas ?>

                    </option>

                    <?php endforeach; ?>

                </select>

                <small class="text-muted">
                    Jurusan otomatis mengikuti kelas
                </small>
            </div>

            <!-- Tahun -->
            <div class="form-group">
                <label>
                    Tahun Ajaran
                </label>

                <select name="tahun"
                        class="form-control"
                        required>

                    <?php foreach($tahun as $t): ?>

                    <option value="<?= $t->id ?>"
                        <?= $t->status == 'aktif'
                        ? 'selected'
                        : '' ?>>

                        <?= $t->tahun ?>

                        <?php if($t->status == 'aktif'): ?>
                            (Aktif)
                        <?php endif; ?>

                    </option>

                    <?php endforeach; ?>

                </select>
            </div>

            <!-- Foto -->
            <div class="form-group">
                <label>
                    Foto Siswa
                </label>

                <input type="file"
                       name="foto"
                       class="form-control">

                <small class="text-muted">
                    Format JPG/PNG max 2MB
                </small>
            </div>

            <button class="btn btn-primary btn-block">

                <i class="fas fa-save"></i>
                Simpan

            </button>

        </form>

    </div>

</div>