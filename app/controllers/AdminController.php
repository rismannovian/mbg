<?php
class AdminController extends Controller
{
    // ================= HELPER =================
    private function checkAdmin()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
            header('Location: index.php?url=auth/login');
            exit;
        }
    }

    // ================= DASHBOARD =================
    public function dashboard()
    {
        $this->checkAdmin();
        $this->view('admin/dashboard');
    }

    public function index()
    {
        header("Location: index.php?url=admin/dashboard");
        exit;
    }

    // ================= USER =================
    public function admin()
    {
        $this->checkAdmin();

        $model = $this->model('UserModel');
        $data['users'] = $model->getAll();

        $this->view('admin/users/index', $data);
    }

    public function tambah_user()
    {
        $this->checkAdmin();
        $this->view('admin/users/tambah_user');
    }

    public function simpan_user()
    {
        $this->checkAdmin();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $username = trim($_POST['username'] ?? '');
            $nama     = trim($_POST['nama'] ?? '');
            $role     = $_POST['role'] ?? '';

            if (empty($username) || empty($nama) || empty($role)) {
                $_SESSION['error'] = "Semua field wajib diisi.";
                header('Location: index.php?url=admin/tambah_user');
                exit;
            }

            $model = $this->model('UserModel');

            if ($model->findByUsername($username)) {
                $_SESSION['error'] = "Username sudah digunakan.";
                header('Location: index.php?url=admin/tambah_user');
                exit;
            }

            $model->insert([
                'username' => $username,
                'nama'     => $nama,
                'role'     => $role,
                'password' => password_hash('123456', PASSWORD_BCRYPT)
            ]);

            $_SESSION['success'] = "User berhasil ditambahkan.";
            header('Location: index.php?url=admin/admin');
            exit;
        }
    }

    public function reset_password($id)
    {
        $this->checkAdmin();

        $model = $this->model('UserModel');
        $model->resetPassword($id, password_hash('123456', PASSWORD_BCRYPT));

        $_SESSION['success'] = "Password berhasil direset.";
        header('Location: index.php?url=admin/admin');
        exit;
    }

    public function hapus_user($id)
    {
        $this->checkAdmin();

        $model = $this->model('UserModel');
        $model->delete($id);

        $_SESSION['success'] = "User berhasil dihapus.";
        header('Location: index.php?url=admin/admin');
        exit;
    }

  // ================= SISWA =================
public function siswa()
{
    $this->checkAdmin();

    $model = $this->model('SiswaModel');
    $data['siswa'] = $model->getAllWithKelas(); // ✅ JOIN kelas

    $this->view('admin/siswa/index', $data);
}

public function tambah_siswa()
{
    $this->checkAdmin();

    $kelasModel = $this->model('KelasModel');

    $this->view('admin/siswa/tambah', [
        'kelas' => $kelasModel->getAll()
    ]);
}

public function simpan_siswa()
{
    $this->checkAdmin();

    $nis   = trim($_POST['nis'] ?? '');
    $nama  = trim($_POST['nama'] ?? '');
    $tahun = $_POST['tahun_pelajaran'] ?? '';
    $kelas_id = $_POST['kelas_id'] ?? null;

    if (empty($nis) || empty($nama)) {
        $_SESSION['error'] = "NIS dan Nama wajib diisi.";
        header('Location: index.php?url=admin/tambah_siswa');
        exit;
    }

    $siswaModel = $this->model('SiswaModel');
    $userModel  = $this->model('UserModel');

    if ($siswaModel->cekNis($nis)) {
        $_SESSION['error'] = "NIS sudah terdaftar.";
        header('Location: index.php?url=admin/tambah_siswa');
        exit;
    }

    $siswa_id = $siswaModel->insertSiswa([
        'nis' => $nis,
        'nama' => $nama,
        'tahun_pelajaran' => $tahun,
        'kelas_id' => $kelas_id // ✅ pakai relasi
    ]);

    $userModel->insert([
        'username' => $nis,
        'password' => password_hash($nis, PASSWORD_DEFAULT),
        'nama'     => $nama,
        'role'     => 'siswa',
        'siswa_id' => $siswa_id
    ]);

    $_SESSION['success'] = "Siswa berhasil ditambahkan.";
    header('Location: index.php?url=admin/siswa');
    exit;
}

public function edit_siswa($id)
{
    $this->checkAdmin();

    $siswaModel = $this->model('SiswaModel');
    $kelasModel = $this->model('KelasModel');

    $this->view('admin/siswa/edit', [
        'siswa' => $siswaModel->getById($id),
        'kelas' => $kelasModel->getAll()
    ]);
}

