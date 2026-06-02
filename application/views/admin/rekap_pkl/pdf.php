<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">

    <style>
        body{
            font-family: Arial, sans-serif;
            font-size: 11px;
        }

        h2{
            text-align:center;
            margin-bottom:20px;
        }

        table{
            width:100%;
            border-collapse:collapse;
        }

        table th,
        table td{
            border:1px solid #000;
            padding:6px;
            vertical-align:top;
        }

        table th{
            background:#f2f2f2;
            text-align:center;
        }

        .text-center{
            text-align:center;
        }
    </style>
</head>
<body>

<h2>
    REKAP DATA PKL
</h2>

<table>

    <thead>

        <tr>
            <th width="4%">No</th>
            <th width="18%">Nama Siswa</th>
            <th width="10%">NISN</th>
            <th width="12%">Kelas</th>
            <th width="15%">Nama DUDI</th>
            <th width="12%">Nomor MoU</th>
            <th width="19%">Judul PKS</th>
            <th width="10%">Pembimbing</th>
        </tr>

    </thead>

    <tbody>

    <?php if(empty($rekap)): ?>

        <tr>
            <td colspan="8" class="text-center">
                Data tidak ditemukan
            </td>
        </tr>

    <?php else: ?>

        <?php $no = 1; ?>

        <?php foreach($rekap as $r): ?>

            <tr>

                <td class="text-center">
                    <?= $no++ ?>
                </td>

                <td>
                    <?= $r['nama'] ?>
                </td>

                <td>
                    <?= $r['nisn'] ?>
                </td>

                <td>
                    <?= $r['kelas'] ?? '-' ?>
                </td>

                <td>
                    <?= $r['dudi'] ?? '-' ?>
                </td>

                <td>
                    <?= $r['nomor_mou'] ?? '-' ?>
                </td>

                <td>
                    <?= $r['judul_pks'] ?? '-' ?>
                </td>

                <td>
                    <?= $r['pembimbing'] ?? '-' ?>
                </td>

            </tr>

        <?php endforeach; ?>

    <?php endif; ?>

    </tbody>

</table>

</body>
</html>