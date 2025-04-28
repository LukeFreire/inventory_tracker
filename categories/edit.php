<?php
require '../functions.php';
ensure_logged_in();
ensure_admin();

if (!isset($_GET['id'])) redirect('list.php');
$id = (int)$_GET['id'];
$stmt = $pdo->prepare("SELECT * FROM categories WHERE id = ?");
$stmt->execute([$id]);
$cat = $stmt->fetch();
if (!$cat) redirect('list.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name']);
    $desc = trim($_POST['description']);
    $stmt = $pdo->prepare(
      "UPDATE categories SET name = ?, description = ? WHERE id = ?"
    );
    $stmt->execute([$name, $desc, $id]);
    redirect('list.php');
}

include '../header.php';
?>
<h2>Edit Category</h2>
<form method="post">
  <label>Name:
    <input type="text" name="name" value="<?= htmlspecialchars($cat['name']) ?>" required>
  </label><br>
  <label>Description:
    <textarea name="description"><?= htmlspecialchars($cat['description']) ?></textarea>
  </label><br>
  <button type="submit">Update Category</button>
</form>
<?php include '../footer.php'; ?>
