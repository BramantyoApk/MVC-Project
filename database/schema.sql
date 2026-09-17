CREATE DATABASE IF NOT EXISTS `db_absen` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE `db_absen`;

SET FOREIGN_KEY_CHECKS = 0;

DROP TABLE IF EXISTS `guru`;
CREATE TABLE `guru` (
    `id_guru` INT AUTO_INCREMENT PRIMARY KEY,
    `nip` VARCHAR(20) UNIQUE NOT NULL,
    `nama_guru` VARCHAR(100) NOT NULL,
    `mata_pelajaran` VARCHAR(100) NOT NULL,
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `siswa`;
CREATE TABLE `siswa` (
    `id_siswa` INT AUTO_INCREMENT PRIMARY KEY,
    `nis` VARCHAR(20) UNIQUE NOT NULL,
    `nama_siswa` VARCHAR(100) NOT NULL,
    `jenis_kelamin` ENUM('L', 'P') NOT NULL DEFAULT 'L',
    `kelas` VARCHAR(20) NOT NULL DEFAULT '10A',
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `jadwal`;
CREATE TABLE `jadwal` (
    `id_jadwal` INT AUTO_INCREMENT PRIMARY KEY,
    `id_guru` INT NULL,
    `mata_pelajaran` VARCHAR(100) NOT NULL,
    `kelas` VARCHAR(20) NOT NULL,
    `bulan` VARCHAR(20) NOT NULL,
    `tahun` VARCHAR(10) NOT NULL DEFAULT '2026',
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT `fk_jadwal_guru`
        FOREIGN KEY (`id_guru`) REFERENCES `guru` (`id_guru`)
        ON DELETE SET NULL
        ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `absensi`;
CREATE TABLE `absensi` (
    `id_absensi` INT AUTO_INCREMENT PRIMARY KEY,
    `id_jadwal` INT NOT NULL,
    `id_siswa` INT NOT NULL,
    `tanggal` TINYINT UNSIGNED NOT NULL,
    `status` ENUM('H', 'S', 'I', 'A') NOT NULL DEFAULT 'H',
    `keterangan` VARCHAR(255) NULL,
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    CONSTRAINT `fk_absensi_jadwal`
        FOREIGN KEY (`id_jadwal`) REFERENCES `jadwal` (`id_jadwal`)
        ON DELETE CASCADE
        ON UPDATE CASCADE,
    CONSTRAINT `fk_absensi_siswa`
        FOREIGN KEY (`id_siswa`) REFERENCES `siswa` (`id_siswa`)
        ON DELETE CASCADE
        ON UPDATE CASCADE,
    UNIQUE KEY `unique_absensi_siswa_tgl` (`id_jadwal`, `id_siswa`, `tanggal`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

SET FOREIGN_KEY_CHECKS = 1;
