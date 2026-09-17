<?php
class Database {
    private static ?PDO $instance = null;

    public static function getConnection(): PDO {
        if (self::$instance === null) {
            $host = getenv('DB_HOST') ?: 'db';
            $port = getenv('DB_PORT') ?: '3306';
            $dbname = getenv('DB_DATABASE') ?: 'db_absen';
            $user = getenv('DB_USERNAME') ?: 'root';
            $pass = getenv('DB_PASSWORD') ?: 'password';

            $dsn = "mysql:host={$host};port={$port};dbname={$dbname};charset=utf8mb4";

            $options = [
                PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES   => false,
            ];

            try {
                self::$instance = new PDO($dsn, $user, $pass, $options);
            } catch (PDOException $e) {
                try {
                    $fallbackDsn = "mysql:host=127.0.0.1;port=3307;dbname={$dbname};charset=utf8mb4";
                    self::$instance = new PDO($fallbackDsn, $user, $pass, $options);
                } catch (PDOException $e2) {
                    die("<h3>Koneksi Database Gagal:</h3> " . htmlspecialchars($e->getMessage()) . 
                        "<br><small>Fallback lokal (127.0.0.1:3307): " . htmlspecialchars($e2->getMessage()) . "</small>");
                }
            }
        }

        return self::$instance;
    }

    public static function getStatus(): array {
        try {
            $pdo = self::getConnection();
            $serverVersion = $pdo->getAttribute(PDO::ATTR_SERVER_VERSION);
            $driverName = $pdo->getAttribute(PDO::ATTR_DRIVER_NAME);
            
            return [
                'status' => 'connected',
                'driver' => $driverName,
                'version' => $serverVersion,
                'database' => getenv('DB_DATABASE') ?: 'db_absen',
                'host' => getenv('DB_HOST') ?: 'db',
                'port' => getenv('DB_PORT') ?: '3306'
            ];
        } catch (Exception $e) {
            return [
                'status' => 'error',
                'message' => $e->getMessage()
            ];
        }
    }
}
