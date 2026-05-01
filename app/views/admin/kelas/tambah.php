<?php require_once 'app/views/layouts/header.php'; ?>

<div class="container mt-4">
    <div class="card shadow-sm">

        <!-- HEADER -->
        <div class="card-header bg-success text-white">
            <h4 class="mb-0">
                <i class="bi bi-plus-circle"></i> Tambah Kelas
            </h4>
        </div>

        <div class="card-body">

            <!-- NOTIFIKASI -->
            <?php if (!empty($_SESSION['error'])): ?>
                <div class="alert alert-danger">
                    <?= $_SESSION['error']; unset($_SESSION['error']); ?>
                </div>
            <?php endif; ?>

            <!-- FORM -->
            <form method="POST" action="index.php?url=admin/simpan_kelas">

                <div class="mb-3">
                    <label class="form-label">Nama Kelas</label>
                    <input type="text"
                           name="nama_kelas"
                           class="form-control"
                           placeholder="Contoh: XI-1"
                           required>
                </div>

                <!-- BUTTON -->
                <div class="d-flex justify-content-between">
                    <a href="index.php?url=admin/kelas" class="btn btn-secondary">
                        <i class="bi bi-arrow-left"></i> Kembali
                    </a>

                    <button type="submit" class="btn btn-success">
                        <i class="bi bi-save"></i> Simpan
                    </button>
                </div>

            </form>

        </div>
    </div>
</div>

<?php require_once 'app/views/layouts/footer.php'; ?>