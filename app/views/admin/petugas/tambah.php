<?php require_once 'app/views/layouts/header.php'; ?>

<div class="container mt-4">
    <div class="card shadow-sm">
        <div class="card-header bg-success text-white">
            <h4 class="mb-0">Tambah Petugas</h4>
        </div>

        <div class="card-body">

            <?php if (!empty($_SESSION['error'])) : ?>
                <div class="alert alert-danger"><?= $_SESSION['error']; unset($_SESSION['error']); ?></div>
            <?php endif; ?>

            <form action="index.php?url=admin/simpan_petugas" method="POST">

                <div class="mb-3">
                    <label class="form-label">Username</label>
                    <input type="text" name="username" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Nama</label>
                    <input type="text" name="nama" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Jabatan</label>
                    <input type="text" name="jabatan" class="form-control">
                </div>

                <div class="mb-3">
                    <label class="form-label">No HP</label>
                    <input type="text" name="no_hp" class="form-control">
                </div>

                <button type="submit" class="btn btn-success">
                    <i class="bi bi-save"></i> Simpan
                </button>

                <a href="index.php?url=admin/petugas" class="btn btn-secondary">
                    Batal
                </a>

            </form>

        </div>
    </div>
</div>

<?php require_once 'app/views/layouts/footer.php'; ?>