<?php require_once 'app/views/layouts/header.php'; ?>

<div class="container mt-4">
    <div class="card shadow-sm">

        <!-- HEADER -->
        <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
            <h4 class="mb-0">
                <i class="bi bi-person-badge"></i> Data Petugas
            </h4>
            <a href="index.php?url=admin/tambah_petugas" class="btn btn-light btn-sm">
                <i class="bi bi-plus"></i> Tambah
            </a>
        </div>

        <div class="card-body">

            <!-- NOTIF -->
            <?php if (!empty($_SESSION['success'])) : ?>
                <div class="alert alert-success"><?= $_SESSION['success']; unset($_SESSION['success']); ?></div>
            <?php endif; ?>

            <?php if (!empty($_SESSION['error'])) : ?>
                <div class="alert alert-danger"><?= $_SESSION['error']; unset($_SESSION['error']); ?></div>
            <?php endif; ?>

            <!-- TABLE -->
            <div class="table-responsive">
                <table class="table table-bordered table-striped table-hover align-middle">
                    <thead class="table-primary text-center">
                        <tr>
                            <th width="50">No</th>
                            <th>Username</th>
                            <th>Nama</th>
                            <th>Jabatan</th>
                            <th>No HP</th>
                            <th width="150">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($petugas)) : ?>
                            <?php $no = 1; ?>
                            <?php foreach ($petugas as $p) : ?>
                                <tr>
                                    <td class="text-center"><?= $no++ ?></td>
                                    <td><?= htmlspecialchars($p['username']) ?></td>
                                    <td class="fw-semibold"><?= htmlspecialchars($p['nama']) ?></td>
                                    <td><?= htmlspecialchars($p['jabatan'] ?? '-') ?></td>
                                    <td><?= htmlspecialchars($p['no_hp'] ?? '-') ?></td>
                                    <td class="text-center">
                                        <div class="btn-group btn-group-sm">
                                            <a href="index.php?url=admin/edit_petugas/<?= $p['id'] ?>" 
                                               class="btn btn-warning">
                                                <i class="bi bi-pencil"></i>
                                            </a>

                                            <a href="index.php?url=admin/hapus_petugas/<?= $p['id'] ?>" 
                                               class="btn btn-danger"
                                               onclick="return confirm('Yakin hapus petugas ini?')">
                                                <i class="bi bi-trash"></i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>

        </div>
    </div>
</div>

<?php require_once 'app/views/layouts/footer.php'; ?>