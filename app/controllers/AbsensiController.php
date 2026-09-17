<?php
require_once __DIR__ . '/../models/Guru.php';
require_once __DIR__ . '/../models/Siswa.php';
require_once __DIR__ . '/../models/Jadwal.php';
require_once __DIR__ . '/../models/Absensi.php';


class AbsensiController {
    private Guru $guruModel;
    private Siswa $siswaModel;
    private Jadwal $jadwalModel;
    private Absensi $absensiModel;

    public function __construct() {
        $this->guruModel = new Guru();
        $this->siswaModel = new Siswa();
        $this->jadwalModel = new Jadwal();
        $this->absensiModel = new Absensi();
    }

    public function index(): void {
        $jadwal = $this->jadwalModel->getActive();
        $pesan = null;

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $idJadwal = (int)$jadwal['id_jadwal'];
            $namaGuru = trim($_POST['nama_guru'] ?? '');
            $mapel = trim($_POST['mata_pelajaran'] ?? '');
            $kelas = trim($_POST['kelas'] ?? '');
            $bulan = trim($_POST['bulan'] ?? '');

            $idGuru = $this->guruModel->findOrCreateByName($namaGuru, $mapel);
            $this->jadwalModel->update($idJadwal, $idGuru, $mapel, $kelas, $bulan);

            $absenInput = $_POST['absen'] ?? [];
            $this->absensiModel->saveBatch($idJadwal, $absenInput);

            $pesan = "Data absensi dan jadwal berhasil disimpan ke database MySQL!";

            $jadwal = $this->jadwalModel->getActive();
        }

        $siswaList = $this->siswaModel->getAll($jadwal['kelas'] ?? null);
        if (empty($siswaList)) {
            $siswaList = $this->siswaModel->getAll();
        }
        $dataAbsen = $this->absensiModel->getMatrixByJadwal((int)$jadwal['id_jadwal']);

        require_once __DIR__ . '/../views/form_absensi.php';
    }
}
