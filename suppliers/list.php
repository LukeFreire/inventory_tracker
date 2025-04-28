<?php
require '../functions.php';
ensure_logged_in();
ensure_admin();

$suppliers = $pdo->query("SELECT * FROM suppliers")->fetchAll();
include '../header.php';
?>
<h2>Manage Suppliers <a href="add.php">[Add New]</a></h2>
<table>
  <tr><th>Name</th><th>Contact Email</th><th>Phone</th><th>Actions</th></tr>
  <?php foreach($suppliers as $s): ?>
    <tr>
      <td><?= htmlspecialchars($s['name']) ?></td>
      <td><?= htmlspecialchars($s['contact_email']) ?></td>
      <td><?= htmlspecialchars($s['phone']) ?></td>
      <td>
        <a href="edit.php?id=<?= $s['id'] ?>">Edit</a> |
        <a href="delete.php?id=<?= $s['id'] ?>"
           onclick="return confirm('Delete this supplier?');">
           Delete
        </a>
      </td>
    </tr>
  <?php endforeach; ?>
</table>
<?php include '../footer.php'; ?>
