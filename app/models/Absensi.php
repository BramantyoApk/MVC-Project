<?php
require_once __DIR__ . '/../../config/Database.php';

class Absensi {
    private PDO $db;

    public function __construct() {
        $this->db = Database::getConnection();
    }

    public function getMatrixByJadwal(int $id_jadwal): array {
        $stmt = $this->db->prepare("
            SELECT id_siswa, tanggal, status 
            FROM absensi 
            WHERE id_jadwal = :id_jadwal
        ");
        $stmt->execute([':id_jadwal' => $id_jadwal]);
        $rows = $stmt->fetchAll();

        $matrix = [];
        foreach ($rows as $row) {
            $matrix[$row['id_siswa']][$row['tanggal']] = $row['status'];
        }
        return $matrix;
    }

    public function saveBatch(int $id_jadwal, array $absenData): bool {
        try {
            $this->db->beginTransaction();

            $deleteStmt = $this->db->prepare("DELETE FROM absensi WHERE id_jadwal = :id_jadwal");
            $deleteStmt->execute([':id_jadwal' => $id_jadwal]);

            $insertSql = "INSERT INTO absensi (id_jadwal, id_siswa, tanggal, status) 
                          VALUES (:id_jadwal, :id_siswa, :tanggal, :status)";
            $insertStmt = $this->db->prepare($insertSql);

            $allowedStatus = ['H', 'S', 'I', 'A'];

            foreach ($absenData as $id_siswa => $days) {
                if (!is_array($days)) continue;
                foreach ($days as $tanggal => $status) {
                    $status = strtoupper(trim($status));
                    if (in_array($status, $allowedStatus, true)) {
                        $insertStmt->execute([
                            ':id_jadwal' => $id_jadwal,
                            ':id_siswa'  => (int)$id_siswa,
                            ':tanggal'   => (int)$tanggal,
                            ':status'    => $status
                        ]);
                    }
                }
            }

            $this->db->commit();
            return true;
        } catch (Exception $e) {
            $this->db->rollBack();
            return false;
        }
    }
}
