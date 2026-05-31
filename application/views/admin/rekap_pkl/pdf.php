<h2 style="text-align:center">
    REKAP PKL
</h2>

<table border="1"
       width="100%"
       cellspacing="0"
       cellpadding="6">

    <tr>
        <th>No</th>
        <th>Nama Siswa</th>
        <th>Kelas</th>
        <th>DUDI</th>
        <th>Pembimbing</th>
    </tr>

    <?php $no=1; foreach($rekap as $r): ?>

    <tr>
        <td><?= $no++ ?></td>
        <td><?= $r['nama'] ?></td>
        <td><?= $r['kelas'] ?></td>
        <td><?= $r['dudi'] ?></td>
        <td><?= $r['pembimbing'] ?></td>
    </tr>

    <?php endforeach; ?>

</table>