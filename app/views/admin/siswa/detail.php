<?php
/** @var array $siswa */

require_once 'app/views/layouts/header.php';
?>


<div class="container mt-4">
    <div class="card shadow-lg border-0">
        <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
            <h5 class="mb-0"><i class="bi bi-person-lines-fill"></i> Detail Siswa</h5>
            <a href="index.php?url=admin/siswa" class="btn btn-light btn-sm">
                <i class="bi bi-arrow-left"></i> Kembali
            </a>
        </div>

        <div class="card-body">
            <div class="row g-4 align-items-center">

                <!-- FOTO -->
                <div class="col-md-3 text-center">
                    <?php if (!empty($siswa['foto'])): ?>
                        <img src="assets/foto/<?= htmlspecialchars($siswa['foto']) ?>"
                            class="img-fluid rounded shadow-sm border"
                            style="max-height: 200px;"
                            alt="Foto Siswa">
                    <?php else: ?>
                        <img src="assets/foto/default.png"
                            class="img-fluid rounded shadow-sm border"
                            style="max-height: 200px;"
                            alt="Default">
                    <?php endif; ?>

                    <p class="mt-3 mb-0 fw-bold fs-5"><?= htmlspecialchars($siswa['nama']) ?></p>
                    <small class="text-muted">NIS: <?= htmlspecialchars($siswa['nis']) ?></small>
                </div>

                <!-- DATA -->
                <div class="col-md-9">
                    <table class="table table-sm">
                        <tr>
                            <th>Tahun Pelajaran</th>
                            <td>: <?= htmlspecialchars($siswa['tahun_pelajaran']) ?></td>
                        </tr>
                        <tr>
                            <th>Kelas</th>
                            <td>: <?= htmlspecialchars($siswa['kelas']) ?></td>
                        </tr>
                        <tr>
                            <th>Jenis Kelamin</th>
                            <td>: <?= $siswa['jk'] ?></td>
                        </tr>
                        <tr>
                            <th>Wali Kelas</th>
                            <td>: <?= htmlspecialchars($siswa['wali_kelas']) ?></td>
                        </tr>
                        <tr>
                            <th>Nama Ayah</th>
                            <td>: <?= htmlspecialchars($siswa['nama_ayah']) ?></td>
                        </tr>
                        <tr>
                            <th>Nama Ibu</th>
                            <td>: <?= htmlspecialchars($siswa['nama_ibu']) ?></td>
                        </tr>
                        <tr>
                            <th>Alamat</th>
                            <td>: <?= htmlspecialchars($siswa['alamat']) ?></td>
                        </tr>
                        <tr>
                            <th>No. Telepon</th>
                            <td>: <?= htmlspecialchars($siswa['no_telp']) ?></td>
                        </tr>
                    </table>
                </div>

            </div>
        </div>
    </div>
</div>

<?php require_once 'app/views/layouts/footer.php'; ?>