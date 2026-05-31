<h3>Edit Kelas</h3>

<form method="post">

    <div class="form-group">
        <label>Nama Kelas</label>

        <input type="text"
               name="nama_kelas"
               class="form-control"
               value="<?= $kelas->nama_kelas ?>"
               required>
    </div>

    <div class="form-group">
        <label>Jurusan</label>

        <select name="jurusan_id"
                class="form-control"
                required>

            <option value="">
                -- Pilih Jurusan --
            </option>

            <?php foreach($jurusan as $j): ?>

            <option value="<?= $j->id ?>"
                <?= ($kelas->jurusan_id == $j->id)
                    ? 'selected'
                    : '' ?>>

                <?= $j->singkatan ?>
                -
                <?= $j->nama_jurusan ?>

            </option>

            <?php endforeach; ?>

        </select>
    </div>

    <div class="form-group">
        <label>Tingkat</label>

        <select name="tingkat"
                class="form-control"
                required>

            <option value="X"
                <?= $kelas->tingkat == 'X'
                ? 'selected' : '' ?>>

                X
            </option>

            <option value="XI"
                <?= $kelas->tingkat == 'XI'
                ? 'selected' : '' ?>>

                XI
            </option>

            <option value="XII"
                <?= $kelas->tingkat == 'XII'
                ? 'selected' : '' ?>>

                XII
            </option>

        </select>
    </div>

    <div class="form-group">
        <label>Status PKL</label>

        <select name="status_pkl"
                class="form-control"
                required>

            <option value="ya"
                <?= $kelas->status_pkl == 'ya'
                ? 'selected' : '' ?>>

                PKL
            </option>

            <option value="tidak"
                <?= $kelas->status_pkl == 'tidak'
                ? 'selected' : '' ?>>

                Tidak PKL
            </option>

        </select>
    </div>

    <button class="btn btn-primary">
        Update
    </button>

    <a href="<?= base_url('kelas') ?>"
       class="btn btn-secondary">

        Kembali
    </a>

</form>