<?php if(
    $this->session
    ->flashdata(
        'success'
    )
): ?>

<div class="alert alert-success alert-dismissible fade show">

    <i class="fas fa-check-circle"></i>

    <?= $this->session
        ->flashdata(
            'success'
        ) ?>

    <button type="button"
            class="close"
            data-dismiss="alert">

        <span>
            &times;
        </span>

    </button>

</div>

<?php endif; ?>


<?php if(
    $this->session
    ->flashdata(
        'error'
    )
): ?>

<div class="alert alert-danger alert-dismissible fade show">

    <i class="fas fa-exclamation-circle"></i>

    <?= $this->session
        ->flashdata(
            'error'
        ) ?>

    <button type="button"
            class="close"
            data-dismiss="alert">

        <span>
            &times;
        </span>

    </button>

</div>

<?php endif; ?>

<h1 class="h3 mb-4 text-gray-800">
    Pembimbing PKL Per Kelas (metode kedua)
</h1>

<div class="card shadow-sm border-0 mb-4">

    <div class="card-body">

        <div class="d-flex justify-content-between align-items-center mb-3">

            <h5 class="mb-0">
                Generate Pembimbing
            </h5>

            <a href="#"
   class="btn btn-secondary disabled">
    <i class="fas fa-sync"></i>
    Generate Semua Kelas
</a>

        </div>

        <div class="table-responsive">

            <table class="table table-bordered mb-0">

                <thead class="thead-light">

                    <tr>

                        <th width="60">
                            No
                        </th>

                        <th>
                            Nama Kelas
                        </th>

                        <th width="180">
                            Total Siswa
                        </th>

                        <th width="180">
                            Aksi
                        </th>

                    </tr>

                </thead>

                <tbody>

                <?php
                $no = 1;

                foreach(
                    $kelas
                    as $k
                ):
                ?>

                <tr>

                    <td>
                        <?= $no++ ?>
                    </td>

                    <td>

                        <strong>

                            <?= $k->nama_kelas ?>

                        </strong>

                    </td>

                    <td>

                        <?=
                        $this->db
                       ->where(
    'id_kelas',
    $k->id
)
                        ->count_all_results(
                            'siswa'
                        );
                        ?>

                        siswa

                    </td>

                    <td>

                        <form method="post"
                              action="<?= base_url('pembimbingkelas/generate') ?>">

                            <input type="hidden"
                                   name="kelas_id"
                                   value="<?= $k->id ?>">

                            <button type="submit"
                                    class="btn btn-primary btn-sm">

                                <i class="fas fa-sync-alt"></i>

                                Generate

                            </button>

                        </form>

                    </td>

                </tr>

                <?php endforeach; ?>

                </tbody>

            </table>

        </div>

    </div>

</div>


<?php
$group = [];

foreach($pembimbing as $p){

    $group[
        $p->nama_kelas
    ][] = $p;
}
?>


<div class="accordion"
     id="accordionPembimbing">

<?php
$no_group = 1;

foreach(
    $group
    as $kelas => $rows
):
?>

<div class="card shadow-sm border-0 mb-3">

    <div class="card-header p-0 bg-white">

        <button class="btn btn-light
                       btn-block
                       text-left
                       p-3
                       font-weight-bold"

                type="button"

                data-toggle="collapse"

                data-target="#collapse<?= $no_group ?>">

            <i class="fas fa-chevron-down mr-2"></i>

            <?= $kelas ?>

            <span class="badge badge-success ml-2">

                <?= array_sum(
                    array_column(
                        $rows,
                        'jumlah_bimbingan'
                    )
                ) ?>

                siswa

            </span>

        </button>

    </div>

    <div id="collapse<?= $no_group ?>"
         class="collapse"
         data-parent="#accordionPembimbing">

        <div class="table-responsive">

            <table class="table table-bordered mb-0">

                <thead class="thead-light">

                    <tr>

                        <th>No</th>
                        <th>Guru</th>
                        <th>NIP</th>
                        <th>Total Jam</th>
                        <th>Jam PKL</th>
                        <th>Jumlah Siswa</th>
                        <th>Tahun</th>

                    </tr>

                </thead>

                <tbody>

                <?php
                $no = 1;

                foreach(
                    $rows
                    as $p
                ):
                ?>

                <tr>

                    <td>
                        <?= $no++ ?>
                    </td>

                    <td>
                        <?= $p->nama_guru ?>
                    </td>

                    <td>
                        <?= $p->nip ?>
                    </td>

                    <td>
                        <?= $p->total_jam ?>
                    </td>

                    <td>
                        <?= $p->koefisien ?>
                    </td>

                    <td>

                        <span class="badge badge-primary">

                            <?= $p->jumlah_bimbingan ?>

                        </span>

                    </td>

                    <td>
                        <?= $p->tahun ?>
                    </td>

                </tr>

                <?php endforeach; ?>

                </tbody>

            </table>

        </div>

    </div>

</div>

<?php
$no_group++;
endforeach;
?>

</div>