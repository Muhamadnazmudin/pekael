<h3 class="mb-4">
    Edit Siswa
</h3>

<div class="card shadow">

    <div class="card-body">

        <form method="post"
              enctype="multipart/form-data">

            <!-- NISN -->
            <div class="form-group">
                <label>NISN</label>

                <input type="text"
                       class="form-control"
                       value="<?= $siswa->nisn ?>"
                       readonly>

                <small class="text-muted">
                    NISN tidak dapat diubah
                </small>
            </div>

            <!-- NIS -->
            <div class="form-group">
                <label>NIS</label>

                <input type="text"
                       name="nis"
                       class="form-control"
                       value="<?= $siswa->nis ?>">
            </div>

            <!-- Nama -->
            <div class="form-group">
                <label>Nama Lengkap</label>

                <input type="text"
                       name="nama"
                       class="form-control"
                       value="<?= $siswa->nama ?>"
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

                    <option value="L"
                        <?= $siswa->jenis_kelamin == 'L'
                        ? 'selected' : '' ?>>

                        Laki-laki
                    </option>

                    <option value="P"
                        <?= $siswa->jenis_kelamin == 'P'
                        ? 'selected' : '' ?>>

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
                       class="form-control"
                       value="<?= $siswa->tempat_lahir ?>">
            </div>

            <!-- Tanggal Lahir -->
            <div class="form-group">
                <label>
                    Tanggal Lahir
                </label>

                <input type="date"
                       name="tanggal_lahir"
                       class="form-control"
                       value="<?= $siswa->tanggal_lahir ?>">
            </div>

            <!-- Orang Tua -->
            <div class="form-group">
                <label>
                    Nama Orang Tua / Wali
                </label>

                <input type="text"
                       name="nama_ortu"
                       class="form-control"
                       value="<?= $siswa->nama_ortu ?>">
            </div>

            <!-- Kelas -->
            <div class="form-group">
                <label>Kelas</label>

                <select name="kelas"
                        class="form-control"
                        required>

                    <?php foreach($kelas as $k): ?>

                    <option value="<?= $k->id ?>"
                        <?= $siswa->id_kelas == $k->id
                        ? 'selected'
                        : '' ?>>

                        <?= $k->nama_kelas ?>

                    </option>

                    <?php endforeach; ?>

                </select>

                <small class="text-muted">
                    Jurusan mengikuti kelas
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
                        <?= $siswa->id_tahun == $t->id
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

                <br>

                <?php if(
                    !empty($siswa->foto)
                    &&
                    $siswa->foto != 'default.png'
                ): ?>

                    <img src="<?= base_url(
                        'uploads/foto/' .
                        $siswa->foto
                    ) ?>"
                    width="120"
                    class="img-thumbnail">

                <?php else: ?>

                    <img src="<?= base_url(
                        'uploads/foto/default.png'
                    ) ?>"
                    width="120"
                    class="img-thumbnail">

                <?php endif; ?>

                <br><br>

                <input type="file"
                       name="foto"
                       class="form-control">

                <small class="text-muted">
                    Kosongkan jika tidak ingin
                    mengganti foto
                </small>
            </div>

            <button class="btn btn-primary btn-block">

                <i class="fas fa-save"></i>
                Update

            </button>

        </form>

    </div>

</div>