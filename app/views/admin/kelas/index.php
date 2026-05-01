<?php require_once 'app/views/layouts/header.php'; ?>

<div class="container mt-4">
    <div class="card shadow-sm">

        <!-- HEADER -->
        <div class="card-header bg-success text-white d-flex justify-content-between align-items-center">
            <h4 class="mb-0">
                <i class="bi bi-building"></i> Data Kelas
            </h4>
            <div>
                <a href="index.php?url=admin/tambah_kelas" class="btn btn-light btn-sm">
                    <i class="bi bi-plus-circle"></i> Tambah
                </a>
            </div>
        </div>

        <div class="card-body">

            <!-- TABLE -->
            <div class="table-responsive">
                <table class="table table-bordered table-striped table-hover align-middle"
                       id="datatable"
                       style="min-width: 600px;">
                    <thead class="table-success text-center">
                        <tr>
                            <th width="50">No</th>
                            <th>Nama Kelas</th>
                          
                            <th width="150">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($kelas)): ?>
                            <?php $no = 1; ?>
                            <?php foreach ($kelas as $k): ?>
                                <tr>
                                    <td class="text-center"><?= $no++ ?></td>
                                    <td class="fw-semibold"><?= htmlspecialchars($k['nama_kelas']) ?></td>
                             

                                    <td class="text-center">
                                        <div class="btn-group btn-group-sm">

                                            <a href="index.php?url=admin/edit_kelas/<?= $k['id'] ?>"
                                               class="btn btn-warning" title="Edit">
                                                <i class="bi bi-pencil-square"></i>
                                            </a>

                                            <a href="index.php?url=admin/hapus_kelas/<?= $k['id'] ?>"
                                               class="btn btn-danger"
                                               onclick="return confirm('Yakin ingin menghapus kelas ini?')"
                                               title="Hapus">
                                                <i class="bi bi-trash"></i>
                                            </a>

                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="4" class="text-center text-muted">
                                    Data kelas belum tersedia
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>

        </div>
    </div>
</div>

<?php require_once 'app/views/layouts/footer.php'; ?>