<?php

require_once __DIR__ . '/config/Database.php';

header('Content-Type: text/html; charset=utf-8');
?>
<!DOCTYPE html>
<html>
<head>
    <style>
        body { font-family: monospace; background: #0f172a; color: #f8fafc; padding: 30px; }
        .success { color: #4ade80; }
        .error { color: #f87171; }
        .card { background: #1e293b; border: 1px solid #334155; padding: 20px; border-radius: 8px; margin-bottom: 20px; }
        a { color: #60a5fa; }
    </style>
</head>
<body>

<div class="card">
    <?php
    try {
        $pdo = Database::getConnection();
        $status = Database::getStatus();
        
        echo "<h2 class='success'>✅ Koneksi ke MySQL Berhasil!</h2>";
        echo "<ul>";
        echo "<li><strong>Host:</strong> " . htmlspecialchars($status['host']) . "</li>";
        echo "<li><strong>Port:</strong> " . htmlspecialchars($status['port']) . "</li>";
        echo "<li><strong>Database:</strong> " . htmlspecialchars($status['database']) . "</li>";
        echo "<li><strong>Driver:</strong> " . htmlspecialchars($status['driver']) . "</li>";
        echo "<li><strong>Versi Server:</strong> " . htmlspecialchars($status['version']) . "</li>";
        echo "</ul>";

        $tables = $pdo->query("SHOW TABLES")->fetchAll(PDO::FETCH_COLUMN);
        echo "<h3>Daftar Tabel Terdeteksi:</h3>";
        echo "<ul>";
        foreach ($tables as $t) {
            $count = $pdo->query("SELECT COUNT(*) FROM `$t`")->fetchColumn();
            echo "<li><code>$t</code>: <strong>$count</strong> baris</li>";
        }
        echo "</ul>";

    } catch (Exception $e) {
        echo "<h2 class='error'>❌ Koneksi Gagal!</h2>";
        echo "<p class='error'>" . htmlspecialchars($e->getMessage()) . "</p>";
    }
    ?>
</div>

<p><a href="index.php">Back</a></p>

</body>
</html>
