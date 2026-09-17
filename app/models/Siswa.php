<?php
require_once __DIR__ . '/../../config/Database.php';

class Siswa {
    private PDO $db;

    public function __construct() {
        $this->db = Database::getConnection();
    }

    public function getAll(?string $kelas = null): array {
        if ($kelas) {
            $stmt = $this->db->prepare("SELECT * FROM siswa WHERE kelas = :kelas ORDER BY nama_siswa ASC");
            $stmt->execute([':kelas' => $kelas]);
            return $stmt->fetchAll();
        }
        $stmt = $this->db->query("SELECT * FROM siswa ORDER BY id_siswa ASC");
        return $stmt->fetchAll();
    }

    public function getById(int $id): ?array {
        $stmt = $this->db->prepare("SELECT * FROM siswa WHERE id_siswa = :id LIMIT 1");
        $stmt->execute([':id' => $id]);
        $result = $stmt->fetch();
        return $result ?: null;
    }

    public function count(?string $kelas = null): int {
        if ($kelas) {
            $stmt = $this->db->prepare("SELECT COUNT(*) FROM siswa WHERE kelas = :kelas");
            $stmt->execute([':kelas' => $kelas]);
            return (int) $stmt->fetchColumn();
        }
        return (int) $this->db->query("SELECT COUNT(*) FROM siswa")->fetchColumn();
    }
}
