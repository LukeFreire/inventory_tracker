<?php
require_once 'config.php';

function redirect($url) {
    header("Location: $url");
    exit;
}

function ensure_logged_in() {
    if (!isset($_SESSION['user_id'])) {
        redirect('login.php');
    }
}

function ensure_admin() {
    if ($_SESSION['role'] !== 'admin') {
        die("Access denied.");
    }
}

function current_user() {
    global $pdo;
    if (!isset($_SESSION['user_id'])) return null;
    $stmt = $pdo->prepare("SELECT * FROM users WHERE id = ?");
    $stmt->execute([$_SESSION['user_id']]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}
