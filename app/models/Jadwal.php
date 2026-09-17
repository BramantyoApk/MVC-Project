<?php
require_once __DIR__ . '/../../config/Database.php';

class Jadwal {
    private PDO $db;

    public function __construct() {
        $this->db = Database::getConnection();
    }

    public function getActive(): ?array {
        $stmt = $this->db->query("
            SELECT j.*, g.nama_guru, g.nip
            FROM jadwal j
            LEFT JOIN guru g ON j.id_guru = g.id_guru
            ORDER BY j.id_jadwal ASC
            LIMIT 1
        ");
        $result = $stmt->fetch();
        return $result ?: null;
    }

    public function getById(int $id): ?array {
        $stmt = $this->db->prepare("
            SELECT j.*, g.nama_guru, g.nip
            FROM jadwal j
            LEFT JOIN guru g ON j.id_guru = g.id_guru
            WHERE j.id_jadwal = :id
            LIMIT 1
        ");
        $stmt->execute([':id' => $id]);
        $result = $stmt->fetch();
        return $result ?: null;
    }

    public function update(int $id, ?int $id_guru, string $mata_pelajaran, string $kelas, string $bulan, string $tahun = '2026'): bool {
        $sql = "UPDATE jadwal 
                SET id_guru = :id_guru, 
                    mata_pelajaran = :mata_pelajaran, 
                    kelas = :kelas, 
                    bulan = :bulan, 
                    tahun = :tahun 
                WHERE id_jadwal = :id";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            ':id_guru'        => $id_guru,
            ':mata_pelajaran' => $mata_pelajaran,
            ':kelas'          => $kelas,
            ':bulan'          => $bulan,
            ':tahun'          => $tahun,
            ':id'             => $id
        ]);
    }

    public function getAll(): array {
        $stmt = $this->db->query("
            SELECT j.*, g.nama_guru 
            FROM jadwal j 
            LEFT JOIN guru g ON j.id_guru = g.id_guru 
            ORDER BY j.id_jadwal ASC
        ");
        return $stmt->fetchAll();
    }
}
