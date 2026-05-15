<?php

class ProsesMbgModel
{
    private $pdo;

    public function __construct()
    {
        require_once __DIR__ . '/../config/config.php';
        $this->pdo = getPDO();
    }

    public function getById($id)
{
    $stmt = $this->pdo->prepare("
        SELECT * FROM proses_mbg_siswa WHERE id = ?
    ");
    $stmt->execute([$id]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

   // ================= AMBIL SEMUA DATA =================
        public function getAll()
        {
            $stmt = $this->pdo->query("
                SELECT 
                    p.*,
                    s.nis,
                    s.nama,
                    k.nama_kelas,
                    m.tanggal,
                    pt1.nama AS petugas_pengambilan,
                    pt2.nama AS petugas_pengembalian
                    
                FROM proses_mbg_siswa p
                LEFT JOIN siswa s ON p.siswa_id = s.id
                LEFT JOIN kelas k ON s.kelas_id = k.id
                LEFT JOIN mbg m ON p.mbg_id = m.id
                LEFT JOIN petugas pt1 ON p.petugas_pengambilan_id = pt1.id
                LEFT JOIN petugas pt2 ON p.petugas_pengembalian_id = pt2.id

                WHERE m.status = 'aktif'
                
                ORDER BY p.created_at ASC
            ");

            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }

    public function getAllAdmin()
        {
            $stmt = $this->pdo->query("
                SELECT 
                    p.*,
                    s.nis,
                    s.nama,
                    k.nama_kelas,
                    m.tanggal,
                    m.status AS status_mbg,
                    pt1.nama AS petugas_pengambilan,
                    pt2.nama AS petugas_pengembalian

                FROM proses_mbg_siswa p
                LEFT JOIN siswa s ON p.siswa_id = s.id
                LEFT JOIN kelas k ON s.kelas_id = k.id
                LEFT JOIN mbg m ON p.mbg_id = m.id
                LEFT JOIN petugas pt1 ON p.petugas_pengambilan_id = pt1.id
                LEFT JOIN petugas pt2 ON p.petugas_pengembalian_id = pt2.id

                ORDER BY p.id DESC
            ");

            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }

    // ================= DATA BERDASARKAN SISWA =================
    public function getBySiswa($siswa_id)
    {
        $stmt = $this->pdo->prepare("
            SELECT 
                p.*,
                m.tanggal
            FROM proses_mbg_siswa p
            LEFT JOIN mbg m ON p.mbg_id = m.id
            WHERE p.siswa_id = ?
            ORDER BY p.id DESC
        ");

        $stmt->execute([$siswa_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // ================= DATA BERDASARKAN MBG =================
    public function getByMbg($mbg_id)
    {
        $stmt = $this->pdo->prepare("
            SELECT 
                p.*,
                s.nis,
                s.nama,
                k.nama_kelas
            FROM proses_mbg_siswa p
            LEFT JOIN siswa s ON p.siswa_id = s.id
            LEFT JOIN kelas k ON s.kelas_id = k.id
            WHERE p.mbg_id = ?
            ORDER BY s.nama ASC
        ");

        $stmt->execute([$mbg_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // ================= CEK SUDAH PESAN =================
    public function cekPesanan($mbg_id, $siswa_id)
    {
        $stmt = $this->pdo->prepare("
            SELECT id 
            FROM proses_mbg_siswa
            WHERE mbg_id = ? AND siswa_id = ?
            LIMIT 1
        ");

        $stmt->execute([$mbg_id, $siswa_id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // ================= AMBIL DETAIL PESANAN =================
    public function getPesananHariIni($mbg_id, $siswa_id)
    {
        $stmt = $this->pdo->prepare("
            SELECT *
            FROM proses_mbg_siswa
            WHERE mbg_id = ? AND siswa_id = ?
            LIMIT 1
        ");

        $stmt->execute([$mbg_id, $siswa_id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // ================= SIMPAN PESANAN =================
    public function insert($data)
    {
        $stmt = $this->pdo->prepare("
            INSERT INTO proses_mbg_siswa
            (
                mbg_id,
                siswa_id,
                jml_pesan,
                status,
                catatan
            )
            VALUES
            (
                :mbg_id,
                :siswa_id,
                :jml_pesan,
                :status,
                :catatan
            )
        ");

        return $stmt->execute([
            ':mbg_id'    => $data['mbg_id'],
            ':siswa_id'  => $data['siswa_id'],
            ':jml_pesan' => $data['jml_pesan'],
            ':status'    => $data['status'],
            ':catatan'   => $data['catatan']
        ]);
    }

    // ================= UPDATE STATUS =================
    public function updateStatus($id, $status)
    {
        $stmt = $this->pdo->prepare("
            UPDATE proses_mbg_siswa
            SET 
                status = ?,
                updated_at = NOW()
            WHERE id = ?
        ");

        return $stmt->execute([$status, $id]);
    }

    // ================= INPUT REALISASI (SISWA) =================
        public function updateKembali($id)
        {
            $stmt = $this->pdo->prepare("
                UPDATE proses_mbg_siswa
                SET 
                    status = 'kembalikan',
                    updated_at = NOW()
                WHERE id = ?
            ");

            return $stmt->execute([$id]);
        }

    // ================= APPROVE AKHIR (PETUGAS) =================
    public function setSelesai($id)
    {
        $stmt = $this->pdo->prepare("
            UPDATE proses_mbg_siswa
            SET 
                status = 'selesai',
                updated_at = NOW()
            WHERE id = ?
        ");

        return $stmt->execute([$id]);
    }

    public function updateApprove($id, $petugas_id)
    {
        $stmt = $this->pdo->prepare("
            UPDATE proses_mbg_siswa
            SET 
                status = 'disetujui',
                jml_kembali = 0,
                petugas_pengambilan_id = ?,
                updated_at = NOW()
            WHERE id = ?
        ");

        return $stmt->execute([
            $petugas_id,
            $id
        ]);
    }

public function cekPesananKelas($mbg_id, $kelas_id)
{
    $stmt = $this->pdo->prepare("
        SELECT p.id 
        FROM proses_mbg_siswa p
        JOIN siswa s ON p.siswa_id = s.id
        WHERE p.mbg_id = ? AND s.kelas_id = ?
        LIMIT 1
    ");

    $stmt->execute([$mbg_id, $kelas_id]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

public function getPesananKelas($mbg_id, $kelas_id)
{
    $stmt = $this->pdo->prepare("
        SELECT 
            p.*,
            s.nama
        FROM proses_mbg_siswa p
        JOIN siswa s ON p.siswa_id = s.id
        WHERE p.mbg_id = ? 
        AND s.kelas_id = ?
        LIMIT 1
    ");

    $stmt->execute([$mbg_id, $kelas_id]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}


public function setDiproses($id, $petugas_id)
{
    $stmt = $this->pdo->prepare("
        UPDATE proses_mbg_siswa
        SET 
            status = 'selesai',
            jml_kembali = jml_pesan,
            petugas_pengembalian_id = ?,
            updated_at = NOW()
        WHERE id = ?
    ");

    return $stmt->execute([$petugas_id, $id]);
}

public function getPesananBelumSelesaiByKelas($kelas_id)
{
    $stmt = $this->pdo->prepare("
        SELECT 
            p.*,
            s.nama,
            m.tanggal,
            m.jml_mbg   -- 🔥 tambahkan ini
        FROM proses_mbg_siswa p
        JOIN siswa s ON p.siswa_id = s.id
        JOIN mbg m ON p.mbg_id = m.id
        WHERE s.kelas_id = ?
        AND p.status != 'selesai'
        ORDER BY m.tanggal ASC
        LIMIT 1
    ");

    $stmt->execute([$kelas_id]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}


    // ================= HAPUS =================
    public function delete($id)
    {
        $stmt = $this->pdo->prepare("
            DELETE FROM proses_mbg_siswa
            WHERE id = ?
        ");

        return $stmt->execute([$id]);
    }
}