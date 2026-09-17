<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../public/css/style.css">
    <title>Aplikasi Absensi Siswa</title>
</head>
<body>

<div class="container">
    <div class="header">
        <h2>FORM ABSENSI SISWA</h2>
    </div>

    <?php if (!empty($pesan)): ?>
        <div class="alert alert-success">
            <?= htmlspecialchars($pesan) ?>
        </div>
    <?php endif; ?>

    <form method="POST" action="index.php">
        
        <div class="form-info">
            <div class="form-group">
                <label>Nama Guru:</label>
                <input type="text" name="nama_guru" value="<?= htmlspecialchars($jadwal['nama_guru'] ?? 'Budi Santoso, M.Pd.') ?>" placeholder="Ketik nama guru..." required>
            </div>

            <div class="form-group">
                <label>Mata Pelajaran:</label>
                <input type="text" name="mata_pelajaran" value="<?= htmlspecialchars($jadwal['mata_pelajaran'] ?? '') ?>" required>
            </div>

            <div class="form-group">
                <label>Kelas:</label>
                <input type="text" name="kelas" value="<?= htmlspecialchars($jadwal['kelas'] ?? '') ?>" required>
            </div>

            <div class="form-group">
                <label>Bulan:</label>
                <input type="text" name="bulan" value="<?= htmlspecialchars($jadwal['bulan'] ?? '') ?>" required>
            </div>
        </div>

        <div class="keterangan">
            <span><strong>Keterangan:</strong></span>
            <span class="badge badge-h">H = Hadir</span>
            <span class="badge badge-i">I = Izin</span>
            <span class="badge badge-a">A = Alpa</span>
            <span class="badge badge-s">S = Sakit</span>
        </div>

        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th class="sticky-col-1" rowspan="2">No</th>
                        <th class="sticky-col-2" rowspan="2">Nama Siswa</th>
                        <th colspan="31">Tanggal (1 - 31)</th>
                    </tr>
                    <tr>
                        <?php for ($i = 1; $i <= 31; $i++): ?>
                            <th style="min-width: 38px;"><?= $i ?></th>
                        <?php endfor; ?>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($siswaList as $index => $siswa): 
                        $sid = $siswa['id_siswa'];
                    ?>
                    <tr>
                        <td class="sticky-col-1"><?= $index + 1 ?></td>
                        <td class="sticky-col-2"><?= htmlspecialchars($siswa['nama_siswa']) ?></td>
                        
                        <?php for ($tgl = 1; $tgl <= 31; $tgl++): 
                            $status = $dataAbsen[$sid][$tgl] ?? '';
                        ?>
                            <td>
                                <select name="absen[<?= $sid ?>][<?= $tgl ?>]">
                                    <option value=""></option>
                                    <option value="H" <?= ($status === 'H') ? 'selected' : '' ?>>H</option>
                                    <option value="I" <?= ($status === 'I') ? 'selected' : '' ?>>I</option>
                                    <option value="A" <?= ($status === 'A') ? 'selected' : '' ?>>A</option>
                                    <option value="S" <?= ($status === 'S') ? 'selected' : '' ?>>S</option>
                                </select>
                            </td>
                        <?php endfor; ?>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>

        <button type="submit" class="btn-simpan">Simpan Data Absensi</button>
    </form>
</div>

</body>
</html>
