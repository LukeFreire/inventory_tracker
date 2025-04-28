<?php
require '../functions.php';
ensure_logged_in();
ensure_admin();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name']);
    $desc = trim($_POST['description']);
    $stmt = $pdo->prepare(
      "INSERT INTO categories (name, description) VALUES (?, ?)"
    );
    $stmt->execute([$name, $desc]);
    redirect('list.php');
}

include '../header.php';
?>
<h2>Add Category</h2>
<form method="post">
  <label>Name:
    <input type="text" name="name" required>
  </label><br>
  <label>Description:
    <textarea name="description"></textarea>
  </label><br>
  <button type="submit">Create Category</button>
</form>
<?php include '../footer.php'; ?>
