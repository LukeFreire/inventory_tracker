<?php
require '../functions.php';
ensure_logged_in();
ensure_admin();

// fetch all users
$users = $pdo
  ->query("SELECT id, username, email, role, created_at FROM users ORDER BY created_at DESC")
  ->fetchAll(PDO::FETCH_ASSOC);

include '../header.php';
?>
<h2>User Management</h2>
<table>
  <tr>
    <th>Username</th>
    <th>Email</th>
    <th>Role</th>
    <th>Joined</th>
    <th>Actions</th>
  </tr>
  <?php foreach ($users as $u): ?>
    <tr>
      <td><?= htmlspecialchars($u['username']) ?></td>
      <td><?= htmlspecialchars($u['email']) ?></td>
      <td><?= htmlspecialchars($u['role']) ?></td>
      <td><?= htmlspecialchars($u['created_at']) ?></td>
      <td>
        <a href="edit_user.php?id=<?= $u['id'] ?>">Edit Role</a> |
        <a href="delete_user.php?id=<?= $u['id'] ?>"
           onclick="return confirm('Delete user <?= htmlspecialchars($u['username']) ?>?');">
           Delete
        </a>
      </td>
    </tr>
  <?php endforeach; ?>
</table>
<?php include '../footer.php'; ?>
