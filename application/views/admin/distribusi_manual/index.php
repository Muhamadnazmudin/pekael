
<h1 class="h3 mb-4 text-gray-800">
    Distribusi Manual
</h1>

<div class="alert alert-info">
    <i class="fa fa-info-circle"></i>
    Mapping siswa dilakukan secara manual berdasarkan
    kuota pembimbing yang telah digenerate pada menu
    Pembimbing (Koef).
</div>

<div class="card shadow">

    <div class="card-header">
        <strong>Daftar Pembimbing PKL</strong>
    </div>

    <div class="card-body">

        <div class="table-responsive">

            <table class="table table-bordered table-striped">

                <thead class="thead-light">

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

                        <th width="180">
                            Aksi
                        </th>

                    </tr>

                </thead>

                <tbody>

                <?php if(empty($pembimbing)): ?>

                    <tr>

                        <td colspan="6"
                            class="text-center">

                            Belum ada data pembimbing.

                        </td>

                    </tr>

                <?php else: ?>

                    <?php
                    $no = 1;

                    foreach($pembimbing as $p):

                        $terpilih = $this->db
                            ->where(
                                'guru_id',
                                $p->guru_id
                            )
                            ->count_all_results(
                                'distribusi_manual'
                            );

                        $kelas = $this->db
                            ->select('kelas.nama_kelas')
                            ->from('pembimbing_pkl')
                            ->join(
                                'kelas',
                                'kelas.id = pembimbing_pkl.kelas_id'
                            )
                            ->where(
                                'pembimbing_pkl.guru_id',
                                $p->guru_id
                            )
                            ->get()
                            ->result();

                        $list_kelas = [];

                        foreach($kelas as $k){

                            $list_kelas[] =
                                $k->nama_kelas;
                        }
                    ?>

                    <tr>

                        <td>
                            <?= $no++ ?>
                        </td>

                        <td>

                            <strong>
                                <?= $p->nama_guru ?>
                            </strong>

                            <br>

                            <small class="text-muted">

                                <?= implode(
                                    ', ',
                                    $list_kelas
                                ) ?>

                            </small>

                        </td>

                        <td>
                            <?= $p->nip ?>
                        </td>

                        <td>

                            <span class="badge badge-primary">

                                <?= $p->kuota ?>

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
                                'distribusimanual/mapping/' .
                                $p->guru_id
                            ) ?>"
                            class="btn btn-warning btn-sm">

                                <i class="fa fa-users"></i>

                                Mapping Siswa

                            </a>

                        </td>

                    </tr>

                    <?php endforeach; ?>

                <?php endif; ?>

                </tbody>

            </table>

        </div>

    </div>

</div>

