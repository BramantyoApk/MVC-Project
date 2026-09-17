# 🏫 Aplikasi Absensi Siswa Sederhana (Tugas Proyek SMK Kelas 3)
> Aplikasi Absensi Siswa berbasis **PHP Native (Konsep MVC Sederhana)** dan **MySQL Docker** yang dibuat simpel, rapi, dan mudah dipresentasikan.

---

## 🚀 Cara Menjalankan Project

Jalankan perintah berikut di terminal root project:

```bash
docker compose up -d
```

### Akses Aplikasi:
- **Aplikasi Absensi (1 Halaman Utama):** [http://localhost:8080](http://localhost:8080)
- **phpMyAdmin (Melihat isi Database MySQL):** [http://localhost:8081](http://localhost:8081)
  - Server: `db`
  - User: `root`
  - Password: `password`
- **Uji Koneksi Database:** [http://localhost:8080/test_db.php](http://localhost:8080/test_db.php)

---

## 📁 Struktur File (Sederhana & Teratur)

Struktur file dibuat simpel mengikuti konsep dasar **Model-View-Controller (MVC)** agar mudah dijelaskan saat presentasi:

```text
ReadView/
├── Dockerfile                  # Menjalankan PHP 8.2 + Apache + ekstensi MySQL
├── docker-compose.yml          # Mengatur container Web, MySQL, dan phpMyAdmin
├── index.php                   # File utama (langsung membuka Form Absensi)
├── test_db.php                 # File pengujian koneksi ke database MySQL
├── README.md                   # Panduan penjelasan dan cara presentasi
│
├── config/
│   └── Database.php            # File koneksi PDO ke MySQL di Docker
│
├── database/
│   ├── init.sql                # Skrip pembuatan tabel & data awal otomatis
│   ├── schema.sql              # Struktur tabel (DDL)
│   └── seed.sql                # Data awal guru dan siswa
│
└── app/
    ├── controllers/
    │   └── AbsensiController.php    # Mengatur alur data dan proses simpan absensi
    ├── models/
    │   ├── Guru.php            # Mengambil data guru dari database
    │   ├── Siswa.php           # Mengambil data siswa dari database
    │   ├── Jadwal.php          # Mengambil & mengupdate jadwal pelajaran
    │   └── Absensi.php         # Mengambil & menyimpan data absen (H, S, I, A)
    └── views/
        └── form_absensi.php    # 1 Halaman tampilan form absensi siswa
```

---

## 🗄️ Struktur Database MySQL (`db_absen`)

Database terdiri dari 4 tabel yang saling berelasi menggunakan **Primary Key** dan **Foreign Key**:

1. **`guru`** : Menyimpan data guru (id_guru, nip, nama_guru, mata_pelajaran).
2. **`siswa`** : Menyimpan data siswa (id_siswa, nis, nama_siswa, jenis_kelamin, kelas).
3. **`jadwal`** : Menyimpan jadwal kelas (id_jadwal, id_guru, mata_pelajaran, kelas, bulan).
   - Relasi: `id_guru` terhubung ke tabel `guru`.
4. **`absensi`** : Menyimpan status absensi harian siswa (id_absensi, id_jadwal, id_siswa, tanggal, status).
   - `status`: H (Hadir), S (Sakit), I (Izin), A (Alpa).
   - Relasi: `id_jadwal` terhubung ke tabel `jadwal` dan `id_siswa` ke tabel `siswa`.

---

## 🎤 Cara Menjelaskan Saat Presentasi (Simpel & Jelas)

1. **Buka Aplikasi di Browser**:
   - Buka `http://localhost:8080`.
   - Jelaskan: *"Aplikasi ini adalah Form Absensi Siswa 1 halaman. Di bagian atas ada pilihan Guru, Mata Pelajaran, Kelas, dan Bulan. Di bawahnya ada tabel absensi tanggal 1 sampai 31 untuk 30 siswa."*
2. **Demokan Pengisian**:
   - Ubah status absen salah satu siswa (misal ubah jadi S atau I).
   - Klik tombol biru **"Simpan Data Absensi"**.
   - Tunjukkan pesan hijau: *"Data absensi dan jadwal berhasil disimpan ke database MySQL!"*.
3. **Tunjukkan Database di phpMyAdmin**:
   - Buka `http://localhost:8081` &rarr; buka tabel `absensi`.
   - Tunjukkan bahwa data yang baru diisi sudah tersimpan di tabel MySQL.
4. **Jelaskan Struktur Kode (MVC)**:
   - *"Kode dipisah menjadi 3 bagian: **Model** untuk query data, **View** untuk tampilan HTML form, dan **Controller** untuk menghubungkan keduanya."*
