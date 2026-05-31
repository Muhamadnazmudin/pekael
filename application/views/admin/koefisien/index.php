<h1 class="h3 mb-4 text-gray-800">
    Koefisien PKL
</h1>

<div class="card shadow">

    <div class="card-body">

        <form method="post"
              action="<?= base_url('koefisien/hitung') ?>">

            <div class="row">

                <div class="col-md-3">
                    <label>
                        Jumlah JP
                    </label>

                    <input type="number"
                           name="jp"
                           class="form-control"
                           value="46">
                </div>

                <div class="col-md-3 mt-4">

                    <button class="btn btn-primary">

                        Hitung Koefisien

                    </button>

                </div>

            </div>

        </form>

        <hr>

        <table class="table table-bordered">

            <thead>
                <tr>
                    <th>Tahun</th>
                    <th>Jumlah Siswa PKL</th>
                    <th>Jumlah Rombel PKL</th>
                    <th>JP</th>
                    <th>Koefisien</th>
                </tr>
            </thead>

            <tbody>

            <?php foreach($koefisien as $k): ?>

            <tr>

                <td>
                    <?= $k->tahun ?>
                </td>

                <td>
                    <?= $k->jumlah_siswa ?>
                </td>

                <td>
                    <?= $k->jumlah_rombel ?>
                </td>

                <td>
                    <?= $k->jp ?>
                </td>

                <td>

                    <strong>

                        <?= $k->koefisien ?>

                    </strong>

                </td>

            </tr>

            <?php endforeach; ?>

            </tbody>

        </table>

    </div>

</div>