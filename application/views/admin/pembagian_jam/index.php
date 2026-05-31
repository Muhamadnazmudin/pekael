<style>
   .edit-input{
    width:55px;
    height:35px;
    padding:0;
    margin:auto;
    text-align:center;
    font-size:18px;
    font-weight:bold;
    border:2px solid #4e73df;
    border-radius:4px;
    background:#fff;
    color:#000;
}
    </style>
<h1 class="h3 mb-4 text-gray-800">
    Pembagian Jam Mengajar
</h1>

<div class="d-flex justify-content-between mb-3">

    <a href="<?= base_url('pembagianjam/tambah') ?>"
       class="btn btn-primary">

        <i class="fas fa-plus"></i>
        Tambah Pembagian Jam

    </a>

</div>

<?php if($this->session->flashdata('success')): ?>

<div class="alert alert-success alert-dismissible fade show">

    <?= $this->session->flashdata('success') ?>

    <button type="button"
            class="close"
            data-dismiss="alert">

        <span>&times;</span>

    </button>

</div>

<?php endif; ?>


<?php

$matrix = [];

foreach($jam as $j){

    $matrix[
        $j->guru_id
    ][
        $j->kelas_id
    ] = [

        'jam' => $j->jumlah_jam,

        'id' => $j->id
    ];
}
$jp_maksimal =
    !empty($pengaturan_pkl)
    ? (int)$pengaturan_pkl->jam_pkl
    : 0;
?>

<div class="card shadow">

    <div class="card-header">

        <h6 class="m-0 font-weight-bold text-primary">

            Matriks Pembagian Jam Mengajar

        </h6>

    </div>

    <div class="card-body p-0">

        <div class="table-responsive">

            <table class="table table-bordered table-hover mb-0">

                <thead class="thead-light">

                    <tr>

                        <th width="60">
                            No
                        </th>

                        <th width="250">
                            Nama Guru
                        </th>

                        <?php foreach($kelas as $k): ?>

                        <th class="text-center">

                            <?= $k->nama_kelas ?>

                        </th>

                        <?php endforeach; ?>

                        <th width="100"
                            class="text-center">

                            Total

                        </th>

                    </tr>

                </thead>

                <tbody>

                <?php

                $no = 1;

                foreach($guru as $g):

                    $totalGuru = 0;

                ?>

                <tr>

                    <td>

                        <?= $no++ ?>

                    </td>

                    <td>

                        <strong>

                            <?= $g->nama_guru ?>

                        </strong>

                    </td>

                    <?php foreach($kelas as $k): ?>

                    <td class="text-center">

                    <?php

                    if(
                        isset(
                            $matrix[
                                $g->id
                            ][
                                $k->id
                            ]
                        )
                    ):

                        $dataJam =
                            $matrix[
                                $g->id
                            ][
                                $k->id
                            ];

                        $totalGuru +=
                            $dataJam['jam'];

                    ?>

                       <span
class="editable-cell badge badge-info"

data-guru="<?= $g->id ?>"

data-kelas="<?= $k->id ?>">

<?= $dataJam['jam'] ?>

</span>

                        <br>

                        <a href="<?= base_url(
                            'pembagianjam/hapus/'
                            .$dataJam['id']
                        ) ?>"

                        onclick="
                            return confirm(
                                'Hapus data?'
                            )
                        "

                        class="text-danger">

                            <i class="fas fa-times"></i>

                        </a>

                    <?php else: ?>

                        <span
class="editable-cell text-primary font-weight-bold"

data-guru="<?= $g->id ?>"

data-kelas="<?= $k->id ?>">

+

</span>

                    <?php endif; ?>

                    </td>

                    <?php endforeach; ?>

                    <td class="text-center font-weight-bold">

                        <?= $totalGuru ?>

                    </td>

                </tr>

                <?php endforeach; ?>

                </tbody>

                <tfoot>

                    <tr class="total-row">

                        <th colspan="2">

                            Total Kelas

                        </th>

                        <?php

                        $grandTotal = 0;

                        foreach($kelas as $k):

                            $totalKelas = 0;

                            foreach($guru as $g){

                                if(
                                    isset(
                                        $matrix[
                                            $g->id
                                        ][
                                            $k->id
                                        ]
                                    )
                                ){

                                    $totalKelas +=
                                        $matrix[
                                            $g->id
                                        ][
                                            $k->id
                                        ]['jam'];
                                }
                            }

                            $grandTotal +=
                                $totalKelas;

                        ?>

                        <th class="text-center">

<?php

$class = 'total-less';

if($totalKelas == $jp_maksimal){
    $class = 'total-valid';
}elseif($totalKelas > $jp_maksimal){
    $class = 'total-over';
}

?>

<span class="badge <?= $class ?>">

    <?= $totalKelas ?>/<?= $jp_maksimal ?>

</span>

</th>

                        <?php endforeach; ?>

                        <th class="text-center">

                            <?= $grandTotal ?>

                        </th>

                    </tr>

                </tfoot>

            </table>

        </div>

    </div>

</div>
<script>

document.addEventListener(
'click',
function(e){

    if(
        !e.target.classList.contains(
            'editable-cell'
        )
    ){
        return;
    }

    const cell = e.target;

    const guru =
        cell.dataset.guru;

    const kelas =
        cell.dataset.kelas;

    let nilai =
        cell.innerText.trim();

    if(
        nilai === '+'
    ){
        nilai = '';
    }

    const input =
        document.createElement(
            'input'
        );

    input.type =
        'number';

    input.min =
        0;

    input.className =
    'edit-input';

    input.value =
        nilai;

    cell.innerHTML =
        '';

    cell.appendChild(
        input
    );

    input.focus();
    input.select();

    function simpan(){

        const jp =
            input.value;

        fetch(
            "<?= base_url('pembagianjam/update_ajax') ?>",
            {

                method:'POST',

                headers:{
                    'Content-Type':
                    'application/x-www-form-urlencoded'
                },

                body:
                new URLSearchParams({

                    guru_id:
                        guru,

                    kelas_id:
                        kelas,

                    jumlah_jam:
                        jp
                })
            }
        )
        .then(
            r => r.json()
        )
        .then(
            data => {

                if(
                    data.status
                ){

                    location.reload();

                }else{

                    Swal.fire({
    toast: true,
    position: 'top-end',
    icon: 'error',
    title: data.message,
    showConfirmButton: false,
    timer: 3000,
    timerProgressBar: true
});
                }
            }
        );
    }

    input.addEventListener(
        'blur',
        simpan
    );

    input.addEventListener(
        'keydown',
        function(e){

            if(
                e.key === 'Enter'
            ){

                simpan();
            }
        }
    );
});

</script>