<?php
require '../functions.php';
ensure_logged_in();
ensure_admin();

if (isset($_GET['id'])) {
    $id = (int)$_GET['id'];
    $pdo->prepare("DELETE FROM suppliers WHERE id = ?")
        ->execute([$id]);
}
redirect('list.php');
