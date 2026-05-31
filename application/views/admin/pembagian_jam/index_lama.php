<div class="d-flex justify-content-between mb-3">

    <a href="<?= base_url(
        'pembagianjam/tambah'
    ) ?>"
    class="btn btn-primary">

        <i class="fas fa-plus"></i>

        Tambah Pembagian Jam

    </a>

</div>
<?php if(
    $this->session
    ->flashdata('success')
): ?>

<div class="alert alert-success alert-dismissible fade show">

    <?= $this->session
    ->flashdata('success') ?>

    <button
        type="button"
        class="close"
        data-dismiss="alert">

        <span>&times;</span>

    </button>

</div>

<?php endif; ?>


<style>
.card-header button{
    border-radius:0;
}

.form-inline-row{
    background:#f8f9fc;
}

.form-inline-row td{
    vertical-align: middle;
}
</style>


<h1 class="h3 mb-4 text-gray-800">
    Pembagian Jam
</h1>


<?php

$group = [];

foreach($jam as $j){

    $group[
        $j->nama_kelas
    ][] = $j;
}

$jp_wajib =
    !empty($jam)
    ? $jam[0]->jp
    : 46;

?>


<div class="accordion"
     id="accordionJam">

<?php
$no_group = 1;

foreach(
    $group
    as $kelas => $rows
):

$total_jam =
    array_sum(
        array_column(
            $rows,
            'jumlah_jam'
        )
    );

$valid =
    $total_jam ==
    $jp_wajib;

$kelas_id =
    $rows[0]->kelas_id;
?>

<div class="card shadow-sm border-0 mb-3">

    <div class="card-header bg-white p-0">

        <button
            class="btn btn-light
                   btn-block
                   text-left
                   p-3
                   font-weight-bold"

            type="button"

            data-toggle="collapse"

            data-target="#collapse<?= $no_group ?>">

            <i class="fas fa-school mr-2"></i>

            <?= $kelas ?>

            <span class="badge badge-primary ml-2">

                <?= $total_jam ?>

                JP

            </span>

            <?php if($valid): ?>

                <span class="badge badge-success ml-2">

                    Valid

                </span>

            <?php else: ?>

                <span class="badge badge-danger ml-2">

                    <?= $total_jam ?>
                    /
                    <?= $jp_wajib ?>

                    JP

                </span>

            <?php endif; ?>

        </button>

    </div>


    <div id="collapse<?= $no_group ?>"
         class="collapse"
         data-parent="#accordionJam">

        <div class="table-responsive">

            <table class="table table-bordered mb-0">

                <thead class="thead-light">

                    <tr>

                        <th width="60">
                            No
                        </th>

                        <th>
                            Guru
                        </th>

                        <th>
                            Jurusan
                        </th>

                        <th width="120">
                            Jam
                        </th>

                        <th>
                            Tahun
                        </th>

                        <th width="140">
                            Aksi
                        </th>

                    </tr>

                </thead>

                <tbody>

                <?php
                $no = 1;

                foreach(
                    $rows
                    as $j
                ):
                ?>

                <tr>

                    <td>
                        <?= $no++ ?>
                    </td>

                    <td>
                        <?= $j->nama_guru ?>
                    </td>

                    <td>
                        <?= $j->singkatan ?>
                    </td>

                    <td>

                        <span class="badge badge-info">

                            <?= $j->jumlah_jam ?>

                            JP

                        </span>

                    </td>

                    <td>
                        <?= $j->tahun ?>
                    </td>

                    <td>

                        <a href="<?= base_url(
                            'pembagianjam/hapus/'
                            .$j->id
                        ) ?>"

                        class="btn btn-danger btn-sm"

                        onclick="return confirm('Hapus data?')">

                            Hapus

                        </a>

                    </td>

                </tr>

                <?php endforeach; ?>


                <!-- FORM INLINE -->
                <tr
                    id="form<?= $kelas_id ?>"
                    class="form-inline-row"
                    style="display:none;">

                    <td>
                        +
                    </td>

                    <td>

                        <select
                            class="form-control guru_id">

                            <option value="">
                                -- pilih guru --
                            </option>

                            <?php foreach(
                                $guru
                                as $g
                            ): ?>

                            <option
                                value="<?= $g->id ?>">

                                <?= $g->nama_guru ?>

                            </option>

                            <?php endforeach; ?>

                        </select>

                    </td>

                    <td>
                        <?= $rows[0]->singkatan ?>
                    </td>

                    <td>

                        <input
                            type="number"

                            class="form-control jumlah_jam"

                            min="1"

                            placeholder="JP">

                    </td>

                    <td>
                        <?= $rows[0]->tahun ?>
                    </td>

                    <td>

                        <button
                            type="button"

                            class="btn btn-success btn-sm btnSimpanJam"

                            data-kelas="<?= $kelas_id ?>">

                            Simpan

                        </button>

                    </td>

                </tr>

                </tbody>

            </table>

        </div>


        <div class="card-footer bg-light text-right">

            <button
                type="button"

                class="btn btn-primary btn-sm btnTambahGuru"

                data-target="#form<?= $kelas_id ?>">

                <i class="fas fa-plus"></i>

                Tambah Guru ke
                <?= $kelas ?>

            </button>

        </div>

    </div>

