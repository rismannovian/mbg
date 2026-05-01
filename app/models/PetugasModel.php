<?php

class PetugasModel
{
    private $pdo;

    public function __construct()
    {
        require_once __DIR__ . '/../config/config.php';
        $this->pdo = getPDO();
    }

    // ================= GET ALL =================
    public function getAll()
    {
        $stmt = $this->pdo->query("
            SELECT p.*, u.username 
            FROM petugas p
            JOIN users u ON p.user_id = u.id
            ORDER BY p.nama ASC
        ");

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // ================= GET BY ID =================
    public function getById($id)
    {
        $stmt = $this->pdo->prepare("
            SELECT p.*, u.username 
            FROM petugas p
            JOIN users u ON p.user_id = u.id
            WHERE p.id = :id
        ");

        $stmt->execute([':id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // ================= GET BY USER ID =================
public function getByUserId($user_id)
{
    $stmt = $this->pdo->prepare("
        SELECT p.*, u.username 
        FROM petugas p
        JOIN users u ON p.user_id = u.id
        WHERE p.user_id = :user_id
        LIMIT 1
    ");

    $stmt->execute([':user_id' => $user_id]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

    // ================= INSERT =================
    public function insert($data)
    {
        // ✅ Validasi
        if (empty($data['user_id']) || empty($data['nama'])) {
            return false;
        }

        try {
            $stmt = $this->pdo->prepare("
                INSERT INTO petugas 
                (user_id, nama, jabatan, no_hp)
                VALUES 
                (:user_id, :nama, :jabatan, :no_hp)
            ");

            $stmt->execute([
                ':user_id' => $data['user_id'],
                ':nama'    => $data['nama'],
                ':jabatan' => $data['jabatan'] ?? null,
                ':no_hp'   => $data['no_hp'] ?? null
            ]);

            return $this->pdo->lastInsertId();
        } catch (PDOException $e) {
            return false;
        }
    }

    // ================= UPDATE =================
    public function update($data)
    {
        if (empty($data['id']) || empty($data['nama'])) {
            return false;
        }

        $stmt = $this->pdo->prepare("
            UPDATE petugas SET
                nama = :nama,
                jabatan = :jabatan,
                no_hp = :no_hp
            WHERE id = :id
        ");

        return $stmt->execute([
            ':nama'    => $data['nama'],
            ':jabatan' => $data['jabatan'] ?? null,
            ':no_hp'   => $data['no_hp'] ?? null,
            ':id'      => $data['id']
        ]);
    }

    // ================= DELETE =================
    public function delete($id)
    {
        // Ambil user_id dulu (biar sekalian hapus akun login)
        $stmt = $this->pdo->prepare("SELECT user_id FROM petugas WHERE id = ?");
        $stmt->execute([$id]);
        $petugas = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$petugas) return false;

        try {
            // 1. hapus petugas
            $this->pdo->prepare("DELETE FROM petugas WHERE id = ?")->execute([$id]);

            // 2. hapus user (cascade juga bisa, tapi ini lebih eksplisit)
            $this->pdo->prepare("DELETE FROM users WHERE id = ?")->execute([$petugas['user_id']]);

            return true;
        } catch (PDOException $e) {
            return false;
        }
    }

    // ================= CEK USER SUDAH DIPAKAI =================
    public function cekUserId($user_id)
    {
        $stmt = $this->pdo->prepare("SELECT id FROM petugas WHERE user_id = ?");
        $stmt->execute([$user_id]);
        return $stmt->fetch();
    }
}