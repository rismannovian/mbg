<?php

// app/models/UserModel.php
class UserModel {
    private $pdo;

    public function __construct() {
        require_once __DIR__ . '/../config/config.php';
        $this->pdo = getPDO();
    }

    public function getAll() {
        $stmt = $this->pdo->query("SELECT * FROM users ORDER BY role ASC, nama ASC");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function findByUsername($username) {
    $stmt = $this->pdo->prepare("SELECT * FROM users WHERE username = ?");
    $stmt->execute([$username]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
    }

   public function insert($data) {
    try {
        // 1. Cek apakah username sudah digunakan
        $cek = $this->pdo->prepare("SELECT COUNT(*) FROM users WHERE username = ?");
        $cek->execute([$data['username']]);
        if ($cek->fetchColumn() > 0) {
            return false; // Username sudah ada
        }

        // 2. Susun field dan value
        $fields = ['username', 'password', 'nama', 'role', 'created_at'];
        $values = [$data['username'], $data['password'], $data['nama'], $data['role'], date('Y-m-d H:i:s')];

        if (!empty($data['siswa_id'])) {
            $fields[] = 'siswa_id';
            $values[] = $data['siswa_id'];
        }

        // 3. Eksekusi query
        $sql = "INSERT INTO users (" . implode(', ', $fields) . ") VALUES (" . rtrim(str_repeat('?, ', count($fields)), ', ') . ")";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($values);

        // Kembalikan ID user yang baru dibuat
        return $this->pdo->lastInsertId();

    } catch (PDOException $e) {
        die("Gagal insert user (debug): " . $e->getMessage());
    }
}




    public function resetPassword($id, $passwordBaru) {
    $stmt = $this->pdo->prepare("UPDATE users SET password = ? WHERE id = ?");
    $stmt->execute([$passwordBaru, $id]);
    }

    public function delete($id) {
        $stmt = $this->pdo->prepare("DELETE FROM users WHERE id = ?");
        $stmt->execute([$id]);
    }



    public function deleteBySiswaId($siswa_id)
    {
        $stmt = $this->pdo->prepare("DELETE FROM users WHERE siswa_id = ?");
        $stmt->execute([$siswa_id]);
    }

    public function deleteByUsername($nip) {
    $stmt = $this->pdo->prepare("DELETE FROM users WHERE username = ?");
    $stmt->execute([$nip]);
}

public function updateByUsername($username, $data)
{
    $sql = "UPDATE users SET nama = :nama WHERE username = :username";
    $params = [
        ':nama' => $data['nama'],
        ':username' => $username
    ];

    // Jika ingin update password juga:
    if (isset($data['password'])) {
        $sql = "UPDATE users SET nama = :nama, password = :password WHERE username = :username";
        $params[':password'] = $data['password'];
    }

    $stmt = $this->pdo->prepare($sql);
    $stmt->execute($params);
}


//di session guru
public function getById($id)
{
    $stmt = $this->pdo->prepare("SELECT * FROM users WHERE id = ?");
    $stmt->execute([$id]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

public function updatePassword($id, $password)
{
    $stmt = $this->pdo->prepare("UPDATE users SET password = :password WHERE id = :id");
    $stmt->execute([
        ':password' => $password,
        ':id' => $id
    ]);
}



    





}

