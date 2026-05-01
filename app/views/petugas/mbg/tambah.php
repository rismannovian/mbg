<?php
/** @var array $petugas */

require_once 'app/views/layouts/header.php';
?>

<div class="container mt-4">
    <div class="card shadow-sm">

        <!-- HEADER -->
        <div class="card-header bg-primary text-white">
            <h4 class="mb-0">
                <i class="bi bi-plus-circle"></i> Tambah Data MBG
            </h4>
        </div>

        <div class="card-body">

            <form action="index.php?url=mbg/simpan" method="POST" enctype="multipart/form-data">

                <div class="row">

                    <!-- PETUGAS -->
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Petugas</label>
                        <select name="petugas_id" class="form-select" required>
                            <option value="">-- Pilih Petugas --</option>
                            <?php foreach ($petugas as $p): ?>
                                <option value="<?= $p['id']; ?>">
                                    <?= htmlspecialchars($p['nama']); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                   <!-- TANGGAL -->
<div class="col-md-6 mb-3">
    <label class="form-label">Tanggal</label>
    <input type="date" name="tanggal" class="form-control" required>
</div>

<!-- JUMLAH MBG -->
<div class="col-md-6 mb-3">
    <label class="form-label">Jumlah MBG</label>
    <input type="number" name="jml_mbg" class="form-control" min="1" required>
</div>

<!-- FOTO DATANG -->
<div class="col-md-6 mb-3">
    <label class="form-label">Foto Datang</label>
    <input type="file" name="foto_datang" class="form-control" accept="image/*">
    <small class="text-muted">Format gambar: jpg, png, jpeg</small>
</div>

<!-- FOTO LAPORAN -->
<div class="col-md-6 mb-3">
    <label class="form-label">Foto Laporan</label>
    <input type="file" name="foto_laporan" class="form-control" accept="image/*">
    <small class="text-muted">Format gambar: jpg, png, jpeg</small>
</div>
                </div>

                <!-- BUTTON -->
                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-success">
                        <i class="bi bi-save"></i> Simpan
                    </button>

                    <a href="index.php?url=mbg/index" class="btn btn-secondary">
                        <i class="bi bi-arrow-left"></i> Kembali
                    </a>
                </div>

            </form>

        </div>
    </div>
</div>

<?php require_once 'app/views/layouts/footer.php'; ?>