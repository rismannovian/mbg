<?php
/** @var array $kelas */

require_once 'app/views/layouts/header.php';
?>


<div class="container mt-4">
    <div class="card shadow-sm">

        <!-- HEADER -->
        <div class="card-header bg-warning text-dark">
            <h4 class="mb-0">
                <i class="bi bi-pencil-square"></i> Edit Kelas
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
            <form method="POST" action="index.php?url=admin/update_kelas/<?= $kelas['id'] ?>">

                <div class="mb-3">
                    <label class="form-label">Nama Kelas</label>
                    <input type="text"
                           name="nama_kelas"
                           class="form-control"
                           value="<?= htmlspecialchars($kelas['nama_kelas'] ?? '') ?>"
                           required>
                </div>


                <!-- BUTTON -->
                <div class="d-flex justify-content-between">
                    <a href="index.php?url=admin/kelas" class="btn btn-secondary">
                        <i class="bi bi-arrow-left"></i> Kembali
                    </a>

                    <button type="submit" class="btn btn-warning text-dark">
                        <i class="bi bi-save"></i> Update
                    </button>
                </div>

            </form>

        </div>
    </div>
</div>

<?php require_once 'app/views/layouts/footer.php'; ?>