<?php
/** @var array $row */
/** @var array $petugas */

require_once 'app/views/layouts/header.php';
?>

<div class="container mt-4">
    <div class="card shadow-sm">

        <!-- HEADER -->
        <div class="card-header bg-warning text-dark">
            <h4 class="mb-0">
                <i class="bi bi-pencil-square"></i> Edit Data MBG
            </h4>
        </div>

        <div class="card-body">

            <form action="index.php?url=mbg/update" method="POST" enctype="multipart/form-data">

                <input type="hidden" name="id" value="<?= $row['id']; ?>">
                <input type="hidden" name="foto_lama" value="<?= $row['foto_datang']; ?>">
                <input type="hidden" name="foto_laporan_lama" value="<?= $row['foto_laporan']; ?>">

                <div class="row">

                    <!-- PETUGAS -->
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Petugas</label>
                        <select name="petugas_id" class="form-select" required>
                            <option value="">-- Pilih Petugas --</option>
                            <?php foreach ($petugas as $p): ?>
                                <option value="<?= $p['id']; ?>"
                                    <?= ($row['petugas_id'] == $p['id']) ? 'selected' : ''; ?>>
                                    <?= htmlspecialchars($p['nama']); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <!-- TANGGAL -->
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Tanggal</label>
                        <input type="date"
                            name="tanggal"
                            class="form-control"
                            value="<?= $row['tanggal']; ?>"
                            required>
                    </div>

                    <!-- JUMLAH MBG -->
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Jumlah MBG</label>
                        <input type="number"
                            name="jml_mbg"
                            class="form-control"
                            min="1"
                            value="<?= $row['jml_mbg']; ?>"
                            required>
                    </div>

                    <!-- STATUS -->
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Status</label>
                        <select name="status" class="form-select" required>
                            <option value="aktif" <?= ($row['status'] == 'aktif') ? 'selected' : ''; ?>>Aktif</option>
                            <option value="ditutup" <?= ($row['status'] == 'ditutup') ? 'selected' : ''; ?>>Ditutup</option>
                            <option value="selesai" <?= ($row['status'] == 'selesai') ? 'selected' : ''; ?>>Selesai</option>
                        </select>
                    </div>

                    <!-- FOTO DATANG -->
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Foto MBG</label>
                        <input type="file" name="foto_datang" class="form-control" accept="image/*">

                        <?php if (!empty($row['foto_datang'])): ?>
                            <div class="mt-2">
                                <a href="#"
                                class="btn btn-sm btn-info btn-preview"
                                data-img="assets/mbg/<?= $row['foto_datang']; ?>"
                                title="Lihat Foto Datang">
                                    <i class="bi bi-image"></i> Lihat Foto Lama
                                </a>
                            </div>
                        <?php endif; ?>
                    </div>

                    <!-- FOTO LAPORAN -->
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Foto Laporan</label>
                        <input type="file" name="foto_laporan" class="form-control" accept="image/*">

                        <?php if (!empty($row['foto_laporan'])): ?>
                            <div class="mt-2">
                                <a href="#"
                                class="btn btn-sm btn-success btn-preview"
                                data-img="assets/mbg/<?= $row['foto_laporan']; ?>"
                                title="Lihat Foto Laporan">
                                    <i class="bi bi-image"></i> Lihat Foto Lama
                                </a>
                            </div>
                        <?php endif; ?>
                    </div>

                </div>

                <!-- BUTTON -->
                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-success">
                        <i class="bi bi-save"></i> Update
                    </button>

                    <a href="index.php?url=mbg/index" class="btn btn-secondary">
                        <i class="bi bi-arrow-left"></i> Kembali
                    </a>
                </div>

            </form>

        </div>
    </div>
</div>

<!-- MODAL PREVIEW -->
<div class="modal fade" id="modalPreview" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-body text-center">
                <img id="previewImage" src="" class="img-fluid rounded">
            </div>
        </div>
    </div>
</div>

<?php require_once 'app/views/layouts/footer.php'; ?>