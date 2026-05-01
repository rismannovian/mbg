<?php require_once 'app/views/layouts/header.php'; ?>

<div class="container mt-4">
    <div class="card shadow-sm">

        <!-- HEADER -->
        <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
            <h4 class="mb-0">
                <i class="bi bi-people-fill"></i> Manajemen User
            </h4>
            <a href="index.php?url=admin/tambah_user" class="btn btn-light btn-sm">
                <i class="bi bi-person-plus"></i> Tambah User
            </a>
        </div>

        <div class="card-body">

            <?php if (!empty($users)) : ?>

                <div class="table-responsive">
                    <table class="table table-bordered table-striped table-hover align-middle"
                        id="datatable"
                        style="min-width: 1000px;">
                        <thead class="table-primary text-center">
                            <tr>
                                <th width="50">No</th>
                                <th>Username</th>
                                <th>Nama</th>
                                <th>Role</th>
                                <th>Siswa ID</th>
                                <th>Last Login</th>
                                <th width="180">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $no = 1;
                            foreach ($users as $user): ?>
                                <tr>
                                    <td class="text-center"><?= $no++ ?></td>
                                    <td><?= htmlspecialchars($user['username']) ?></td>
                                    <td class="fw-semibold"><?= htmlspecialchars($user['nama']) ?></td>

                                    <!-- ROLE BADGE -->
                                    <td class="text-center">
                                        <?php
                                        $role = $user['role'];
                                        $color = 'secondary';

                                        if ($role == 'admin') $color = 'danger';
                                        elseif ($role == 'guru') $color = 'success';
                                        elseif ($role == 'walikelas') $color = 'warning';
                                        elseif ($role == 'siswa') $color = 'info';
                                        ?>

                                        <span class="badge bg-<?= $color ?>">
                                            <?= ucfirst($role) ?>
                                        </span>
                                    </td>

                                    <td class="text-center"><?= $user['siswa_id'] ?: '-' ?></td>

                                    <td class="text-center">
                                        <?= $user['last_login']
                                            ? date('d-m-Y H:i', strtotime($user['last_login']))
                                            : '<span class="text-muted">-</span>' ?>
                                    </td>

                                    <!-- AKSI -->
                                    <td class="text-center">
                                        <div class="btn-group btn-group-sm">
                                            <a href="index.php?url=admin/reset_password/<?= $user['id'] ?>"
                                                class="btn btn-secondary"
                                                onclick="return confirm('Reset password ke default (123456)?')"
                                                title="Reset Password">
                                                <i class="bi bi-arrow-clockwise"></i>
                                            </a>

                                            <a href="index.php?url=admin/hapus_user/<?= $user['id'] ?>"
                                                class="btn btn-danger"
                                                onclick="return confirm('Yakin ingin menghapus user ini?')"
                                                title="Hapus">
                                                <i class="bi bi-trash"></i>
                                            </a>
                                        </div>
                                    </td>

                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>

            <?php else : ?>
                <div class="alert alert-info">Belum ada data user.</div>
            <?php endif; ?>

        </div>
    </div>
</div>

<?php require_once 'app/views/layouts/footer.php'; ?>