<?php
/** @var array $kelas */

require_once 'app/views/layouts/header.php';
?>


<div class="container">
    <div class="bg-white p-4 rounded shadow-sm">
        <h4 class="mb-4">Tambah Siswa</h4>

        <form action="index.php?url=admin/simpan_siswa" method="POST">

            <div class="mb-3">
                <label for="nis" class="form-label">NIS</label>
                <input type="text" name="nis" id="nis" class="form-control" required>
            </div>

            <div class="mb-3">
                <label for="nama" class="form-label">Nama Lengkap</label>
                <input type="text" name="nama" id="nama" class="form-control" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Tahun Pelajaran</label>
                <select name="tahun_pelajaran" class="form-select" required>
                    <option value="">-- Pilih Tahun Pelajaran --</option>

                    <?php
                    $tahun_sekarang = date('Y');
                    for ($i = $tahun_sekarang; $i >= $tahun_sekarang - 5; $i--) :
                        $value = ($i - 1) . '/' . $i;
                        $selected = ($i == $tahun_sekarang) ? 'selected' : '';
                    ?>
                        <option value="<?= $value ?>" <?= $selected ?>>
                            <?= $value ?>
                        </option>
                    <?php endfor; ?>
                </select>
            </div>

            <div class="mb-3">
                <label for="kelas_id" class="form-label">Kelas</label>
                <select name="kelas_id" id="kelas_id" class="form-select" required>
                    <option value="">-- Pilih Kelas --</option>

                    <?php foreach ($kelas as $k): ?>
                        <option value="<?= $k['id'] ?>">
                            <?= htmlspecialchars($k['nama_kelas']) ?>
                        </option>
                    <?php endforeach; ?>

                </select>
            </div>

            <!-- ✅ TOMBOL HARUS DI DALAM FORM -->
            <button type="submit" class="btn btn-success">
                <i class="bi bi-save"></i> Simpan
            </button>

            <a href="index.php?url=admin/siswa" class="btn btn-secondary">
                Batal
            </a>

        </form>
    </div>
</div>

<?php require_once 'app/views/layouts/footer.php'; ?>