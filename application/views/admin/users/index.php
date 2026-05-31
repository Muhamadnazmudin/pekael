<h1 class="h3 mb-4 text-gray-800">
    Manajemen User
</h1>

<?php if($this->session->flashdata('success')): ?>
<div class="alert alert-success">
    <?= $this->session->flashdata('success') ?>
</div>
<?php endif; ?>

<?php if($this->session->flashdata('error')): ?>
<div class="alert alert-danger">
    <?= $this->session->flashdata('error') ?>
</div>
<?php endif; ?>

<div class="card shadow mb-4">

    <div class="card-header">

        <button
            class="btn btn-primary"
            data-toggle="modal"
            data-target="#modalTambah">

            Tambah User

        </button>

    </div>

    <div class="card-body">

        <div class="table-responsive">

            <table
                class="table table-bordered">

                <thead>

                    <tr>

                        <th width="60">
                            No
                        </th>

                        <th>
                            Username
                        </th>

                        <th width="150">
                            Role
                        </th>

                        <th width="180">
                            Dibuat
                        </th>

                        <th width="180">
                            Aksi
                        </th>

                    </tr>

                </thead>

                <tbody>

                <?php
                $no=1;

                foreach(
                    $users
                    as $u
                ):
                ?>

                <tr>

                    <td>
                        <?= $no++ ?>
                    </td>

                    <td>
                        <?= $u->username ?>
                    </td>

                    <td>
                        <?= ucfirst($u->role) ?>
                    </td>

                    <td>
                        <?= $u->created_at ?>
                    </td>

                    <td>

                        <button
                            class="btn btn-warning btn-sm"
                            data-toggle="modal"
                            data-target="#edit<?= $u->id ?>">

                            Edit

                        </button>

                        <a
                            href="<?= base_url('users/hapus/'.$u->id) ?>"
                            class="btn btn-danger btn-sm"
                            onclick="return confirm('Hapus user ini?')">

                            Hapus

                        </a>

                    </td>

                </tr>
<div class="modal fade" id="edit<?= $u->id ?>">

<div class="modal-dialog">

<div class="modal-content">

<form
action="<?= base_url('users/edit/'.$u->id) ?>"
method="post">

<div class="modal-header">

    <h5>Edit User</h5>

</div>

<div class="modal-body">

    <div class="form-group">

        <label>Username</label>

        <input
            type="text"
            name="username"
            class="form-control"
            value="<?= $u->username ?>"
            required>

    </div>

    <div class="form-group">

        <label>Password Baru</label>

        <input
            type="password"
            name="password"
            class="form-control">

        <small>
            Kosongkan jika tidak diubah
        </small>

    </div>

    <div class="form-group">

        <label>Role</label>

        <select
            name="role"
            class="form-control">

            <option
                value="admin"
                <?= $u->role=='admin'?'selected':'' ?>>
                Admin
            </option>

            <option
                value="operator"
                <?= $u->role=='operator'?'selected':'' ?>>
                Operator
            </option>

        </select>

    </div>

</div>

<div class="modal-footer">

    <button
        class="btn btn-success">

        Update

    </button>

</div>

</form>

</div>

</div>

</div>
                <?php endforeach; ?>

                </tbody>

            </table>
<div class="modal fade" id="modalTambah">

<div class="modal-dialog">

<div class="modal-content">

<form
action="<?= base_url('users/tambah') ?>"
method="post">

<div class="modal-header">

    <h5>Tambah User</h5>

</div>

<div class="modal-body">

    <div class="form-group">

        <label>Username</label>

        <input
            type="text"
            name="username"
            class="form-control"
            required>

    </div>

    <div class="form-group">

        <label>Password</label>

        <input
            type="password"
            name="password"
            class="form-control"
            required>

    </div>

    <div class="form-group">

        <label>Role</label>

        <select
            name="role"
            class="form-control">

            <option value="admin">
                Admin
            </option>

            <option value="operator">
                Operator
            </option>

        </select>

    </div>

</div>

<div class="modal-footer">

    <button
        class="btn btn-primary">

        Simpan

    </button>

</div>

</form>

</div>

</div>

</div>
        </div>

    </div>

</div>