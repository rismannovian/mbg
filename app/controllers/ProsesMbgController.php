<?php

class ProsesMbgController extends Controller
{
    // ================= HELPER =================
    private function checkLogin()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        if (!isset($_SESSION['user'])) {
            header('Location: index.php?url=auth/login');
            exit;
        }
    }

    // ================= LIST DATA PETUGAS =================
    public function index()
    {
        $this->checkLogin();

        $model = $this->model('ProsesMbgModel');
        $data['proses'] = $model->getAll();

        $this->view('petugas/proses_mbg/index', $data);
    }

    // ================= SISWA PESAN MBG =================
    public function pesan()
    {
        $this->checkLogin();

        if ($_SESSION['user']['role'] !== 'siswa') {
            header('Location: index.php');
            exit;
        }

        $siswa_id = $_SESSION['user']['siswa_id'];
        $siswaModel = $this->model('SiswaModel');
$siswa = $siswaModel->getById($siswa_id);
$kelas_id = $siswa['kelas_id'];

        $mbgModel = $this->model('MbgModel');
        $model    = $this->model('ProsesMbgModel');

        $mbg = $mbgModel->getAktifHariIni();

        // CEK SUDAH ADA YANG PESAN DI KELAS INI
if ($model->cekPesananKelas($mbg['id'], $kelas_id)) {
    $_SESSION['error'] = "Kelas Anda sudah melakukan pemesanan MBG hari ini.";
    header('Location: index.php?url=siswa/mbg');
    exit;
}

        if (!$mbg) {
            $_SESSION['error'] = "MBG hari ini belum tersedia.";
            header('Location: index.php?url=siswa/dashboard');
            exit;
        }

        if ($model->cekPesanan($mbg['id'], $siswa_id)) {
            $_SESSION['error'] = "Anda sudah melakukan pesanan hari ini.";
            header('Location: index.php?url=siswa/dashboard');
            exit;
        }

        // ambil dari input form
        $jml_pesan = isset($_POST['jml_pesan']) ? (int)$_POST['jml_pesan'] : 1;

        if ($jml_pesan <= 0) {
            $_SESSION['error'] = "Jumlah tidak valid.";
            header('Location: index.php?url=siswa/mbg');
            exit;
        }

        $model->insert([
            'mbg_id'    => $mbg['id'],
            'siswa_id'  => $siswa_id,
            'jml_pesan' => $jml_pesan,
            'status'    => 'pesan',
            'catatan'   => null
        ]);

        $_SESSION['success'] = "Pesanan MBG berhasil dikirim.";
        header('Location: index.php?url=siswa/mbg');
        exit;
    }

    // ================= APPROVE =================
    public function approve($id)
{
    $this->checkLogin();

    $model = $this->model('ProsesMbgModel');
    $data = $model->getById($id);

    // 🔥 ambil user login
    $user_id = $_SESSION['user']['id'];

    // 🔥 ambil data petugas
    $petugasModel = $this->model('PetugasModel');
    $petugas = $petugasModel->getByUserId($user_id);

    // 🔥 kirim ke model
    $model->updateApprove($id, $data['jml_pesan'], $petugas['id']);

    $_SESSION['success'] = "Pesanan disetujui.";
    header('Location: index.php?url=prosesmbg/index');
    exit;
}

    // ================= TOLAK =================
    public function tolak($id)
    {
        $this->checkLogin();

        $model = $this->model('ProsesMbgModel');
        $model->updateStatus($id, 'ditolak');

        $_SESSION['success'] = "Pesanan ditolak.";
        header('Location: index.php?url=prosesmbg/index');
        exit;
    }

    // ================= INPUT REALISASI (KEMBALI) =================
    public function kembali($id)
    {
        $this->checkLogin();

        $model = $this->model('ProsesMbgModel');

        $jumlah = isset($_POST['jml_kembali']) ? (int)$_POST['jml_kembali'] : 0;

        if ($jumlah < 0) {
            $_SESSION['error'] = "Jumlah tidak valid.";
            header('Location: index.php?url=prosesmbg/index');
            exit;
        }

        $model->updateKembali($id, $jumlah);

        $_SESSION['success'] = "Realisasi berhasil disimpan.";
        header('Location: index.php?url=prosesmbg/index');
        exit;
    }

    // ================= FINAL SELESAI =================
    public function selesai($id)
    {
        $this->checkLogin();

        $model = $this->model('ProsesMbgModel');
        $model->setSelesai($id);

        $_SESSION['success'] = "Transaksi diselesaikan.";
        header('Location: index.php?url=prosesmbg/index');
        exit;
    }

   public function proses($id)
{
    $this->checkLogin();

    $model = $this->model('ProsesMbgModel');

    // 🔥 ambil user login
    $user_id = $_SESSION['user']['id'];

    // 🔥 ambil data petugas
    $petugasModel = $this->model('PetugasModel');
    $petugas = $petugasModel->getByUserId($user_id);

    // 🔥 simpan petugas pengembalian
    $model->setDiproses($id, $petugas['id']);

    $_SESSION['success'] = "Pengembalian diproses.";
    header('Location: index.php?url=prosesmbg/index');
    exit;
}

public function kirim_kembali($id)
{
    $this->checkLogin();

    if ($_SESSION['user']['role'] !== 'siswa') {
        header('Location: index.php');
        exit;
    }

    $model = $this->model('ProsesMbgModel');

    // ambil data dulu
    $data = $model->getById($id);

    // otomatis: jml_kembali = jml_pesan
    $jumlah = $data['jml_pesan'];

    $model->updateKembali($id, $jumlah);

    $_SESSION['success'] = "Pengembalian berhasil dikirim.";
    header('Location: index.php?url=siswa/mbg');
    exit;
}

    // ================= HAPUS =================
    public function hapus($id)
    {
        $this->checkLogin();

        $model = $this->model('ProsesMbgModel');
        $model->delete($id);

        $_SESSION['success'] = "Data transaksi berhasil dihapus.";
        header('Location: index.php?url=prosesmbg/index');
        exit;
    }
}