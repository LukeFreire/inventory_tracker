<?php
require 'functions.php';
ensure_logged_in();
include 'header.php';
?>

<h1>Welcome, <?= htmlspecialchars($_SESSION['username']) ?></h1>

<ul>
  <li><a href="items/list.php">Manage Items</a></li>

  <?php if ($_SESSION['role'] === 'admin'): ?>
    <li><a href="categories/list.php">Manage Categories</a></li>
    <li><a href="suppliers/list.php">Manage Suppliers</a></li>
    <li><a href="admin/users.php">Manage Users</a></li>
  <?php endif; ?>
</ul>

<?php include 'footer.php'; ?>


