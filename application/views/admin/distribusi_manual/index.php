<h1 class="h3 mb-4 text-gray-800">
    Distribusi Manual
</h1>

<div class="card shadow-sm border-0">

    <div class="card-header bg-white">

        <h5 class="mb-0">
            Data Pembimbing PKL
        </h5>

    </div>

    <div class="card-body p-3">

        <div class="accordion"
             id="accordionGuru">

        <?php foreach($guru as $g): ?>

        <?php

        // ambil mapping guru
        $mapping = $this->db
            ->select('
                distribusi_manual.*,

                siswa.nama,
                siswa.nisn,

                kelas.nama_kelas,

                dudi.nama_dudi
            ')
            ->from(
                'distribusi_manual'
            )

            ->join(
                'siswa',
                'siswa.id =
                distribusi_manual.siswa_id'
            )

            ->join(
                'kelas',
                'kelas.id =
                distribusi_manual.kelas_id'
            )

            ->join(
                'dudi',
                'dudi.id =
                siswa.dudi_id',
                'left'
            )

            ->where(
                'guru_id',
                $g->id
            )

            ->order_by(
                'kelas.nama_kelas',
                'ASC'
            )

            ->get()
            ->result();

        // group per kelas
        $kelas_group = [];

        foreach(
            $mapping
            as $m
        ){

            $kelas_group[
                $m->nama_kelas
            ][] = $m;
        }

        $total_siswa =
            count($mapping);

        $jumlah_kelas =
            count(
                $kelas_group
            );

        ?>

        <div class="card shadow-sm mb-3 border-0">

            <div class="card-header bg-light">

                <div class="d-flex justify-content-between align-items-center">

                    <button
                        class="btn btn-link text-left p-0"

                        type="button"

                        data-toggle="collapse"

                        data-target="#guru<?= $g->id ?>">

                        <h5 class="mb-1">

                            <?= $g->nama_guru ?>

                        </h5>

                        <small class="text-muted">

                            <?= $total_siswa ?>

                            siswa •

                            <?= $jumlah_kelas ?>

                            kelas

                        </small>

                    </button>

                    <a href="<?= base_url(
                        'distribusimanual/mapping/'
                        .$g->id
                    ) ?>"

                    class="btn btn-warning btn-sm">

                        <i class="fas fa-edit"></i>

                        Kelola Mapping

                    </a>

                </div>

            </div>

            <div id="guru<?= $g->id ?>"
                 class="collapse"
                 data-parent="#accordionGuru">

                <div class="card-body">

                <?php if(!empty($kelas_group)): ?>

                    <div class="accordion"
                         id="accordionKelas<?= $g->id ?>">

                    <?php
                    $no_kelas = 1;

                    foreach(
                        $kelas_group
                        as $kelas
                        => $rows
                    ):
                    ?>

                    <div class="card border mb-2">

                        <div class="card-header bg-white p-2">

                            <button
                                class="btn btn-link text-left p-0"

                                type="button"

                                data-toggle="collapse"

                                data-target="#kelas<?= $g->id ?><?= $no_kelas ?>">

                                <strong>

                                    <?= $kelas ?>

                                </strong>

                                <span class="badge badge-primary ml-2">

                                    <?= count($rows) ?>

                                    siswa

                                </span>

                            </button>

                        </div>

                        <div id="kelas<?= $g->id ?><?= $no_kelas ?>"
                             class="collapse"
                             data-parent="#accordionKelas<?= $g->id ?>">

                            <div class="table-responsive">

                                <table class="table table-sm table-bordered mb-0">

                                    <thead class="thead-light">

                                        <tr>

                                            <th width="50">
                                                No
                                            </th>

                                            <th>
                                                Nama Siswa
                                            </th>

                                            <th>
                                                DUDI
                                            </th>

                                            <th>
                                                NISN
                                            </th>

                                        </tr>

                                    </thead>

                                    <tbody>

                                    <?php
                                    $no = 1;

                                    foreach(
                                        $rows
                                        as $r
                                    ):
                                    ?>

                                    <tr>

                                        <td>
                                            <?= $no++ ?>
                                        </td>

                                        <td>
                                            <?= $r->nama ?>
                                        </td>

                                        <td>

                                            <?= !empty(
                                                $r->nama_dudi
                                            )

                                            ?

                                            $r->nama_dudi

                                            :

                                            '<span class="text-danger">
                                            Belum Mapping
                                            </span>' ?>

                                        </td>

                                        <td>
                                            <?= $r->nisn ?>
                                        </td>

                                    </tr>

                                    <?php endforeach; ?>

                                    </tbody>

                                </table>

                            </div>

                        </div>

                    </div>

                    <?php
                    $no_kelas++;
                    endforeach;
                    ?>

                    </div>

                <?php else: ?>

                    <div class="alert alert-warning mb-0">

                        Belum ada mapping siswa

                    </div>

                <?php endif; ?>

                </div>

            </div>

        </div>

        <?php endforeach; ?>

        </div>

    </div>

</div>