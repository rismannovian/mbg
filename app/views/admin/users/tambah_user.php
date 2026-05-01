<?php require_once 'app/views/layouts/header.php'; ?>

<div class="container">
    <div class="bg-white p-4 rounded shadow-sm">
        <h4 class="mb-4">Tambah User</h4>

        <form action="index.php?url=admin/simpan_user" method="POST">
            <div class="mb-3">
                <label>Username</label>
                <input type="text" name="username" class="form-control" required>
            </div>

            <div class="mb-3">
                <label>Nama Lengkap</label>
                <input type="text" name="nama" class="form-control" required>
            </div>

            <div class="mb-3">
                <label>Role</label>
                <select name="role" class="form-control" required>
                    <option value="">-- Pilih Role --</option>
                    <option value="admin">Admin</option>
                    <option value="guru">Guru</option>
                    <option value="walikelas">Wali Kelas</option>
                </select>
            </div>

            <div class="mb-3">
                <label>Password (default)</label>
                <input type="text" name="password" class="form-control" value="123456" readonly>
            </div>

            <button class="btn btn-success">Simpan</button>
            <a href="index.php?url=admin/admin" class="btn btn-secondary">Kembali</a>
        </form>
    </div>
</div>

<?php require_once 'app/views/layouts/footer.php'; ?>
