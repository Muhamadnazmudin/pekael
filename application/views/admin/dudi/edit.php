<h3 class="mb-4">

    Edit DUDI

</h3>

<form method="post">

    <div class="form-group">

        <label>

            Nama DUDI

        </label>

        <input
        type="text"
        name="nama_dudi"
        class="form-control"
        required
        value="<?= $dudi->nama_dudi ?>">

    </div>

    <div class="form-group">

        <label>

            Bidang Usaha

        </label>

        <input
        type="text"
        name="bidang_usaha"
        class="form-control"
        value="<?= $dudi->bidang_usaha ?>">

    </div>

    <div class="form-group">

        <label>

            Alamat

        </label>

        <textarea
        name="alamat"
        class="form-control"
        rows="3"><?= $dudi->alamat ?></textarea>

    </div>

    <div class="row">

        <div class="col-md-6">

            <div class="form-group">

                <label>
                    Desa/Kelurahan
                </label>

                <input
                type="text"
                name="desa"
                class="form-control"
                value="<?= $dudi->desa_kelurahan ?>">

            </div>

        </div>

        <div class="col-md-6">

            <div class="form-group">

                <label>
                    Kecamatan
                </label>

                <input
                type="text"
                name="kecamatan"
                class="form-control"
                value="<?= $dudi->kecamatan ?>">

            </div>

        </div>

    </div>

    <div class="row">

        <div class="col-md-6">

            <div class="form-group">

                <label>
                    Kabupaten/Kota
                </label>

                <input
                type="text"
                name="kabupaten"
                class="form-control"
                value="<?= $dudi->kabupaten_kota ?>">

            </div>

        </div>

        <div class="col-md-6">

            <div class="form-group">

                <label>
                    Provinsi
                </label>

                <input
                type="text"
                name="provinsi"
                class="form-control"
                value="<?= $dudi->provinsi ?>">

            </div>

        </div>

    </div>

    <hr>

    <h5>Data PKS / MoU</h5>

    <div class="form-group">

        <label>

            Nomor MoU

        </label>

        <input
        type="text"
        name="nomor_mou"
        class="form-control"
        value="<?= $dudi->nomor_mou ?>">

    </div>

    <div class="form-group">

        <label>

            Judul PKS

        </label>

        <textarea
        name="judul_pks"
        class="form-control"
        rows="2"><?= $dudi->judul_pks ?></textarea>

    </div>

    <hr>

    <h5>PIC DUDI</h5>

    <div class="row">

        <div class="col-md-6">

            <div class="form-group">

                <label>

                    Nama PIC

                </label>

                <input
                type="text"
                name="nama_pic"
                class="form-control"
                value="<?= $dudi->nama_pic ?>">

            </div>

        </div>

        <div class="col-md-6">

            <div class="form-group">

                <label>

                    No HP PIC

                </label>

                <input
                type="text"
                name="no_hp_pic"
                class="form-control"
                value="<?= $dudi->no_hp_pic ?>">

            </div>

        </div>

    </div>

    <div class="form-group">

        <label>

            Status Kerjasama

        </label>

        <select
        name="status"
        class="form-control">

            <option
            value="aktif"
            <?= $dudi->status_kerjasama=='aktif'
            ? 'selected'
            : '' ?>>

                Aktif

            </option>

            <option
            value="nonaktif"
            <?= $dudi->status_kerjasama=='nonaktif'
            ? 'selected'
            : '' ?>>

                Nonaktif

            </option>

        </select>

    </div>

    <button
    class="btn btn-primary">

        Update

    </button>

    <a href="<?= base_url('dudi') ?>"
    class="btn btn-secondary">

        Kembali

    </a>

</form>