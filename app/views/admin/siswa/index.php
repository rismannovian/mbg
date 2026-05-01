<?php require_once 'app/views/layouts/header.php'; ?>

<div class="container mt-4">
    <div class="card shadow-sm">

        <!-- HEADER -->
        <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
            <h4 class="mb-0">
                <i class="bi bi-people-fill"></i> Data Siswa
            </h4>
            <div class="d-flex gap-2">
                <a href="index.php?url=admin/tambah_siswa" class="btn btn-light btn-sm">
                    <i class="bi bi-person-plus"></i> Tambah
                </a>
                <a href="assets/template/template_import_siswa.xlsx" class="btn btn-light btn-sm">
                    <i class="bi bi-download"></i> Template
                </a>
            </div>
        </div>

        <div class="card-body">

            <!-- IMPORT -->
            <form action="index.php?url=admin/import_siswa" method="POST" enctype="multipart/form-data" class="mb-3">
                <div class="row g-2">
                    <div class="col-md-4">
                        <input type="file" name="file_excel" class="form-control form-control-sm" accept=".xlsx" required>
                    </div>
                    <div class="col-auto">
                        <button type="submit" class="btn btn-sm btn-success">
                            <i class="bi bi-file-earmark-excel"></i> Import
                        </button>
                    </div>
                </div>
            </form>

            <!-- TABLE -->
            <div class="table-responsive">
                <table class="table table-bordered table-striped table-hover align-middle"
                    id="datatable"
                    style="min-width: 800px;">
                    <thead class="table-primary text-center">
                        <tr>
                            <th width="50">No</th>
                            <th>NIS</th>
                            <th>Nama</th>
                            <th>Tahun Pelajaran</th>
                            <th>Kelas</th>
                            <th width="150">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
    <?php if (!empty($siswa)): ?>
        <?php $no = 1; ?>
        <?php foreach ($siswa as $s): ?>
            <tr>
                <td class="text-center"><?= $no++ ?></td>
                <td><?= htmlspecialchars($s['nis'] ?? '') ?></td>
                <td class="fw-semibold"><?= htmlspecialchars($s['nama'] ?? '') ?></td>
                <td class="text-center"><?= htmlspecialchars($s['tahun_pelajaran'] ?? '') ?></td>
               <td><?= htmlspecialchars($s['nama_kelas'] ?? '-') ?></td>

                <td class="text-center">
                    <div class="btn-group btn-group-sm">
                        <a href="index.php?url=admin/edit_siswa/<?= $s['id'] ?>"
                            class="btn btn-warning" title="Edit">
                            <i class="bi bi-pencil-square"></i>
                        </a>

                        <a href="index.php?url=admin/hapus_siswa/<?= $s['id'] ?>"
                            class="btn btn-danger"
                            onclick="return confirm('Yakin ingin menghapus siswa ini?')"
                            title="Hapus">
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