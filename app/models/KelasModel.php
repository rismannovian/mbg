<?php

class KelasModel
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
            SELECT * FROM kelas
            ORDER BY nama_kelas ASC
        ");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getById($id)
    {
        $stmt = $this->pdo->prepare("
            SELECT * FROM kelas WHERE id = :id
        ");
        $stmt->execute([':id' => $id]);

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

   public function insert($data)
{
    // ✅ Validasi
    if (empty($data['nama_kelas'])) {
        return false;
    }

    // ✅ Cek duplikat (berdasarkan nama kelas saja)
    $cek = $this->pdo->prepare("
        SELECT id FROM kelas 
        WHERE nama_kelas = ?
    ");
    $cek->execute([$data['nama_kelas']]);

    if ($cek->fetch()) {
        return false;
    }

    try {
        $stmt = $this->pdo->prepare("
            INSERT INTO kelas (nama_kelas)
            VALUES (:nama_kelas)
        ");

        $stmt->execute([
            ':nama_kelas' => $data['nama_kelas']
        ]);

        return $this->pdo->lastInsertId();

    } catch (PDOException $e) {
        return false;
    }
}

public function update($data)
{
    $stmt = $this->pdo->prepare("
        UPDATE kelas SET
            nama_kelas = :nama_kelas
        WHERE id = :id
    ");

    return $stmt->execute([
        ':nama_kelas' => $data['nama_kelas'],
        ':id'         => $data['id']
    ]);
}

    public function delete($id)
    {
        $stmt = $this->pdo->prepare("
            DELETE FROM kelas WHERE id = ?
        ");
        return $stmt->execute([$id]);
    }

    // 🔥 Tambahan penting untuk import Excel
    public function findByNama($nama_kelas)
    {
        $stmt = $this->pdo->prepare("
            SELECT * FROM kelas WHERE nama_kelas = ?
        ");
        $stmt->execute([$nama_kelas]);

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}