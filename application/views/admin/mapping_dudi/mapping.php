<h3 class="mb-4">

    Mapping DUDI:
    <strong>
        <?= $dudi->nama_dudi ?>
    </strong>

</h3>

<div class="card shadow">

    <div class="card-body">

        <!-- SEARCH -->
        <div class="row mb-3">

            <div class="col-md-6">

                <input
                type="text"
                id="searchSiswa"
                class="form-control"

                placeholder="Cari nama siswa / NISN / kelas...">

            </div>

        </div>

        <div class="table-responsive">

            <table
            class="table table-bordered table-hover"
            id="tableSiswa">

                <thead>

                    <tr>

                        <th width="50">
                            No
                        </th>

                        <th>
                            Nama
                        </th>

                        <th>
                            NISN
                        </th>

                        <th>
                            Kelas
                        </th>

                        <th>
                            Jurusan
                        </th>

                        <th>
                            DUDI Saat Ini
                        </th>

                        <th width="150">
                            Aksi
                        </th>

                    </tr>

                </thead>

                <tbody>

                <?php
                $no = 1;

                foreach(
                    $siswa
                    as $s
                ):
                ?>

                <tr>

                    <td>
                        <?= $no++ ?>
                    </td>

                    <td>
                        <?= $s->nama ?>
                    </td>

                    <td>
                        <?= $s->nisn ?>
                    </td>

                    <td>
                        <?= $s->nama_kelas ?>
                    </td>

                    <td>
                        <?= $s->nama_jurusan ?>
                    </td>

                    <td>

                        <?php if(
                            !empty(
                                $s->dudi_sekarang
                            )
                        ): ?>

                            <span
                            class="badge badge-warning">

                                <?= $s->dudi_sekarang ?>

                            </span>

                        <?php else: ?>

                            <span
                            class="badge badge-secondary">

                                Belum Ada

                            </span>

                        <?php endif; ?>

                    </td>

                    <td>

<?php if(
    empty(
        $s->dudi_sekarang
    )
): ?>

    <!-- BELUM PUNYA DUDI -->
    <a
    href="<?= base_url(
        'mappingdudi/pilih/'
        .$dudi->id
        .'/'
        .$s->id
    ) ?>"

    class="btn btn-sm btn-primary"

    onclick="
    return confirm(
    'Masukkan siswa ke DUDI ini?'
    )">

        Masukkan

    </a>

<?php else: ?>

    <!-- SUDAH PUNYA DUDI -->
    <button
    class="btn btn-sm btn-warning"

    data-toggle="modal"

    data-target="#modalPindah<?= $s->id ?>">

        Pindahkan

    </button>

    <!-- MODAL -->
    <div
    class="modal fade"

    id="modalPindah<?= $s->id ?>">

        <div class="modal-dialog">

            <div class="modal-content">

                <form
                method="post"

                action="<?= base_url(
                    'mappingdudi/pindahkan'
                ) ?>">

                    <div class="modal-header">

                        <h5>

                            Pindahkan DUDI

                        </h5>

                    </div>

                    <div class="modal-body">

                        <input
                        type="hidden"

                        name="siswa_id"

                        value="<?= $s->id ?>">

                        <div class="form-group">

                            <label>

                                Pilih DUDI Baru

                            </label>

                            <select
                            name="dudi_id"
                            class="form-control"
                            required>

                                <option value="">

                                    -- Pilih DUDI --

                                </option>

                                <?php foreach(
                                    $all_dudi
                                    as $d
                                ): ?>

                                <option
                                value="<?= $d->id ?>">

                                    <?= $d->nama_dudi ?>

                                    -
                                    <?= $d->nomor_mou ?>

                                </option>

                                <?php endforeach; ?>

                            </select>

                        </div>

                    </div>

                    <div class="modal-footer">

                        <button
                        class="btn btn-primary">

                            Simpan

                        </button>

                    </div>

                </form>

            </div>

        </div>

    </div>

<?php endif; ?>

</td>

                </tr>

                <?php endforeach; ?>

                </tbody>

            </table>

        </div>

        <a
        href="<?= base_url(
            'mappingdudi'
        ) ?>"
        class="btn btn-secondary mt-3">

            Kembali

        </a>

    </div>

</div>

<script>

document
.getElementById(
'searchSiswa'
)
.addEventListener(
'keyup',

function(){

    let value =
        this.value
        .toLowerCase();

    let rows =
        document
        .querySelectorAll(
            '#tableSiswa tbody tr'
        );

    rows.forEach(function(row){

        let text =
            row.innerText
            .toLowerCase();

        row.style.display =
            text.includes(value)
            ?
            ''
            :
            'none';
    });
});

</script>