public function update_siswa($id)
{
    $this->checkAdmin();

    $model = $this->model('SiswaModel');

    $model->updateSiswa([
        'id' => $id,
        'nis' => $_POST['nis'],
        'nama' => $_POST['nama'],
        'tahun_pelajaran' => $_POST['tahun_pelajaran'],
        'kelas_id' => $_POST['kelas_id'] // ✅ pakai relasi
    ]);

    $_SESSION['success'] = "Data siswa berhasil diupdate.";
    header('Location: index.php?url=admin/siswa');
    exit;
}

public function detail_siswa($id)
{
    $this->checkAdmin();

    $model = $this->model('SiswaModel');
    $data['siswa'] = $model->getById($id);

    if (!$data['siswa']) {
        echo "Data tidak ditemukan.";
        return;
    }

    $this->view('admin/siswa/detail', $data);
}

public function hapus_siswa($id)
{
    $this->checkAdmin();

    $siswaModel = $this->model('SiswaModel');
    $userModel  = $this->model('UserModel');

    $siswa = $siswaModel->getById($id);

    if (!$siswa) {
        $_SESSION['error'] = "Data tidak ditemukan.";
        header('Location: index.php?url=admin/siswa');
        exit;
    }

    $userModel->deleteBySiswaId($id);

    if (!empty($siswa['foto']) && $siswa['foto'] !== 'default.png') {
        $path = __DIR__ . '/../../assets/foto/' . $siswa['foto'];
        if (file_exists($path)) {
            unlink($path);
        }
    }

    $siswaModel->delete($id);

    $_SESSION['success'] = "Data siswa berhasil dihapus.";
    header('Location: index.php?url=admin/siswa');
    exit;
}

public function import_siswa()
{
    $this->checkAdmin();

    require 'vendor/autoload.php';

    $siswaModel = $this->model('SiswaModel');
    $userModel  = $this->model('UserModel');

    if (!isset($_FILES['file_excel']) || $_FILES['file_excel']['error'] !== UPLOAD_ERR_OK) {
        $_SESSION['error'] = "Upload gagal.";
        header('Location: index.php?url=admin/siswa');
        exit;
    }

    $file = $_FILES['file_excel']['tmp_name'];

    $total = $berhasil = $duplikat = $gagal = 0;

    try {
        $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($file);
        $rows = $spreadsheet->getActiveSheet()->toArray();

        for ($i = 1; $i < count($rows); $i++) {
            $total++;

            $nis  = trim($rows[$i][0] ?? '');
            $nama = trim($rows[$i][1] ?? '');
            $tahun = trim($rows[$i][2] ?? '');
            $kelas_nama = trim($rows[$i][3] ?? '');

            if (empty($nis) || empty($nama)) {
                $gagal++;
                continue;
            }

            if ($siswaModel->cekNis($nis)) {
                $duplikat++;
                continue;
            }

            // 🔥 cari kelas berdasarkan nama
            $kelas = $this->model('KelasModel')->findByNama($kelas_nama);
            $kelas_id = $kelas ? $kelas['id'] : null;

            $siswa_id = $siswaModel->insertSiswa([
                'nis' => $nis,
                'nama' => $nama,
                'tahun_pelajaran' => $tahun,
                'kelas_id' => $kelas_id
            ]);

            if (!$siswa_id) {
                $gagal++;
                continue;
            }

            $userModel->insert([
                'username' => $nis,
                'password' => password_hash($nis, PASSWORD_DEFAULT),
                'nama' => $nama,
                'role' => 'siswa',
                'siswa_id' => $siswa_id
            ]);

            $berhasil++;
        }

        $_SESSION['success'] = "Import selesai: $berhasil berhasil, $duplikat duplikat, $gagal gagal.";
    } catch (Exception $e) {
        $_SESSION['error'] = $e->getMessage();
    }

    header('Location: index.php?url=admin/siswa');
    exit;
}

// KELAS

public function kelas()
{
    $this->checkAdmin();

    $model = $this->model('KelasModel');
    $data['kelas'] = $model->getAll();

    $this->view('admin/kelas/index', $data);
}

public function tambah_kelas()
{
    $this->checkAdmin();
    $this->view('admin/kelas/tambah');
}

public function simpan_kelas()
{
    $this->checkAdmin();

    $model = $this->model('KelasModel');

    $data = [
        'nama_kelas' => $_POST['nama_kelas']
      
    ];

    if (!$model->insert($data)) {
        $_SESSION['error'] = "Gagal menambahkan kelas / duplikat.";
        header('Location: index.php?url=admin/tambah_kelas');
        exit;
    }

    $_SESSION['success'] = "Kelas berhasil ditambahkan.";
    header('Location: index.php?url=admin/kelas');
    exit;
}

