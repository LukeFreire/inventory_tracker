<?php
require '../functions.php';
ensure_logged_in();
ensure_admin();

if (!isset($_GET['id'])) redirect('list.php');
$id = (int)$_GET['id'];
$stmt = $pdo->prepare("SELECT * FROM suppliers WHERE id = ?");
$stmt->execute([$id]);
$sup = $stmt->fetch();
if (!$sup) redirect('list.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name  = trim($_POST['name']);
    $email = trim($_POST['contact_email']);
    $phone = trim($_POST['phone']);
    $stmt = $pdo->prepare(
      "UPDATE suppliers SET name = ?, contact_email = ?, phone = ? WHERE id = ?"
    );
    $stmt->execute([$name, $email, $phone, $id]);
    redirect('list.php');
}

include '../header.php';
?>
<h2>Edit Supplier</h2>
<form method="post">
  <label>Name:
    <input type="text" name="name" value="<?= htmlspecialchars($sup['name']) ?>" required>
  </label><br>
  <label>Contact Email:
    <input type="email" name="contact_email" value="<?= htmlspecialchars($sup['contact_email']) ?>">
  </label><br>
  <label>Phone:
    <input type="text" name="phone" value="<?= htmlspecialchars($sup['phone']) ?>">
  </label><br>
  <button type="submit">Update Supplier</button>
</form>
<?php include '../footer.php'; ?>
