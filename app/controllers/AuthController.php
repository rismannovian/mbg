<?php
class AuthController extends Controller
{
    public function index()
    {
        $this->view('pages/login');
    }

    public function login()
    {
        require_once 'app/config/config.php';
        $pdo = getPDO(); // ✅ Ambil koneksi DB

        session_start();

        $username = $_POST['username'];
        $password = $_POST['password'];

        $stmt = $pdo->prepare("SELECT * FROM users WHERE username = ?");
        $stmt->execute([$username]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($password, $user['password'])) {
            $_SESSION['user'] = [
                'id'       => $user['id'],         // digunakan untuk input_by
                'username' => $user['username'],
                'nama'     => $user['nama'],
                'role'     => $user['role'],
                'siswa_id' => $user['siswa_id']    // digunakan oleh siswa
            ];

            // ✅ Tambahkan data petugas jika role petugas
if ($user['role'] === 'petugas') {
    require_once 'app/models/PetugasModel.php';
    $petugasModel = new PetugasModel();
    $petugas = $petugasModel->getByUserId($user['id']);

    if ($petugas) {
        $_SESSION['user']['id_petugas'] = $petugas['id'];
        $_SESSION['user']['nama_petugas'] = $petugas['nama'];
        $_SESSION['user']['jabatan'] = $petugas['jabatan'];
    } else {
        header('Location: index.php?url=auth/logout');
        exit;
    }
}

            // 🔁 Redirect ke halaman dashboard sesuai role
            switch ($user['role']) {
                case 'admin':
                    header('Location: index.php?url=admin/dashboard');
                    break;
                case 'siswa':
                    header('Location: index.php?url=siswa/dashboard');
                    break;
                case 'petugas':
                    header('Location: index.php?url=petugas/dashboard');
                     break;    
                default:
                    header('Location: index.php?url=auth/logout');
                    break;
            }
        } else {
            // ❌ Gagal login
            header('Location: index.php?url=auth/index&error=Username atau password salah!');
        }
    }

    public function logout()
    {
        session_start();
        session_destroy();
        header('Location: index.php');
    }
}