</div>

<?php
$no_group++;
endforeach;
?>

</div>



<script>
document.addEventListener(
    'DOMContentLoaded',
    function(){

        // tombol tambah guru
        document
        .querySelectorAll(
            '.btnTambahGuru'
        )
        .forEach(function(btn){

            btn.addEventListener(
                'click',
                function(){

                    const target =
                        this.dataset
                        .target;

                    const row =
                        document
                        .querySelector(
                            target
                        );

                    if(
                        row.style.display
                        === 'none'
                    ){

                        row.style.display =
                            'table-row';

                    }else{

                        row.style.display =
                            'none';
                    }
                }
            );

        });


        // tombol simpan
        document
        .querySelectorAll(
            '.btnSimpanJam'
        )
        .forEach(function(btn){

            btn.addEventListener(
                'click',
                function(){

                    const row =
                        this.closest(
                            'tr'
                        );

                    const kelas_id =
                        this.dataset
                        .kelas;

                    const guru_id =
                        row
                        .querySelector(
                            '.guru_id'
                        )
                        .value;

                    const jumlah_jam =
                        row
                        .querySelector(
                            '.jumlah_jam'
                        )
                        .value;


                    if(!guru_id){

                        alert(
                            'Pilih guru dulu'
                        );

                        return;
                    }

                    if(
                        !jumlah_jam
                        ||
                        jumlah_jam <= 0
                    ){

                        alert(
                            'Isi jumlah jam'
                        );

                        return;
                    }


                    this.disabled =
                        true;

                    this.innerHTML =
                        'Menyimpan...';


                    fetch(
                        "<?= base_url(
                            'pembagianjam/simpan_ajax'
                        ) ?>",
                        {

                            method:
                                'POST',

                            headers:{
                                'Content-Type':
                                'application/x-www-form-urlencoded'
                            },

                            body:
                                new URLSearchParams({

                                    kelas_id:
                                        kelas_id,

                                    guru_id:
                                        guru_id,

                                    jumlah_jam:
                                        jumlah_jam
                                })
                        }
                    )

                    .then(
                        response =>
                        response.json()
                    )

                    .then(
    data => {

        console.log(data);

        if(
    data.status
){

    // simpan rombel terakhir
    localStorage.setItem(
        'openCollapse',
        '#collapse' + kelas_id
    );

    localStorage.setItem(
        'openForm',
        '#form' + kelas_id
    );

    location.reload();

}else{

            alert(
                data.message
                ||
                'Gagal simpan'
            );
        }
    }
)

                    .catch(
                        error => {

                            alert(
                                'Terjadi kesalahan server'
                            );

                            console.error(
                                error
                            );
                        }
                    );

                }
            );

        });

    }
);
// buka kembali accordion terakhir
const openCollapse =
    localStorage.getItem(
        'openCollapse'
    );

if(openCollapse){

    const collapseEl =
        document.querySelector(
            openCollapse
        );

    if(collapseEl){

        collapseEl.classList.add(
            'show'
        );
    }
}


// tampilkan form terakhir
const openForm =
    localStorage.getItem(
        'openForm'
    );

if(openForm){

    const formEl =
        document.querySelector(
            openForm
        );

    if(formEl){

        formEl.style.display =
            'table-row';
    }
}
</script>