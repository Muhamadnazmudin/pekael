<?php
$menu = $this->uri->segment(1);
$sub  = $this->uri->segment(2);

/*
|--------------------------------------------------------------------------
| ACTIVE MENU
|--------------------------------------------------------------------------
*/

$master_menu = in_array($menu, [
    'sekolah',
    'tahun',
    'jurusan',
    'kelas',
    'guru',
    'siswa',
    'dudi'
]);

$pkl_menu = in_array($menu, [
    'mappingdudi',
    'koefisien',
    'pembagianjam',
    'pembimbing',
    'pembimbingkelas'
]);

$distribusi_menu = in_array($menu, [
    'distribusi',
    'distribusimanual'
]);

$laporan_menu = ($menu == 'laporan');

$sistem_menu = in_array($menu, [
    'pengaturan',
    'auth',
    'backup'
]);
?>

<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion"
    id="accordionSidebar">

    <!-- BRAND -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center"
       href="<?= base_url('dashboard') ?>">

        <div class="sidebar-brand-icon">
            <i class="fas fa-user-graduate"></i>
        </div>

        <div class="sidebar-brand-text mx-2">
            PEKAEL
        </div>
    </a>

    <hr class="sidebar-divider my-0">

    <!-- DASHBOARD -->
    <li class="nav-item <?= ($menu == 'dashboard') ? 'active' : '' ?>">
        <a class="nav-link"
           href="<?= base_url('dashboard') ?>">

            <i class="fas fa-home"></i>
            <span>Dashboard</span>
        </a>
    </li>

    <hr class="sidebar-divider">

    <!-- MASTER DATA -->
    <div class="sidebar-heading">
        Data Master
    </div>

    <li class="nav-item <?= $master_menu ? 'active' : '' ?>">

        <a class="nav-link collapsed"
           href="#"
           data-toggle="collapse"
           data-target="#masterMenu"
           aria-expanded="<?= $master_menu ? 'true' : 'false' ?>">

            <i class="fas fa-database"></i>
            <span>Master Data</span>
        </a>

        <div id="masterMenu"
             class="collapse <?= $master_menu ? 'show' : '' ?>"
             data-parent="#accordionSidebar">

            <div class="bg-white py-2 collapse-inner rounded">

                <a class="collapse-item <?= ($menu == 'sekolah') ? 'active' : '' ?>"
                   href="<?= base_url('sekolah') ?>">
                    Profil Sekolah
                </a>

                <a class="collapse-item <?= ($menu == 'tahun') ? 'active' : '' ?>"
                   href="<?= base_url('tahun') ?>">
                    Tahun Ajaran
                </a>

                <a class="collapse-item <?= ($menu == 'jurusan') ? 'active' : '' ?>"
                   href="<?= base_url('jurusan') ?>">
                    Jurusan
                </a>

                <a class="collapse-item <?= ($menu == 'kelas') ? 'active' : '' ?>"
                   href="<?= base_url('kelas') ?>">
                    Kelas
                </a>

                <a class="collapse-item <?= ($menu == 'guru') ? 'active' : '' ?>"
                   href="<?= base_url('guru') ?>">
                    Guru
                </a>

                <a class="collapse-item <?= ($menu == 'siswa') ? 'active' : '' ?>"
                   href="<?= base_url('siswa') ?>">
                    Siswa
                </a>

                <a class="collapse-item <?= ($menu == 'dudi') ? 'active' : '' ?>"
                   href="<?= base_url('dudi') ?>">
                    DUDI
                </a>

            </div>
        </div>
    </li>

    <!-- PERSIAPAN PKL -->
    <div class="sidebar-heading">
        Proses PKL
    </div>

    <li class="nav-item <?= $pkl_menu ? 'active' : '' ?>">

        <a class="nav-link collapsed"
           href="#"
           data-toggle="collapse"
           data-target="#pklMenu"
           aria-expanded="<?= $pkl_menu ? 'true' : 'false' ?>">

            <i class="fas fa-briefcase"></i>
            <span>Persiapan PKL</span>
        </a>

        <div id="pklMenu"
             class="collapse <?= $pkl_menu ? 'show' : '' ?>"
             data-parent="#accordionSidebar">

            <div class="bg-white py-2 collapse-inner rounded">

                <a class="collapse-item <?= ($menu == 'mappingdudi') ? 'active' : '' ?>"
                   href="<?= base_url('mappingdudi') ?>">
                    Mapping DUDI
                </a>

                <a class="collapse-item <?= ($menu == 'koefisien') ? 'active' : '' ?>"
                   href="<?= base_url('koefisien') ?>">
                    Koefisien PKL
                </a>

                <a class="collapse-item <?= ($menu == 'pembagianjam') ? 'active' : '' ?>"
                   href="<?= base_url('pembagianjam') ?>">
                    Pembagian Jam
                </a>

                <a class="collapse-item <?= ($menu == 'pembimbing') ? 'active' : '' ?>"
                   href="<?= base_url('pembimbing') ?>">
                    Pembimbing PKL
                </a>
                <!-- <a class="collapse-item <?= ($menu == 'pembimbingkelas') ? 'active' : '' ?>"
   href="<?= base_url('pembimbingkelas') ?>">
    Pembimbing PKL Per Kelas
