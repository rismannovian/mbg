<?php require_once 'app/views/layouts/header.php'; ?>

<div class="container mt-4">

    <!-- WELCOME -->
    <div class="card shadow border-0 mb-4" style="border-left: 5px solid #28a745;">
        <div class="card-body d-flex justify-content-between align-items-center">
            <div>
                <h4 class="mb-2">
                    🛠️ Selamat datang,
                    <strong><?= $_SESSION['user']['nama'] ?? 'Admin'; ?></strong>
                </h4>
                <p class="text-muted mb-0">
                    Anda memiliki akses penuh untuk mengelola sistem
                    <b>Makan Bergizi Gratis (MBG)</b>.
                </p>
            </div>
            <i class="bi bi-gear fs-1 text-success"></i>
        </div>
    </div>

    <!-- INFO ADMIN -->
    <div class="card shadow-sm border-0 mb-4 bg-light">
        <div class="card-body text-center">
            <i class="bi bi-clipboard-data fs-1 text-success"></i>
            <p class="mt-3 mb-0 fs-5 fst-italic">
                “Pengelolaan yang baik memastikan setiap siswa mendapatkan
                asupan gizi yang layak. Data yang akurat adalah kunci keberhasilan program.”
            </p>
        </div>
    </div>

    <!-- INFO PANEL -->
    <div class="row">

        <!-- STATUS LOGIN -->
        <div class="col-md-4 mb-3">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-body">
                    <h6 class="text-muted">Status Login</h6>
                    <h5>
                        <span class="badge bg-success">
                            <?= ucfirst($_SESSION['user']['role'] ?? 'admin'); ?>
                        </span>
                    </h5>
                    <p class="mb-0 text-muted">
                        Anda berhasil masuk ke sistem MBG.
                    </p>
                </div>
            </div>
        </div>

        <!-- HAK AKSES -->
        <div class="col-md-4 mb-3">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-body">
                    <h6 class="text-muted">Hak Akses</h6>
                    <h5 class="text-success">Full Access</h5>
                    <p class="mb-0 text-muted">
                        Kelola data siswa, menu makanan, dan distribusi MBG.
                    </p>
                </div>
            </div>
        </div>

        <!-- AKSI CEPAT -->
        <div class="col-md-4 mb-3">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-body">
                    <h6 class="text-muted">Aksi Cepat</h6>

                    <a href="index.php?url=admin/siswa" class="btn btn-outline-success btn-sm mt-2 w-100">
                        <i class="bi bi-people"></i> Data Siswa
                    </a>

                    <a href="index.php?url=admin/menu" class="btn btn-outline-success btn-sm mt-2 w-100">
                        <i class="bi bi-egg-fried"></i> Kelola Menu Makanan
                    </a>

                    <a href="index.php?url=admin/pesanan" class="btn btn-outline-success btn-sm mt-2 w-100">
                        <i class="bi bi-cart-check"></i> Data Pesanan
                    </a>

                </div>
            </div>
        </div>

    </div>

</div>

<?php require_once 'app/views/layouts/footer.php'; ?>