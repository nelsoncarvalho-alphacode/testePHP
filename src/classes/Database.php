<?php
    class Database {
        private static $host = 'mysql';
        private static $db   = 'teste_pratico';
        private static $user = 'root';
        private static $pass = 'root';
        private static $conn;

        public static function getConnection() {
            if (!self::$conn) {
                $dsn = "mysql:host=" . self::$host . ";dbname=" . self::$db . ";charset=utf8mb4";
                try {
                    self::$conn = new PDO($dsn, self::$user, self::$pass);
                    self::$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                } catch (PDOException $e) {
                    error_log('Connection failed: ' . $e->getMessage());
                    throw $e;
                }
            }
            return self::$conn;
        }
    }