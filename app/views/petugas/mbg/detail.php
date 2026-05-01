<?php
/** @var array $mbg */
/** @var array $rekap */
require_once 'app/views/layouts/header.php';
?>

<div class="container mt-4">

    <div class="card shadow-sm">

        <!-- HEADER -->
        <div class="card-header bg-info text-white d-flex justify-content-between align-items-center">
            <h4 class="mb-0">
                <i class="bi bi-eye"></i> Detail Data MBG
            </h4>

            <a href="index.php?url=mbg" class="btn btn-light btn-sm">
                <i class="bi bi-arrow-left"></i> Kembali
            </a>
        </div>

        <!-- BODY -->
        <div class="card-body">

           <?php
            $sisa = $mbg['jml_mbg'] - $rekap['total_ambil'];
            $belum_kembali = $rekap['total_ambil'] - $rekap['total_kembali'];
            ?>

            <div class="row mb-4 g-2">

                <div class="col">
                    <div class="card border-0 shadow-sm text-center bg-primary text-white">
                        <div class="card-body py-2 px-2">
                            <small class="d-block">Porsi MBG</small>
                            <h5 class="mb-0"><?= number_format($mbg['jml_mbg']) ?></h5>
                        </div>
                    </div>
                </div>

                <div class="col">
                    <div class="card border-0 shadow-sm text-center bg-success text-white">
                        <div class="card-body py-2 px-2">
                            <small class="d-block">Total Ambil</small>
                            <h5 class="mb-0"><?= number_format($rekap['total_ambil']) ?></h5>
                        </div>
                    </div>
                </div>

                <div class="col">
                    <div class="card border-0 shadow-sm text-center bg-warning text-dark">
                        <div class="card-body py-2 px-2">
                            <small class="d-block">Kembali</small>
                            <h5 class="mb-0"><?= number_format($rekap['total_kembali']) ?></h5>
                        </div>
                    </div>
                </div>

                <div class="col">
                    <div class="card border-0 shadow-sm text-center bg-danger text-white">
                        <div class="card-body py-2 px-2">
                            <small class="d-block">Sisa</small>
                            <h5 class="mb-0"><?= number_format($sisa) ?></h5>
                        </div>
                    </div>
                </div>

               <div class="col">
    <div class="card border-0 shadow-sm text-center bg-dark text-white">
        <div class="card-body py-2 px-2">
            <small class="d-block">Belum Kembali</small>
            <h5 class="mb-0">
                <?php 
                    // Menampilkan 0 jika statusnya belum Disetujui
                    if ($mbg['status'] == 'pesan' || $mbg['status'] == 'disetujui') {
                        echo "0"; // Tampilkan 0 jika status masih 'pesan' atau 'disetujui'
                    } else {
                        echo number_format($rekap['belum_kembali']);
                    }
                ?>
            </h5>
        </div>
    </div>
</div>

            </div>

            <!-- DETAIL DATA -->
            <div class="row g-3">

                <div class="col-md-6">
                    <label class="fw-semibold">Tanggal</label>
                    <div class="form-control bg-light">
                        <?= date('d-m-Y', strtotime($mbg['tanggal'])) ?>
                    </div>
                </div>

                <div class="col-md-6">
                    <label class="fw-semibold">Petugas</label>
                    <div class="form-control bg-light">
                        <?= htmlspecialchars($mbg['nama']) ?>
                    </div>
                </div>

                <div class="col-md-6">
                    <label class="fw-semibold">Jumlah MBG</label>
                    <div class="form-control bg-light">
                        <?= number_format($mbg['jml_mbg']) ?>
                    </div>
                </div>

                <div class="col-md-6">
                    <label class="fw-semibold">Status</label>
                    <div class="form-control bg-light">

                        <?php if ($mbg['status'] == 'aktif'): ?>
                            <span class="badge bg-success">Aktif</span>
                        <?php elseif ($mbg['status'] == 'ditutup'): ?>
                            <span class="badge bg-warning text-dark">Ditutup</span>
                        <?php else: ?>
                            <span class="badge bg-secondary">Selesai</span>
                        <?php endif; ?>

                    </div>
                </div>

                <!-- FOTO DATANG -->
                <div class="col-md-6">
                    <label class="fw-semibold">Foto MBG Datang</label>
                    <div class="border rounded p-2 text-center bg-light">

                        <?php if (!empty($mbg['foto_datang'])): ?>
                            <img src="assets/mbg/<?= $mbg['foto_datang'] ?>"
                                class="img-fluid rounded"
                                style="max-height:250px;">
                        <?php else: ?>
                            <span class="text-muted">Tidak ada foto</span>
                        <?php endif; ?>

                    </div>
                </div>

                <!-- FOTO LAPORAN -->
                <div class="col-md-6">
                    <label class="fw-semibold">Foto Laporan</label>
                    <div class="border rounded p-2 text-center bg-light">

                        <?php if (!empty($mbg['foto_laporan'])): ?>
                            <img src="assets/mbg/<?= $mbg['foto_laporan'] ?>"
                                class="img-fluid rounded"
                                style="max-height:250px;">
                        <?php else: ?>
                            <span class="text-muted">Tidak ada foto</span>
                        <?php endif; ?>

                    </div>
                </div>

            </div>

        </div>

    </div>

</div>

<?php require_once 'app/views/layouts/footer.php'; ?>