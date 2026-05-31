<div id="content-wrapper" class="d-flex flex-column">
<div id="content">

<nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

   <!-- Desktop -->
<button id="sidebarToggle"
        class="btn btn-link d-none d-md-inline rounded-circle mr-3">
    <i class="fas fa-bars"></i>
</button>

<!-- Mobile -->
<button id="sidebarToggleTop"
        class="btn btn-link d-md-none rounded-circle mr-3">
    <i class="fas fa-bars"></i>
</button>

    <!-- Title -->
    <h5 class="ml-3 mt-2 text-gray-600">
        <?= isset($title) ? $title : 'Admin Panel' ?>
    </h5>

    <!-- Right Menu -->
    <ul class="navbar-nav ml-auto">

        <?php
        $tema = $this->db
            ->get_where(
                'pengaturan',
                [
                    'nama_pengaturan' =>
                    'tema_aplikasi'
                ]
            )
            ->row();
        ?>

        <li class="nav-item">

            <a
                class="nav-link"
                href="<?= base_url('pengaturan/toggle_theme') ?>"
                title="Ganti Tema">

                <?php if(
                    isset($tema->value)
                    &&
                    $tema->value == 'dark'
                ): ?>

                    <i class="fas fa-sun text-warning"></i>

                <?php else: ?>

                    <i class="fas fa-moon text-secondary"></i>

                <?php endif; ?>

            </a>

        </li>

        <li class="nav-item dropdown no-arrow">

            <a class="nav-link dropdown-toggle"
               href="#"
               data-toggle="dropdown">

                <span class="mr-2 d-none d-lg-inline text-gray-600 small">
                    <?= $this->session->userdata('username') ?>
                </span>

                <i class="fas fa-user-circle fa-lg"></i>

            </a>

            <div class="dropdown-menu dropdown-menu-right shadow">

                <a class="dropdown-item"
                   href="<?= base_url('logout') ?>">

                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>

                    Logout

                </a>

            </div>

        </li>

    </ul>

</nav>

<div class="container-fluid">