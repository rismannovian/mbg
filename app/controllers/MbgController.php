<?php

class MbgController extends Controller
{
    // ================= HELPER ROTASI =================
    private function fixOrientation($image, $source)
    {
        if (!function_exists('exif_read_data')) return $image;

        $exif = @exif_read_data($source);
        if (!$exif || !isset($exif['Orientation'])) return $image;

        switch ($exif['Orientation']) {
            case 3:
                return imagerotate($image, 180, 0);
            case 6:
                return imagerotate($image, -90, 0);
            case 8:
                return imagerotate($image, 90, 0);
        }

        return $image;
    }

    // ================= HELPER RESIZE + COMPRESS =================
    private function resizeCompress($source, $destination, $maxSize = 800, $quality = 70)
    {
        $info = getimagesize($source);
        if (!$info) return false;

        $mime = $info['mime'];

        if ($mime == 'image/jpeg') {
            $image = imagecreatefromjpeg($source);
        } elseif ($mime == 'image/png') {
            $image = imagecreatefrompng($source);
        } elseif ($mime == 'image/gif') {
            $image = imagecreatefromgif($source);
        } else {
            return false;
        }

        // 🔥 Fix rotasi dari HP
        $image = $this->fixOrientation($image, $source);

        $width  = imagesx($image);
        $height = imagesy($image);

        // Auto resize sesuai orientasi
        if ($width > $height) {
            $newWidth  = $maxSize;
            $newHeight = ($height / $width) * $maxSize;
        } else {
            $newHeight = $maxSize;
            $newWidth  = ($width / $height) * $maxSize;
        }

        $newImage = imagecreatetruecolor($newWidth, $newHeight);

        imagecopyresampled($newImage, $image, 0, 0, 0, 0, $newWidth, $newHeight, $width, $height);

        imagejpeg($newImage, $destination, $quality);

        return true;
    }

    // ================= CHECK LOGIN =================
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

    // ================= LIST =================
    public function index()
    {
        $this->checkLogin();

        $model = $this->model('MbgModel');
        $data['mbg'] = $model->getAll();

        $this->view('petugas/mbg/index', $data);
    }

    // ================= TAMBAH =================
    public function tambah()
    {
        $this->checkLogin();

        $petugas = $this->model('PetugasModel');
        $data['petugas'] = $petugas->getAll();

        $this->view('petugas/mbg/tambah', $data);
    }

