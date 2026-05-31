<div class="d-sm-flex align-items-center justify-content-between mb-4">

    <div>
        <h1 class="h3 text-gray-800 mb-1">
            Data DUDI
        </h1>

        <p class="text-muted mb-0">
            Data Dunia Usaha & Dunia Industri
        </p>
    </div>

    <div>

        <a href="<?= base_url('importdudi/template') ?>"
           class="btn btn-success shadow-sm">

            <i class="fas fa-download fa-sm"></i>
            Template
        </a>

        <button class="btn btn-info shadow-sm"
                data-toggle="modal"
                data-target="#modalImport">

            <i class="fas fa-file-excel fa-sm"></i>
            Import
        </button>

        <a href="<?= base_url('dudi/tambah') ?>"
           class="btn btn-primary shadow-sm">

            <i class="fas fa-plus fa-sm"></i>
            Tambah DUDI
        </a>

    </div>

</div>


<!-- TABLE -->
<div class="card shadow-sm border-0">

    <div class="card-body p-0">

        <div class="table-responsive">

            <table class="table table-hover mb-0"
                   id="tableDudi">

                <thead class="thead-light">

                    <tr>

                        <th width="50">
                            No
                        </th>

                        <th>
                            Nama DUDI
                        </th>

                        <th>
                            Bidang
                        </th>

                        <th>
                            Lokasi
                        </th>

                        <th>
                            PIC
                        </th>

                        <th width="120">
                            Status
                        </th>

                        <th width="130"
                            class="text-center">

                            Aksi
                        </th>

                    </tr>

                </thead>

                <tbody>

                <?php
                $no = 1;

                foreach($dudi as $d):
                ?>

                    <tr>

                        <td>
                            <?= $no++ ?>
                        </td>

                        <td>

                            <strong>
                                <?= $d->nama_dudi ?>
                            </strong>

                            <br>

                            <small class="text-muted">
                                <?= $d->alamat ?>
                            </small>

                        </td>

                        <td>
                            <?= $d->bidang_usaha ?>
                        </td>

                        <td>

                            <?= $d->kabupaten_kota ?>

                            <br>

                            <small class="text-muted">
                                <?= $d->provinsi ?>
                            </small>

                        </td>

                        <td>

                            <strong>
                                <?= $d->nama_pic ?>
                            </strong>

                            <br>

                            <small class="text-muted">
                                <?= $d->no_hp_pic ?>
                            </small>

                        </td>

                        <td>

                            <?php if(
                                $d->status_kerjasama
                                == 'aktif'
                            ): ?>

                                <span class="badge badge-success px-3 py-2">

                                    Aktif

                                </span>

                            <?php else: ?>

                                <span class="badge badge-secondary px-3 py-2">

                                    Nonaktif

                                </span>

                            <?php endif; ?>

                        </td>

                        <td class="text-center">

                            <a href="<?= base_url(
                                'dudi/edit/'.$d->id
                            ) ?>"

                            class="btn btn-warning btn-sm"
                            title="Edit">

                                <i class="fas fa-edit"></i>

                            </a>

                            <a href="<?= base_url(
                                'dudi/hapus/'.$d->id
                            ) ?>"

                            class="btn btn-danger btn-sm"
                            title="Hapus"

                            onclick="return confirm(
                                'Hapus data ini?'
                            )">

                                <i class="fas fa-trash"></i>

                            </a>

                        </td>

                    </tr>

                <?php endforeach; ?>

                </tbody>

            </table>

        </div>

    </div>

</div>


<!-- MODAL IMPORT -->
<div class="modal fade"
     id="modalImport">

    <div class="modal-dialog">

        <div class="modal-content">

            <form method="post"
                  enctype="multipart/form-data"

                  action="<?= base_url(
                      'importdudi/proses'
                  ) ?>">

                <div class="modal-header">

                    <h5 class="modal-title">
                        Import Data DUDI
                    </h5>

                    <button type="button"
                            class="close"
                            data-dismiss="modal">

                        &times;
                    </button>

                </div>

                <div class="modal-body">

                    <div class="alert alert-light border">

                        <strong>
                            Format:
                        </strong>

                        File Excel
                        (.xlsx / .xls)

                    </div>

                    <input type="file"
                           name="file"
                           class="form-control"
                           accept=".xlsx,.xls"
                           required>

                </div>

                <div class="modal-footer">

                    <button type="button"
                            class="btn btn-secondary"
                            data-dismiss="modal">

                        Batal
                    </button>

                    <button type="submit"
                            class="btn btn-primary">

                        <i class="fas fa-upload"></i>
                        Import
                    </button>

                </div>

            </form>

        </div>

    </div>

</div>


<script>
$(document).ready(function () {

    $('#tableDudi').DataTable({

        responsive: true,
        pageLength: 10,
        ordering: true,
        autoWidth: false,
        language: {
            search: "Cari:",
            lengthMenu: "Tampilkan _MENU_ data",
            info: "Menampilkan _START_ - _END_ dari _TOTAL_ data",
            paginate: {
                previous: "‹",
                next: "›"
            }
        }

    });

});
</script>