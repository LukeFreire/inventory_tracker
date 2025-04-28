<?php
require '../functions.php';
ensure_logged_in();
ensure_admin();

// 1. Validate incoming ID
if (!isset($_GET['id'])) {
    redirect('users.php');
}
$id = (int)$_GET['id'];

// 2. Fetch the user row
$stmt = $pdo->prepare(
    "SELECT username, email, role
       FROM users
      WHERE id = ?"
);
$stmt->execute([$id]);          
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$user) {
    redirect('users.php');
}

// 3. Handle the POST to update role (and optional password)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $newRole = $_POST['role'];
    $pdo->prepare(
        "UPDATE users
            SET role = ?
          WHERE id = ?"
    )->execute([$newRole, $id]);

    if (!empty($_POST['password'])) {
        $hash = password_hash($_POST['password'], PASSWORD_BCRYPT);
        $pdo->prepare(
            "UPDATE users
                SET password_hash = ?
              WHERE id = ?"
        )->execute([$hash, $id]);
    }

    redirect('users.php');
}

include '../header.php';
?>
<h2>Edit “<?= htmlspecialchars($user['username']) ?>”</h2>
<form method="post">
  <label>Role:
    <select name="role">
      <option value="user"  <?= $user['role']==='user'  ? 'selected' : '' ?>>User</option>
      <option value="admin" <?= $user['role']==='admin' ? 'selected' : '' ?>>Admin</option>
    </select>
  </label><br>
  <label>New Password (leave blank to keep current):
    <input type="password" name="password">
  </label><br>
  <button type="submit">Save Changes</button>
</form>
<?php include '../footer.php'; ?>

