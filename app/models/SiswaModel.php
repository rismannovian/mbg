<?php

class SiswaModel
{
    private $pdo;

    public function __construct()
    {
        require_once __DIR__ . '/../config/config.php';
        $this->pdo = getPDO();
    }


    public function getAll()
{
    $stmt = $this->pdo->query("
        SELECT siswa.*, kelas.nama_kelas 
        FROM siswa
        LEFT JOIN kelas ON siswa.kelas_id = kelas.id
        ORDER BY siswa.nama ASC
    ");

    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

   public function insertSiswa($data)
{
    // ✅ Validasi wajib
    if (empty($data['nis']) || empty($data['nama'])) {
        return false;
    }

    // ✅ Cek duplikat NIS
    $cek = $this->pdo->prepare("SELECT id FROM siswa WHERE nis = ?");
    $cek->execute([$data['nis']]);

    if ($cek->fetch()) {
        return false;
    }

    try {
        $stmt = $this->pdo->prepare("
            INSERT INTO siswa 
            (nis, nama, tahun_pelajaran, kelas_id)
            VALUES 
            (:nis, :nama, :tahun_pelajaran, :kelas_id)
        ");

        $stmt->execute([
            ':nis'              => $data['nis'],
            ':nama'             => $data['nama'],
            ':tahun_pelajaran'  => $data['tahun_pelajaran'] ?? null,
            ':kelas_id'         => $data['kelas_id'] ?? null
        ]);

        return $this->pdo->lastInsertId();

    } catch (PDOException $e) {
        // 🔥 debug sementara (boleh dihapus nanti)
        die($e->getMessage());
    }
}

    public function cekNis($nis)
    {
        $stmt = $this->pdo->prepare("SELECT id FROM siswa WHERE nis = ?");
        $stmt->execute([$nis]);
        return $stmt->fetch();
    }

    public function getById($id)
    {
        $stmt = $this->pdo->prepare("SELECT * FROM siswa WHERE id = :id");
        $stmt->execute([':id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

   public function updateSiswa($data)
{
    $stmt = $this->pdo->prepare("
        UPDATE siswa SET 
            nis = :nis,
            nama = :nama,
            tahun_pelajaran = :tahun_pelajaran,
            kelas_id = :kelas_id
        WHERE id = :id
    ");

    return $stmt->execute([
        ':nis'              => $data['nis'],
        ':nama'             => $data['nama'],
        ':tahun_pelajaran'  => $data['tahun_pelajaran'],
        ':kelas_id'         => $data['kelas_id'],
        ':id'               => $data['id']
    ]);
}

    public function delete($id)
    {
        $stmt = $this->pdo->prepare("DELETE FROM siswa WHERE id = ?");
        $stmt->execute([$id]);
    }

    public function deleteBySiswaId($siswa_id)
    {
        $stmt = $this->pdo->prepare("DELETE FROM users WHERE siswa_id = ?");
        $stmt->execute([$siswa_id]);
    }

    public function getBySiswaId($siswa_id)
    {
        $stmt = $this->pdo->prepare("
        SELECT * FROM skl 
        WHERE siswa_id = ?
        LIMIT 1
    ");

        $stmt->execute([$siswa_id]);

        return $stmt->fetch(PDO::FETCH_ASSOC) ?: null;
    }

    public function getAllWithKelas()
{
    $stmt = $this->pdo->query("
        SELECT 
            siswa.*, 
            kelas.nama_kelas 
        FROM siswa
        LEFT JOIN kelas ON siswa.kelas_id = kelas.id
        ORDER BY siswa.nama ASC
    ");

    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

public function getPesananKelas($mbg_id, $kelas_id)
{
    $stmt = $this->pdo->prepare("
        SELECT p.*, s.nama 
        FROM proses_mbg_siswa p
        JOIN siswa s ON p.siswa_id = s.id
        WHERE p.mbg_id = ? AND s.kelas_id = ?
        LIMIT 1
    ");

    $stmt->execute([$mbg_id, $kelas_id]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

public function countByKelas($kelas_id)
{
    $stmt = $this->pdo->prepare("
        SELECT COUNT(*) as total
        FROM siswa
        WHERE kelas_id = ?
    ");

    $stmt->execute([$kelas_id]);
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    return $result['total'];
}
}
