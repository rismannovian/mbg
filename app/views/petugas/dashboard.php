<?php require_once 'app/views/layouts/header.php'; ?>

<div class="container mt-4">
    <div class="card shadow-sm border-0">
        <div class="card-body">

            <h4 class="mb-3 text-primary">
                <i class="bi bi-person-lines-fill"></i> Dashboard Petugas
            </h4>

            <hr>

            <div class="row mb-3">
                <div class="col-md-6">
                    <p class="mb-2">
                        <strong>Nama:</strong><br>
                        <?= htmlspecialchars($petugas['nama'] ?? '-') ?>
                    </p>

                    <p class="mb-2">
                        <strong>Jabatan:</strong><br>
                        <?= htmlspecialchars($petugas['jabatan'] ?? '-') ?>
                    </p>

                    <p class="mb-2">
                        <strong>No HP:</strong><br>
                        <?= htmlspecialchars($petugas['no_hp'] ?? '-') ?>
                    </p>
                </div>
            </div>

            <!-- QUOTE / NILAI -->
            <div class="alert alert-light border mt-4">
                <i class="bi bi-quote"></i>
                <em>
                    "Laksanakan setiap tugas dengan penuh tanggung jawab dan keikhlasan.
                    Karena dari keikhlasan itulah lahir pelayanan terbaik dan keberkahan dalam pekerjaan."
                </em>
            </div>

        </div>
    </div>
</div>

<?php require_once 'app/views/layouts/footer.php'; ?>