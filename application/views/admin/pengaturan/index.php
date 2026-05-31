<!-- <h3>Pengaturan Sistem</h3>

<form method="post"
      action="<?= base_url('pengaturan/update') ?>">

<div class="card shadow">

    <div class="card-body p-0">

        <table class="table table-bordered mb-0">

            <thead class="thead-light">

                <tr class="text-center">

                    <th width="50">
                        No
                    </th>

                    <th width="250">
                        Nama Pengaturan
                    </th>

                    <th>
                        Isi
                    </th>

                </tr>

            </thead>

            <tbody>

            <?php
            $no = 1;

            foreach($pengaturan as $p):
            ?>

                <tr>

                    <td class="text-center">
                        <?= $no++ ?>
                    </td>

                    <td>

                        <?= ucwords(
                            str_replace(
                                '_',
                                ' ',
                                $p->nama_pengaturan
                            )
                        ) ?>

                    </td>

                    <td>

                        <?php if(
                            $p->nama_pengaturan
                            == 'tanggal_pengumuman'
                        ): ?>

                            <input
                                type="datetime-local"
                                name="<?= $p->nama_pengaturan ?>"
                                class="form-control"
                                value="<?= date(
                                    'Y-m-d\TH:i',
                                    strtotime(
                                        $p->value
                                    )
                                ) ?>">

                        <?php elseif(
                            $p->nama_pengaturan
                            == 'status_pengumuman'
                        ): ?>

                            <select
                                name="<?= $p->nama_pengaturan ?>"
                                class="form-control">

                                <option
                                    value="buka"
                                    <?= $p->value == 'buka'
                                        ? 'selected'
                                        : '' ?>>

                                    Buka

                                </option>

                                <option
                                    value="tutup"
                                    <?= $p->value == 'tutup'
                                        ? 'selected'
                                        : '' ?>>

                                    Tutup

                                </option>

                            </select>

                        <?php elseif(
                            $p->nama_pengaturan
                            == 'tema_aplikasi'
                        ): ?>

                            <select
                                name="<?= $p->nama_pengaturan ?>"
                                class="form-control">

                                <option
                                    value="light"
                                    <?= $p->value == 'light'
                                        ? 'selected'
                                        : '' ?>>

                                    Tema Terang

                                </option>

                                <option
                                    value="dark"
                                    <?= $p->value == 'dark'
                                        ? 'selected'
                                        : '' ?>>

                                    Tema Gelap

                                </option>

                            </select>

                        <?php elseif(
                            $p->nama_pengaturan
                            == 'sambutan_kepsek'
                        ): ?>

                            <textarea
                                name="<?= $p->nama_pengaturan ?>"
                                class="form-control"
                                rows="4"><?= $p->value ?></textarea>

                        <?php else: ?>

                            <input
                                type="text"
                                name="<?= $p->nama_pengaturan ?>"
                                class="form-control"
                                value="<?= $p->value ?>">

                        <?php endif; ?>

                    </td>

                </tr>

            <?php endforeach; ?>

            </tbody>

        </table>

    </div>

</div>

<div class="mt-3">

    <button
        type="submit"
        class="btn btn-primary">

        Simpan Perubahan

    </button>

</div>

</form> -->

<h3 class="mb-4">Pengaturan Sistem</h3>

<form method="post"
      action="<?= base_url('pengaturan/update') ?>">

<?php foreach($pengaturan as $p): ?>

    <?php if($p->nama_pengaturan == 'tema_aplikasi'): ?>

        <div class="card shadow">

            <div class="card-body">

                <div class="form-group mb-0">

                    <label class="font-weight-bold">
                        Tema Aplikasi
                    </label>

                    <select
                        name="<?= $p->nama_pengaturan ?>"
                        class="form-control">

                        <option
                            value="light"
                            <?= $p->value == 'light'
                                ? 'selected'
                                : '' ?>>

                            Tema Terang

                        </option>

                        <option
                            value="dark"
                            <?= $p->value == 'dark'
                                ? 'selected'
                                : '' ?>>

                            Tema Gelap

                        </option>

                    </select>

                    <small class="text-muted">
                        Pilih tema tampilan aplikasi.
                    </small>

                </div>

            </div>

        </div>

    <?php endif; ?>

<?php endforeach; ?>

<div class="mt-3">

    <button
        type="submit"
        class="btn btn-primary">

        <i class="fas fa-save"></i>
        Simpan Perubahan

    </button>

</div>

</form>