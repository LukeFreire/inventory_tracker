<?php
require '../functions.php';
ensure_logged_in();
ensure_admin();

$categories = $pdo->query("SELECT * FROM categories")->fetchAll();
include '../header.php';
?>
<h2>Manage Categories <a href="add.php">[Add New]</a></h2>
<table>
  <tr><th>Name</th><th>Description</th><th>Actions</th></tr>
  <?php foreach($categories as $c): ?>
    <tr>
      <td><?= htmlspecialchars($c['name']) ?></td>
      <td><?= htmlspecialchars($c['description']) ?></td>
      <td>
        <a href="edit.php?id=<?= $c['id'] ?>">Edit</a> |
        <a href="delete.php?id=<?= $c['id'] ?>"
           onclick="return confirm('Delete this category?');">
           Delete
        </a>
      </td>
    </tr>
  <?php endforeach; ?>
</table>
<?php include '../footer.php'; ?>
