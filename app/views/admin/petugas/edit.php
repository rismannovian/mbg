<?php
/** @var array $petugas */

require_once 'app/views/layouts/header.php';
?>


<div class="container mt-4">
    <div class="card shadow-sm">
        <div class="card-header bg-warning">
            <h4 class="mb-0">Edit Petugas</h4>
        </div>

        <div class="card-body">

            <form action="index.php?url=admin/update_petugas/<?= $petugas['id'] ?>" method="POST">

                <div class="mb-3">
                    <label class="form-label">Username</label>
                    <input type="text" class="form-control" 
                           value="<?= htmlspecialchars($petugas['username']) ?>" readonly>
                </div>

                <div class="mb-3">
                    <label class="form-label">Nama</label>
                    <input type="text" name="nama" class="form-control" 
                           value="<?= htmlspecialchars($petugas['nama']) ?>" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Jabatan</label>
                    <input type="text" name="jabatan" class="form-control" 
                           value="<?= htmlspecialchars($petugas['jabatan'] ?? '') ?>">
                </div>

                <div class="mb-3">
                    <label class="form-label">No HP</label>
                    <input type="text" name="no_hp" class="form-control" 
                           value="<?= htmlspecialchars($petugas['no_hp'] ?? '') ?>">
                </div>

                <button type="submit" class="btn btn-warning">
                    <i class="bi bi-save"></i> Update
                </button>

                <a href="index.php?url=admin/petugas" class="btn btn-secondary">
                    Batal
                </a>

            </form>

        </div>
    </div>
</div>

<?php require_once 'app/views/layouts/footer.php'; ?>