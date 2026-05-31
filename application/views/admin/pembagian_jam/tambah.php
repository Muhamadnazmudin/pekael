<h3>Tambah Pembagian Jam</h3>

<form method="post">

    <div class="form-group">
        <label>Guru</label>

        <select name="guru"
                class="form-control"
                required>

            <option value="">
                -- Pilih Guru --
            </option>

            <?php foreach($guru as $g): ?>

            <option value="<?= $g->id ?>">

                <?= $g->nama_guru ?>

            </option>

            <?php endforeach; ?>

        </select>
    </div>

    <div class="form-group">
        <label>Kelas XII PKL</label>

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
    </div>

    <div class="form-group">
        <label>Jumlah Jam</label>

        <input type="number"
               name="jumlah_jam"
               class="form-control"
               required>
    </div>

    <div class="form-group">
        <label>Tahun Ajaran</label>

        <select name="tahun"
                class="form-control">

            <?php foreach($tahun as $t): ?>

            <option value="<?= $t->id ?>"
                <?= $t->status == 'aktif'
                ? 'selected'
                : '' ?>>

                <?= $t->tahun ?>

            </option>

            <?php endforeach; ?>

        </select>
    </div>

    <button class="btn btn-primary">
        Simpan
    </button>

</form>