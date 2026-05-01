<?php
/** @var array $siswa */

require_once 'app/views/layouts/header.php';
?>


<div class="container">
    <div class="bg-white p-4 rounded shadow-sm">
        <h4 class="mb-4">Edit Siswa</h4>

        <form action="index.php?url=admin/update_siswa/<?= $siswa['id'] ?>" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="id" value="<?= $siswa['id'] ?>">

            <div class="mb-3">
                <label for="nis" class="form-label">NIS</label>
                <input type="text" name="nis" id="nis" class="form-control" value="<?= htmlspecialchars($siswa['nis']) ?>" required>
            </div>

            <div class="mb-3">
                <label for="nama" class="form-label">Nama Lengkap</label>
                <input type="text" name="nama" id="nama" class="form-control" value="<?= htmlspecialchars($siswa['nama']) ?>" required>
            </div>

           <div class="mb-3">
    <label class="form-label">Tahun Pelajaran</label>
    <select name="tahun_pelajaran" class="form-select" required>
        <option value="">-- Pilih Tahun Pelajaran --</option>

        <?php
        $tahun_sekarang = date('Y');

        for ($i = $tahun_sekarang; $i >= $tahun_sekarang - 5; $i--) :
            $tahun1 = $i - 1;
            $tahun2 = $i;
            $value = $tahun1 . '/' . $tahun2;

            $selected = ($siswa['tahun_pelajaran'] == $value) ? 'selected' : '';
        ?>
            <option value="<?= $value ?>" <?= $selected ?>>
                <?= $value ?>
            </option>
        <?php endfor; ?>
    </select>
</div>

            <!-- ✅ KELAS -->
            <div class="mb-3">
                <label for="kelas" class="form-label">Kelas</label>
                <input type="text" name="kelas" id="kelas" class="form-control" value="<?= htmlspecialchars($siswa['kelas']) ?>" required>
            </div>



            <button type="submit" class="btn btn-primary">
                <i class="bi bi-save"></i> Update
            </button>
            <a href="index.php?url=admin/siswa" class="btn btn-secondary">
                Batal
            </a>
        </form>
    </div>
</div>

<?php require_once 'app/views/layouts/footer.php'; ?>