<?php

class SiswaController extends Controller
{
    private $siswaModel;

    public function __construct()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'siswa') {
            header('Location: index.php?url=auth/index');
            exit;
        }

        $this->siswaModel = $this->model('SiswaModel');
    }

    // ================= DEFAULT =================
    public function index()
    {
        header('Location: index.php?url=siswa/dashboard');
        exit;
    }

    // ================= DASHBOARD =================
public function dashboard()
{
    $siswa_id = $_SESSION['user']['siswa_id'];
    $siswa = $this->siswaModel->getById($siswa_id);

    // 🔥 ambil MBG hari ini
    $mbgModel = $this->model('MbgModel');
    $mbg = $mbgModel->getAktifHariIni();

    $this->view('siswa/dashboard', [
        'siswa' => $siswa,
        'mbg'   => $mbg
    ]);
}

   // ================= MBG HARI INI =================
    public function mbg()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $siswa_id = $_SESSION['user']['siswa_id'];

        $mbgModel    = $this->model('MbgModel');
        $prosesModel = $this->model('ProsesMbgModel');
        $siswaModel  = $this->model('SiswaModel');

        // ambil data siswa (untuk kelas)
        $siswa = $siswaModel->getById($siswa_id);
        $kelas_id = $siswa['kelas_id'];

        // 🔥 CEK DULU: ADA PROSES LAMA BELUM SELESAI?
        $pesanan_kelas = $prosesModel->getPesananBelumSelesaiByKelas($kelas_id);

        $pesanan = null;
        $mbg = null;

        if ($pesanan_kelas) {

            // ✅ PRIORITAS: tampilkan proses lama
            $mbg = [
                'tanggal' => $pesanan_kelas['tanggal'],
                'status'  => 'aktif',
                'jml_mbg' => $pesanan_kelas['jml_mbg'] // ✅ tambahkan ini
            ];

            // cek apakah siswa ini yang pesan
            if ($pesanan_kelas['siswa_id'] == $siswa_id) {
                $pesanan = $pesanan_kelas;
            }

        } else {

            // ✅ kalau tidak ada → baru ambil hari ini
            $mbg = $mbgModel->getAktifHariIni();

            if ($mbg) {
                $pesanan = $prosesModel->getPesananHariIni($mbg['id'], $siswa_id);
                $pesanan_kelas = $prosesModel->getPesananKelas($mbg['id'], $kelas_id);
            }
        }

        $this->view('siswa/mbg/index', [
            'mbg'            => $mbg,
            'pesanan'        => $pesanan,
            'pesanan_kelas'  => $pesanan_kelas
        ]);
    }

    // ================= RIWAYAT MBG =================
    public function riwayat_mbg()
    {
        $siswa_id = $_SESSION['user']['siswa_id'];

        $prosesModel = $this->model('ProsesMbgModel');

        $riwayat = $prosesModel->getBySiswa($siswa_id);

        $this->view('siswa/mbg/riwayat', [
            'riwayat' => $riwayat
        ]);
    }
}