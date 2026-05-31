<h3 class="mb-4">

    Mapping Manual:
    <strong>
        <?= $guru->nama_guru ?>
    </strong>

</h3>

<form
method="post"
action="<?= base_url(
'distribusimanual/simpan'
) ?>">

<input
type="hidden"
name="guru_id"
value="<?= $guru->id ?>">

<div class="accordion"
id="accordionKelas">

<?php foreach($jam as $i => $j): ?>

<?php

$selected = [];

if(!empty($j->selected)){

    foreach(
        $j->selected
        as $sel
    ){

        $selected[] =
            $sel['siswa_id'];
    }
}
?>

<div class="card shadow-sm border-0 mb-3">

    <div class="card-header bg-white">

        <div class="d-flex
                    justify-content-between
                    align-items-center">

            <button
                type="button"

                class="btn btn-link
                       text-left
                       p-0"

                data-toggle="collapse"

                data-target="#kelas<?= $i ?>">

                <strong>

                    <?= $j->nama_kelas ?>

                </strong>

            </button>

            <div>

                <span class="badge badge-info">

                    <?= $j->jumlah_jam ?>

                    JP

                </span>

                <span
                class="badge badge-primary">

                    <span
                    id="counter_<?= $j->real_kelas_id ?>">

                        0

                    </span>

                    /
                    <?= $j->jatah ?>

                    siswa

                </span>

            </div>

        </div>

    </div>

    <div
    id="kelas<?= $i ?>"

    class="collapse
           <?= $i == 0
           ? 'show'
           : '' ?>"

    data-parent="#accordionKelas">

        <div class="card-body">

            <!-- search -->
            <div class="mb-3">

                <input
                    type="text"

                    class="form-control search-siswa"

                    data-kelas="<?= $j->real_kelas_id ?>"

                    placeholder="Cari siswa...">

            </div>

            <div class="row siswa-wrapper"
                 id="wrapper_<?= $j->real_kelas_id ?>">

            <?php foreach(
                $j->siswa
                as $s
            ): ?>

            <div
            class="col-md-6 mb-2 siswa-item"

            data-name="<?= strtolower(
                $s->nama
            ) ?>">

                <label
                class="border rounded
                       p-2 w-100 mb-0
                       d-flex
                       align-items-center"

                style="
                cursor:pointer;
                ">

                    <input
                    type="checkbox"

                    class="checkbox-siswa mr-3"

                    data-kelas="<?= $j->real_kelas_id ?>"

                    data-max="<?= $j->jatah ?>"

                    name="siswa[<?= $j->real_kelas_id ?>][]"

                    value="<?= $s->id ?>"

                    <?= in_array(
                        $s->id,
                        $selected
                    )

                    ?

                    'checked'

                    :

                    '' ?>

                    >

                    <div>

                        <strong>

                            <?= $s->nama ?>

                        </strong>

                        <br>

                        <small class="text-muted">

                            NISN:
                            <?= $s->nisn ?>

                        </small>

                    </div>

                </label>

            </div>

            <?php endforeach; ?>

            </div>

        </div>

    </div>

</div>

<?php endforeach; ?>

</div>

<div class="mt-4">

    <button
    type="submit"
    class="btn btn-primary">

        Simpan Mapping

    </button>

    <a href="<?= base_url(
        'distribusimanual'
    ) ?>"

    class="btn btn-secondary">

        Kembali

    </a>

</div>

</form>
<script>

function updateCounter(kelasId)
{
    const checked =
        document.querySelectorAll(
            '.checkbox-siswa[data-kelas="' +
            kelasId +
            '"]:checked'
        );

    const counter =
        document.getElementById(
            'counter_' +
            kelasId
        );

    if(counter){

        counter.innerText =
            checked.length;
    }
}


// checkbox limit
document
.querySelectorAll(
'.checkbox-siswa'
)
.forEach(function(cb){

    cb.addEventListener(
    'change',

    function(){

        const kelasId =
            this.dataset.kelas;

        const max =
            parseInt(
                this.dataset.max
            );

        const checked =
            document.querySelectorAll(
                '.checkbox-siswa[data-kelas="' +
                kelasId +
                '"]:checked'
            );

        if(
            checked.length
            >
            max
        ){

            alert(
                'Maksimal '
                + max +
                ' siswa'
            );

            this.checked =
                false;

            return;
        }

        updateCounter(
            kelasId
        );
    });
});


// search siswa
document
.querySelectorAll(
'.search-siswa'
)
.forEach(function(input){

    input.addEventListener(
    'keyup',

    function(){

        const keyword =
            this.value
            .toLowerCase();

        const kelasId =
            this.dataset.kelas;

        const items =
            document.querySelectorAll(
                '#wrapper_' +
                kelasId +
                ' .siswa-item'
            );

        items.forEach(function(item){

            const nama =
                item.dataset.name;

            item.style.display =
                nama.includes(
                    keyword
                )

                ?

                ''

                :

                'none';
        });
    });
});


// init counter
document
.querySelectorAll(
'.checkbox-siswa'
)
.forEach(function(cb){

    updateCounter(
        cb.dataset.kelas
    );
});

</script>