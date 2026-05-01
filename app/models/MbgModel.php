<?php

class MbgModel
{
    private $pdo;

    public function __construct()
    {
        require_once __DIR__ . '/../config/config.php';
        $this->pdo = getPDO();
    }

    // ================= AMBIL SEMUA DATA =================
    public function getAll()
    {
        $stmt = $this->pdo->query("
            SELECT 
                mbg.*,
                petugas.nama
            FROM mbg
            LEFT JOIN petugas ON mbg.petugas_id = petugas.id
            ORDER BY mbg.tanggal DESC
        ");

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // ================= AMBIL SATU DATA =================
   public function getById($id)
    {
        $stmt = $this->pdo->prepare("
            SELECT 
                m.*,
                p.nama
            FROM mbg m
            LEFT JOIN petugas p ON m.petugas_id = p.id
            WHERE m.id = ?
            LIMIT 1
        ");

        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // ================= CEK TANGGAL =================
    public function cekTanggal($tanggal)
    {
        $stmt = $this->pdo->prepare("
            SELECT id FROM mbg
            WHERE tanggal = ?
            LIMIT 1
        ");

        $stmt->execute([$tanggal]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // ================= SIMPAN =================
    public function insert($data)
    {
        $stmt = $this->pdo->prepare("
            INSERT INTO mbg
            (
                petugas_id,
                tanggal,
                jml_mbg,
                foto_datang,
                foto_laporan,
                status
            )
            VALUES
            (
                :petugas_id,
                :tanggal,
                :jml_mbg,
                :foto_datang,
                :foto_laporan,
                :status
            )
        ");

        return $stmt->execute([
            ':petugas_id'   => $data['petugas_id'],
            ':tanggal'      => $data['tanggal'],
            ':jml_mbg'      => $data['jml_mbg'],
            ':foto_datang'  => $data['foto_datang'],
            ':foto_laporan' => $data['foto_laporan'],
            ':status'       => $data['status']
        ]);
    }

    // ================= UPDATE =================
    public function update($data)
    {
        $stmt = $this->pdo->prepare("
            UPDATE mbg SET
                petugas_id   = :petugas_id,
                tanggal      = :tanggal,
                jml_mbg      = :jml_mbg,
                foto_datang  = :foto_datang,
                foto_laporan = :foto_laporan,
                status       = :status,
                updated_at   = NOW()
            WHERE id = :id
        ");

        return $stmt->execute([
            ':petugas_id'   => $data['petugas_id'],
            ':tanggal'      => $data['tanggal'],
            ':jml_mbg'      => $data['jml_mbg'],
            ':foto_datang'  => $data['foto_datang'],
            ':foto_laporan' => $data['foto_laporan'],
            ':status'       => $data['status'],
            ':id'           => $data['id']
        ]);
    }

    // ================= HAPUS =================
    public function delete($id)
    {
        $stmt = $this->pdo->prepare("
            DELETE FROM mbg
            WHERE id = ?
        ");

        return $stmt->execute([$id]);
    }

    // ================= MBG AKTIF HARI INI =================
public function getAktifHariIni()
{
    $stmt = $this->pdo->prepare("
        SELECT *
        FROM mbg
        WHERE tanggal = CURDATE()
        AND status = 'aktif'
        LIMIT 1
    ");

    $stmt->execute();
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

public function getRekap($mbg_id)
{
    $stmt = $this->pdo->prepare("
        SELECT
            COUNT(*) AS jml_siswa,

            COALESCE(SUM(jml_pesan),0) AS total_ambil,

            COALESCE(SUM(
                CASE 
                    WHEN status IN ('kembalikan','selesai')
                    THEN jml_kembali
                    ELSE 0
                END
            ),0) AS total_kembali

        FROM proses_mbg_siswa
        WHERE mbg_id = ?
    ");

    $stmt->execute([$mbg_id]);

    return $stmt->fetch(PDO::FETCH_ASSOC);
}

}