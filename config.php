<?php
session_start();

// Database connection
define('DB_HOST','127.0.0.1');
define('DB_NAME','inventory_tracker');
define('DB_USER','root');
define('DB_PASS',''); // XAMPP default: empty
define('BASE_URL', '/inventory_tracker/');

try {
    $pdo = new PDO(
      "mysql:host=".DB_HOST.";dbname=".DB_NAME.";charset=utf8mb4",
      DB_USER, DB_PASS,
      [PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION]
    );
} catch (PDOException $e) {
    die("DB Connection failed: " . $e->getMessage());
}
