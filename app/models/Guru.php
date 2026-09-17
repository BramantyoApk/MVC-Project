<?php
require_once __DIR__ . '/../../config/Database.php';

class Guru {
    private PDO $db;

    public function __construct() {
        $this->db = Database::getConnection();
    }

    public function getAll(): array {
        $stmt = $this->db->query("SELECT * FROM guru ORDER BY nama_guru ASC");
        return $stmt->fetchAll();
    }

    public function getById(int $id): ?array {
        $stmt = $this->db->prepare("SELECT * FROM guru WHERE id_guru = :id LIMIT 1");
        $stmt->execute([':id' => $id]);
        $result = $stmt->fetch();
        return $result ?: null;
    }

    public function findOrCreateByName(string $nama, string $mapel = ''): int {
        $nama = trim($nama);
        if (empty($nama)) {
            return 1;
        }

        $stmt = $this->db->prepare("SELECT id_guru FROM guru WHERE nama_guru = :nama LIMIT 1");
        $stmt->execute([':nama' => $nama]);
        $id = $stmt->fetchColumn();

        if ($id) {
            return (int) $id;
        }

        $stmtInsert = $this->db->prepare("INSERT INTO guru (nip, nama_guru, mata_pelajaran) VALUES (:nip, :nama, :mapel)");
        $stmtInsert->execute([
            ':nip'   => '19' . rand(10000000, 99999999),
            ':nama'  => $nama,
            ':mapel' => $mapel ?: 'Mata Pelajaran'
        ]);

        return (int) $this->db->lastInsertId();
    }

    public function count(): int {
        return (int) $this->db->query("SELECT COUNT(*) FROM guru")->fetchColumn();
    }
}