public function edit_kelas($id)
{
    $this->checkAdmin();

    $model = $this->model('KelasModel');
    $data['kelas'] = $model->getById($id);

    if (!$data['kelas']) {
        $_SESSION['error'] = "Data tidak ditemukan.";
        header('Location: index.php?url=admin/kelas');
        exit;
    }

    $this->view('admin/kelas/edit_kelas', $data);
}

public function update_kelas($id)
{
    $this->checkAdmin();

    $model = $this->model('KelasModel');

    $model->update([
        'id' => $id,
        'nama_kelas' => $_POST['nama_kelas']
      
    ]);

    $_SESSION['success'] = "Kelas berhasil diupdate.";
    header('Location: index.php?url=admin/kelas');
    exit;
}

public function hapus_kelas($id)
{
    $this->checkAdmin();

    $kelasModel = $this->model('KelasModel');
    $siswaModel = $this->model('SiswaModel');

    // cek data ada
    if (!$kelasModel->getById($id)) {
        $_SESSION['error'] = "Data kelas tidak ditemukan.";
        header('Location: index.php?url=admin/kelas');
        exit;
    }

    // cek apakah masih dipakai siswa
    if ($siswaModel->countByKelas($id) > 0) {
        $_SESSION['error'] = "Kelas masih digunakan siswa.";
        header('Location: index.php?url=admin/kelas');
        exit;
    }

    // hapus
    $kelasModel->delete($id);

    $_SESSION['success'] = "Kelas berhasil dihapus.";
    header('Location: index.php?url=admin/kelas');
    exit;
}

// ================= PETUGAS =================

// LIST DATA
public function petugas()
{
    $this->checkAdmin();

    $model = $this->model('PetugasModel');
    $data['petugas'] = $model->getAll();

    $this->view('admin/petugas/index', $data);
}

public function tambah_petugas()
{
    $this->checkAdmin();

    $this->view('admin/petugas/tambah');
}

public function simpan_petugas()
{
    $this->checkAdmin();

    $username = trim($_POST['username'] ?? '');
    $nama     = trim($_POST['nama'] ?? '');
    $jabatan  = trim($_POST['jabatan'] ?? '');
    $no_hp    = trim($_POST['no_hp'] ?? '');

    if (empty($username) || empty($nama)) {
        $_SESSION['error'] = "Username dan Nama wajib diisi.";
        header('Location: index.php?url=admin/tambah_petugas');
        exit;
    }

    $userModel    = $this->model('UserModel');
    $petugasModel = $this->model('PetugasModel');

    // Cek username
    if ($userModel->findByUsername($username)) {
        $_SESSION['error'] = "Username sudah digunakan.";
        header('Location: index.php?url=admin/tambah_petugas');
        exit;
    }

    // 1. insert user
    $user_id = $userModel->insert([
        'username' => $username,
        'password' => password_hash('123456', PASSWORD_DEFAULT),
        'nama'     => $nama,
        'role'     => 'petugas'
    ]);

    if (!$user_id) {
        $_SESSION['error'] = "Gagal membuat user.";
        header('Location: index.php?url=admin/tambah_petugas');
        exit;
    }

    // 2. insert petugas
    $petugasModel->insert([
        'user_id' => $user_id,
        'nama'    => $nama,
        'jabatan' => $jabatan,
        'no_hp'   => $no_hp
    ]);

    $_SESSION['success'] = "Petugas berhasil ditambahkan.";
    header('Location: index.php?url=admin/petugas');
    exit;
}

public function edit_petugas($id)
{
    $this->checkAdmin();

    $model = $this->model('PetugasModel');
    $data['petugas'] = $model->getById($id);

    if (!$data['petugas']) {
        $_SESSION['error'] = "Data tidak ditemukan.";
        header('Location: index.php?url=admin/petugas');
        exit;
    }

    $this->view('admin/petugas/edit', $data);
}

public function update_petugas($id)
{
    $this->checkAdmin();

    $nama    = $_POST['nama'] ?? '';
    $jabatan = $_POST['jabatan'] ?? '';
    $no_hp   = $_POST['no_hp'] ?? '';

    $model = $this->model('PetugasModel');

    $model->update([
        'id'      => $id,
        'nama'    => $nama,
        'jabatan' => $jabatan,
        'no_hp'   => $no_hp
    ]);

    $_SESSION['success'] = "Data petugas berhasil diupdate.";
    header('Location: index.php?url=admin/petugas');
    exit;
}

public function hapus_petugas($id)
{
    $this->checkAdmin();

    $model = $this->model('PetugasModel');

    if (!$model->delete($id)) {
        $_SESSION['error'] = "Gagal menghapus data.";
    } else {
        $_SESSION['success'] = "Petugas berhasil dihapus.";
    }

    header('Location: index.php?url=admin/petugas');
    exit;
}

}