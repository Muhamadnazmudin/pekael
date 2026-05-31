<h1 class="h3 mb-4 text-gray-800">
    Edit Guru
</h1>

<div class="card shadow">

    <div class="card-body">

        <form method="post">

            <div class="form-group">
                <label>NIP</label>

                <input type="text"
                       name="nip"
                       class="form-control"
                       value="<?= $guru->nip ?>">
            </div>

            <div class="form-group">
                <label>Nama Guru</label>

                <input type="text"
                       name="nama_guru"
                       class="form-control"
                       value="<?= $guru->nama_guru ?>"
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

                    <option value="<?= $j->id ?>"
                        <?= ($guru->jurusan_id == $j->id)
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
                <label>Jenis Guru</label>

                <select name="jenis_guru"
                        class="form-control"
                        required>

                    <option value="produktif"
                        <?= $guru->jenis_guru == 'produktif'
                        ? 'selected' : '' ?>>

                        Produktif
                    </option>

                    <option value="normatif"
                        <?= $guru->jenis_guru == 'normatif'
                        ? 'selected' : '' ?>>

                        Normatif
                    </option>

                    <option value="adaptif"
                        <?= $guru->jenis_guru == 'adaptif'
                        ? 'selected' : '' ?>>

                        Adaptif
                    </option>

                </select>
            </div>

            <div class="form-group">
                <label>Status</label>

                <select name="status"
                        class="form-control">

                    <option value="aktif"
                        <?= $guru->status == 'aktif'
                        ? 'selected' : '' ?>>

                        Aktif
                    </option>

                    <option value="nonaktif"
                        <?= $guru->status == 'nonaktif'
                        ? 'selected' : '' ?>>

                        Nonaktif
                    </option>

                </select>
            </div>

            <button class="btn btn-primary">
                Update
            </button>

            <a href="<?= base_url('guru') ?>"
               class="btn btn-secondary">

                Kembali
            </a>

        </form>

    </div>

</div>