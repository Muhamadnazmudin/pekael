<h3>Tambah Kelas</h3>

<form method="post">

    <div class="form-group">
        <label>Nama Kelas</label>
        <input type="text" name="nama_kelas" class="form-control" placeholder="XII RPL 1" required>
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

        <option value="<?= $j->id ?>">

            <?= $j->singkatan ?>
            -
            <?= $j->nama_jurusan ?>

        </option>

        <?php endforeach; ?>

    </select>
</div>

    <div class="form-group">
        <label>Tingkat</label>
        <select name="tingkat" class="form-control" required>
            <option value="">-- Pilih --</option>
            <option value="X">X</option>
            <option value="XI">XI</option>
            <option value="XII">XII</option>
        </select>
    </div>
<div class="form-group">
    <label>Status PKL</label>

    <select name="status_pkl"
            class="form-control"
            required>

        <option value="tidak">
            Tidak
        </option>

        <option value="ya">
            Ya
        </option>

    </select>
</div>
    <button class="btn btn-primary">Simpan</button>

</form>