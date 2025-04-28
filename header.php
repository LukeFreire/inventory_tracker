<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>Inventory Tracker</title>
  <link rel="stylesheet" href="<?= BASE_URL ?>assets/css/style.css">
</head>
<body>
<nav>
  <a href="<?= BASE_URL ?>dashboard.php">Dashboard</a>
  <?php if(isset($_SESSION['user_id'])): ?>
    <a href="<?= BASE_URL ?>logout.php">Logout (<?= htmlspecialchars($_SESSION['username']) ?>)</a>
  <?php else: ?>
    <a href="<?= BASE_URL ?>login.php">Login</a> |
    <a href="<?= BASE_URL ?>register.php">Register</a>
  <?php endif; ?>
</nav>

<main>
