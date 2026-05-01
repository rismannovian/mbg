<?php require_once 'app/views/layouts/header.php'; ?>

<div class="container mt-4">

    <!-- WELCOME CARD -->
    <div class="card shadow border-0 mb-4" style="border-left: 5px solid #28a745;">
        <div class="card-body d-flex align-items-center justify-content-between">
            <div>
                <h4 class="mb-2">
                    🍽️ Selamat datang,
                    <strong><?= $_SESSION['user']['nama'] ?? 'Siswa'; ?></strong>
                </h4>
                <p class="text-muted mb-0">
                    Selamat datang di Aplikasi <b>Makan Bergizi Gratis (MBG)</b>.
                    Pastikan kamu memanfaatkan program ini untuk hidup lebih sehat!
                </p>
            </div>
            <i class="bi bi-egg-fried fs-1 text-success"></i>
        </div>
    </div>

    <!-- INFO PROGRAM MBG -->
    <div class="card shadow-sm border-0 mb-4 bg-light">
        <div class="card-body text-center">
            <i class="bi bi-heart-pulse fs-1 text-success"></i>
            <h5 class="mt-3">Program Makan Bergizi Gratis</h5>
            <p class="mb-0 text-muted">
                Program ini bertujuan untuk meningkatkan kesehatan dan konsentrasi belajar siswa
                melalui penyediaan makanan bergizi setiap hari di sekolah.
            </p>
        </div>
    </div>

    <!-- INFO BOX -->
    <div class="row">

        <!-- STATUS LOGIN -->
        <div class="col-md-4 mb-3">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-body">
                    <h6 class="text-muted">Status Login</h6>
                    <h5>
                        <span class="badge bg-success">
                            <?= ucfirst($_SESSION['user']['role'] ?? 'siswa'); ?>
                        </span>
                    </h5>
                    <p class="mb-0 text-muted">
                        Anda berhasil masuk ke sistem MBG.
                    </p>
                </div>
            </div>
        </div>

        <!-- MENU HARI INI -->
        <div class="col-md-4 mb-3">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-body">
                    <h6 class="text-muted">Menu Hari Ini</h6>

                   <!-- MENU HARI INI -->
                   <div class="col-md-6 mb-3">
                    <div class="card shadow-sm border-0 h-100">

                        <?php if (!empty($mbg) && !empty($mbg['foto_datang'])): ?>
                            <img src="assets/mbg/<?= $mbg['foto_datang']; ?>" 
                                class="card-img-top img-fluid"
                                style="object-fit:contain;">
                        <?php else: ?>
                            <div class="d-flex align-items-center justify-content-center"
                                style="min-height:150px;">
                                <span class="text-muted">Belum ada foto</span>
                            </div>
                        <?php endif; ?>

                    </div>
                </div>
                </div>
            </div>
        </div>

        <!-- AKSI CEPAT -->
        <div class="col-md-4 mb-3">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-body">
                    <h6 class="text-muted">Aksi Cepat</h6>
                    
                    <a href="index.php?url=siswa/mbg" class="btn btn-success btn-sm mt-2">
                        <i class="bi bi-cart"></i> Pesan Makanan
                    </a>
                </div>
            </div>
        </div>

    </div>

</div>

<?php require_once 'app/views/layouts/footer.php'; ?>