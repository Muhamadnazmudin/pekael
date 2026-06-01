<h1 class="h3 mb-4 text-gray-800">
    Distribusi Proporsional
</h1>

<div class="alert alert-info">

    <i class="fa fa-info-circle"></i>

    Mapping siswa dilakukan secara manual sesuai
    kuota pembimbing yang telah dihitung pada
    menu Pembimbing PKL Per Kelas.

</div>

<div class="card shadow">

    <div class="card-header">

        <strong>
            Daftar Pembimbing PKL
        </strong>

    </div>

    <div class="card-body">

        <div class="table-responsive">

            <table class="table table-bordered table-striped">

                <thead>

                    <tr>

                        <th width="60">No</th>

                        <th>Guru</th>

                        <th>NIP</th>

                        <th width="150">
                            Kuota
                        </th>

                        <th width="150">
                            Terpilih
                        </th>

                        <th width="150">
                            Aksi
                        </th>

                    </tr>

                </thead>

                <tbody>

                <?php if(empty($data)): ?>

                    <tr>

                        <td colspan="6"
                            class="text-center">

                            Belum ada data pembimbing.

                            Silakan generate terlebih dahulu
                            pada menu Pembimbing PKL Per Kelas.

                        </td>

                    </tr>

                <?php endif; ?>

                <?php
                $no = 1;

                foreach($data as $d):

                    $terpilih =
    $this->db
    ->where(
        'guru_id',
        $d->guru_id
    )
    ->count_all_results(
        'distribusi_pkl'
    );
                ?>

                <tr>

                    <td>
                        <?= $no++ ?>
                    </td>

                    <td>

                        <strong>
                            <?= $d->nama_guru ?>
                        </strong>

                    </td>

                    <td>
                        <?= $d->nip ?>
                    </td>

                    <td>

                        <span class="badge badge-primary">

                            <?= $d->kuota ?>

                            siswa

                        </span>

                    </td>

                    <td>

                        <span class="badge badge-success">

                            <?= $terpilih ?>

                            siswa

                        </span>

                    </td>

                    <td>

                        <a href="<?= base_url(
                            'distribusi_proporsional/mapping/'
                            .$d->guru_id
                        ) ?>"
                        class="btn btn-warning btn-sm">

                            <i class="fa fa-users"></i>

                            Mapping Siswa

                        </a>

                    </td>

                </tr>

                <?php endforeach; ?>

                </tbody>

            </table>

        </div>

    </div>

</div>