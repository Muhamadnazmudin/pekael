<style>
.search-box{
    max-width: 350px;
}

.search-box input{
    border-radius: 10px;
    border: 1px solid #d1d3e2;
    padding: 10px 15px;
}

.table td,
.table th{
    vertical-align: middle;
}
</style>


<div class="d-sm-flex align-items-center justify-content-between mb-4">

    <div>

        <h1 class="h3 text-gray-800 mb-1">
            Mapping DUDI
        </h1>

        <p class="text-muted mb-0">
            Kelola mapping siswa ke DUDI
        </p>

    </div>

    <!-- SEARCH -->
    <div class="search-box">

        <input type="text"
               id="searchDudi"
               class="form-control"

               placeholder="Cari nama DUDI...">

    </div>

</div>


<div class="card shadow-sm border-0">

    <div class="card-body p-0">

        <div class="table-responsive">

            <table class="table table-hover mb-0">

                <thead class="thead-light">

                    <tr>

                        <th width="60">
                            No
                        </th>

                        <th>
                            Nama DUDI
                        </th>

                        <th width="180">
                            Total Siswa
                        </th>

                        <th width="180">
                            Status
                        </th>

                        <th width="150"
                            class="text-center">

                            Aksi
                        </th>

                    </tr>

                </thead>

                <tbody id="tableBody">

                <?php
                $no = 1;

                foreach($dudi as $d):
                ?>

                    <tr class="dudi-row">

                        <td>
                            <?= $no++ ?>
                        </td>

                        <td class="nama-dudi">

                            <strong>
                                <?= $d->nama_dudi ?>
                            </strong>

                        </td>

                        <td>

                            <button
    class="badge badge-primary border-0 px-3 py-2"
    style="cursor:pointer"

    data-toggle="modal"

    data-target="#modalSiswa<?= $d->id ?>">

    <?= $d->total_siswa ?>
    siswa

</button>

                        </td>

                        <td>

                            <?php if(
                                $d->total_siswa > 0
                            ): ?>

                                <span class="badge badge-success">

                                    Siap Mapping

                                </span>

                            <?php else: ?>

                                <span class="badge badge-secondary">

                                    Belum Ada Siswa

                                </span>

                            <?php endif; ?>

                        </td>

                        <td class="text-center">

                            <a href="<?= base_url(
                                'mappingdudi/mapping/'
                                .$d->id
                            ) ?>"

                            class="btn btn-primary btn-sm">

                                <i class="fas fa-project-diagram"></i>

                                Mapping

                            </a>

                        </td>

                    </tr>

                <?php endforeach; ?>

                </tbody>

            </table>

        </div>

    </div>

</div>
<?php foreach($dudi as $d): ?>

<div class="modal fade"
     id="modalSiswa<?= $d->id ?>"
     tabindex="-1">

    <div class="modal-dialog modal-lg">

        <div class="modal-content">

            <div class="modal-header">

                <h5 class="modal-title">

                    Daftar Siswa

                    <br>

                    <small class="text-muted">

                        <?= $d->nama_dudi ?>

                    </small>

                </h5>

                <button
                    type="button"
                    class="close"
                    data-dismiss="modal">

                    <span>&times;</span>

                </button>

            </div>

            <div class="modal-body">

                <?php if(
                    !empty(
                        $d->list_siswa
                    )
                ): ?>

                <div class="table-responsive">

                    <table class="table table-hover">

                        <thead
                            class="bg-light">

                            <tr>

                                <th width="60">
                                    No
                                </th>

                                <th>
                                    Nama Siswa
                                </th>

                                <th width="220">
                                    Kelas
                                </th>

                            </tr>

                        </thead>

                        <tbody>

                        <?php
                        $noSiswa = 1;

                        foreach(
                            $d->list_siswa
                            as $s
                        ):
                        ?>

                            <tr>

                                <td>
                                    <?= $noSiswa++ ?>
                                </td>

                                <td>
                                    <?= $s->nama ?>
                                </td>

                                <td>
                                    <?= $s->nama_kelas ?>
                                </td>

                            </tr>

                        <?php endforeach; ?>

                        </tbody>

                    </table>

                </div>

                <?php else: ?>

                <div class="text-center py-4 text-muted">

                    Belum ada siswa
                    pada DUDI ini

                </div>

                <?php endif; ?>

            </div>

        </div>

    </div>

</div>

<?php endforeach; ?>

<script>
document.addEventListener(
    'DOMContentLoaded',
    function(){

        const search =
            document.getElementById(
                'searchDudi'
            );

        const rows =
            document.querySelectorAll(
                '.dudi-row'
            );

        search.addEventListener(
            'keyup',
            function(){

                let keyword =
                    this.value
                    .toLowerCase()
                    .trim();

                rows.forEach(
                    function(row){

                        let nama =
                            row.querySelector(
                                '.nama-dudi'
                            )
                            .innerText
                            .toLowerCase();

                        if(
                            nama.includes(
                                keyword
                            )
                        ){

                            row.style.display =
                                '';

                        } else {

                            row.style.display =
                                'none';
                        }

                    }
                );

            }
        );

    }
);
</script>