</a> -->
            </div>
        </div>
    </li>

    <!-- DISTRIBUSI -->
    <li class="nav-item <?= $distribusi_menu ? 'active' : '' ?>">

        <a class="nav-link collapsed"
           href="#"
           data-toggle="collapse"
           data-target="#distribusiMenu"
           aria-expanded="<?= $distribusi_menu ? 'true' : 'false' ?>">

            <i class="fas fa-random"></i>
            <span>Distribusi & Penempatan</span>
        </a>

        <div id="distribusiMenu"
             class="collapse <?= $distribusi_menu ? 'show' : '' ?>"
             data-parent="#accordionSidebar">

            <div class="bg-white py-2 collapse-inner rounded">

                <a class="collapse-item <?= ($menu == 'distribusi') ? 'active' : '' ?>"
                   href="<?= base_url('distribusi') ?>">
                    Distribusi Otomatis
                </a>

                <a class="collapse-item <?= ($menu == 'distribusimanual') ? 'active' : '' ?>"
                   href="<?= base_url('distribusimanual') ?>">
                    Distribusi Manual
                </a>

            </div>
        </div>
    </li>

    <hr class="sidebar-divider">

    <!-- LAPORAN -->
    <li class="nav-item <?= $laporan_menu ? 'active' : '' ?>">

        <a class="nav-link collapsed"
           href="#"
           data-toggle="collapse"
           data-target="#laporanMenu"
           aria-expanded="<?= $laporan_menu ? 'true' : 'false' ?>">

            <i class="fas fa-file-alt"></i>
            <span>Laporan</span>
        </a>

        <div id="laporanMenu"
             class="collapse <?= $laporan_menu ? 'show' : '' ?>"
             data-parent="#accordionSidebar">

            <div class="bg-white py-2 collapse-inner rounded">

                <a class="collapse-item <?= ($sub == 'pembimbing') ? 'active' : '' ?>"
                   href="<?= base_url('laporan-pembimbing') ?>">
                    Cetak Pembimbing
                </a>

                <a class="collapse-item <?= ($sub == 'rekap') ? 'active' : '' ?>"
                   href="<?= base_url('laporan/rekap') ?>">
                    Rekap PKL
                </a>

            </div>
        </div>
    </li>

    <hr class="sidebar-divider">

    <!-- SISTEM -->
    <li class="nav-item <?= $sistem_menu ? 'active' : '' ?>">

        <a class="nav-link collapsed"
           href="#"
           data-toggle="collapse"
           data-target="#sistemMenu"
           aria-expanded="<?= $sistem_menu ? 'true' : 'false' ?>">

            <i class="fas fa-cogs"></i>
            <span>Sistem</span>
        </a>

        <div id="sistemMenu"
             class="collapse <?= $sistem_menu ? 'show' : '' ?>"
             data-parent="#accordionSidebar">

            <div class="bg-white py-2 collapse-inner rounded">

                <a class="collapse-item <?= ($menu == 'pengaturan') ? 'active' : '' ?>"
                   href="<?= base_url('pengaturan') ?>">
                    Pengaturan
                </a>
                <a class="collapse-item <?= ($menu == 'backup') ? 'active' : '' ?>"
   href="<?= base_url('backup') ?>">
    Backup Database
</a>
<a class="collapse-item <?= ($menu == 'users') ? 'active' : '' ?>"
   href="<?= base_url('users') ?>">
    Manajemen User
</a>

                <a class="collapse-item"
                   href="<?= base_url('auth/logout') ?>">
                    Logout
                </a>

            </div>
        </div>
    </li>

</ul>