    // ================= SIMPAN =================
    public function simpan()
    {
        $this->checkLogin();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $model = $this->model('MbgModel');

            $tanggal    = trim($_POST['tanggal'] ?? '');
            $petugas_id = trim($_POST['petugas_id'] ?? '');
            $jml_mbg    = trim($_POST['jml_mbg'] ?? '');

            if (empty($tanggal) || empty($petugas_id) || empty($jml_mbg)) {
                $_SESSION['error'] = "Semua field wajib diisi.";
                header('Location: index.php?url=mbg/tambah');
                exit;
            }

            if ($model->cekTanggal($tanggal)) {
                $_SESSION['error'] = "Data tanggal sudah ada.";
                header('Location: index.php?url=mbg/tambah');
                exit;
            }

            // FOTO DATANG
            $foto_datang = null;
            if (!empty($_FILES['foto_datang']['name'])) {
                $tmp  = $_FILES['foto_datang']['tmp_name'];
                $type = mime_content_type($tmp);

                if (!in_array($type, ['image/jpeg', 'image/png', 'image/gif'])) {
                    $_SESSION['error'] = "Format foto datang tidak valid.";
                    header('Location: index.php?url=mbg/tambah');
                    exit;
                }

                $namaFile = time() . '_datang.jpg';
                $path = 'assets/mbg/' . $namaFile;

                $this->resizeCompress($tmp, $path);
                $foto_datang = $namaFile;
            }

            // FOTO LAPORAN
            $foto_laporan = null;
            if (!empty($_FILES['foto_laporan']['name'])) {
                $tmp2  = $_FILES['foto_laporan']['tmp_name'];
                $type2 = mime_content_type($tmp2);

                if (!in_array($type2, ['image/jpeg', 'image/png', 'image/gif'])) {
                    $_SESSION['error'] = "Format foto laporan tidak valid.";
                    header('Location: index.php?url=mbg/tambah');
                    exit;
                }

                $namaFile2 = time() . '_laporan.jpg';
                $path2 = 'assets/mbg/' . $namaFile2;

                $this->resizeCompress($tmp2, $path2);
                $foto_laporan = $namaFile2;
            }

            $model->insert([
                'petugas_id'   => $petugas_id,
                'tanggal'      => $tanggal,
                'jml_mbg'      => $jml_mbg,
                'foto_datang'  => $foto_datang,
                'foto_laporan' => $foto_laporan,
                'status'       => 'aktif'
            ]);

            $_SESSION['success'] = "Data MBG berhasil ditambahkan.";
            header('Location: index.php?url=mbg/index');
            exit;
        }
    }

    // ================= EDIT =================
    public function edit($id)
    {
        $this->checkLogin();

        $model   = $this->model('MbgModel');
        $petugas = $this->model('PetugasModel');

        $data['row'] = $model->getById($id);
        $data['petugas'] = $petugas->getAll();

        $this->view('petugas/mbg/edit', $data);
    }

    // ================= UPDATE =================
    public function update()
    {
        $this->checkLogin();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $model = $this->model('MbgModel');

            // FOTO DATANG
            $foto_datang = $_POST['foto_lama'] ?? null;

            if (!empty($_FILES['foto_datang']['name'])) {

                $tmp  = $_FILES['foto_datang']['tmp_name'];
                $type = mime_content_type($tmp);

                if (!in_array($type, ['image/jpeg', 'image/png', 'image/gif'])) {
                    $_SESSION['error'] = "Format foto datang tidak valid.";
                    header('Location: index.php?url=mbg/edit&id=' . $_POST['id']);
                    exit;
                }

                if ($foto_datang && file_exists('assets/mbg/' . $foto_datang)) {
                    unlink('assets/mbg/' . $foto_datang);
                }

                $namaFile = time() . '_datang.jpg';
                $path = 'assets/mbg/' . $namaFile;

                $this->resizeCompress($tmp, $path);
                $foto_datang = $namaFile;
            }

            // FOTO LAPORAN
            $foto_laporan = $_POST['foto_laporan_lama'] ?? null;

            if (!empty($_FILES['foto_laporan']['name'])) {

                $tmp2  = $_FILES['foto_laporan']['tmp_name'];
                $type2 = mime_content_type($tmp2);

                if (!in_array($type2, ['image/jpeg', 'image/png', 'image/gif'])) {
                    $_SESSION['error'] = "Format foto laporan tidak valid.";
                    header('Location: index.php?url=mbg/edit&id=' . $_POST['id']);
                    exit;
                }

                if ($foto_laporan && file_exists('assets/mbg/' . $foto_laporan)) {
                    unlink('assets/mbg/' . $foto_laporan);
                }

                $namaFile2 = time() . '_laporan.jpg';
                $path2 = 'assets/mbg/' . $namaFile2;

                $this->resizeCompress($tmp2, $path2);
                $foto_laporan = $namaFile2;
            }

            $status = $_POST['status'] ?? 'aktif';
            $allowed = ['aktif', 'ditutup', 'selesai'];
            if (!in_array($status, $allowed)) {
                $status = 'aktif';
            }

            $model->update([
                'id'            => $_POST['id'],
                'petugas_id'    => $_POST['petugas_id'],
                'tanggal'       => $_POST['tanggal'],
                'jml_mbg'       => $_POST['jml_mbg'],
                'foto_datang'   => $foto_datang,
                'foto_laporan'  => $foto_laporan,
                'status'        => $status
            ]);

            $_SESSION['success'] = "Data MBG berhasil diupdate.";
            header('Location: index.php?url=mbg/index');
            exit;
        }
    }

       public function detail($id)
        {
            $this->checkLogin();

            $model = $this->model('MbgModel');

            $data['mbg']   = $model->getById($id);
            $data['rekap'] = $model->getRekap($id);

            // Hanya menghitung Belum Kembali jika status sudah Disetujui atau Diproses
            if ($data['mbg']['status'] !== 'disetujui' && $data['mbg']['status'] !== 'diproses') {
                $data['rekap']['belum_kembali'] = 0; // Kosongkan jika belum disetujui atau diproses
            } else {
                // Lakukan perhitungan Belum Kembali jika status sudah Disetujui atau Diproses
                $belum_kembali = $data['rekap']['total_ambil'] - $data['rekap']['total_kembali'];
                $data['rekap']['belum_kembali'] = max(0, $belum_kembali);
            }

            if (!$data['mbg']) {
                header('Location: index.php?url=mbg');
                exit;
            }

            $this->view('petugas/mbg/detail', $data);
        }

    // ================= HAPUS =================
    public function hapus($id)
    {
        $this->checkLogin();

        $model = $this->model('MbgModel');
        $row = $model->getById($id);

        // hapus file
        if ($row) {
            if (!empty($row['foto_datang']) && file_exists('assets/mbg/' . $row['foto_datang'])) {
                unlink('assets/mbg/' . $row['foto_datang']);
            }
            if (!empty($row['foto_laporan']) && file_exists('assets/mbg/' . $row['foto_laporan'])) {
                unlink('assets/mbg/' . $row['foto_laporan']);
            }
        }

        $model->delete($id);

        $_SESSION['success'] = "Data MBG berhasil dihapus.";
        header('Location: index.php?url=mbg/index');
        exit;
    }
}