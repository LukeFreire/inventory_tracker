<?php
require '../functions.php';
ensure_logged_in();
ensure_admin();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name  = trim($_POST['name']);
    $email = trim($_POST['contact_email']);
    $phone = trim($_POST['phone']);
    $stmt = $pdo->prepare(
      "INSERT INTO suppliers (name, contact_email, phone) VALUES (?, ?, ?)"
    );
    $stmt->execute([$name, $email, $phone]);
    redirect('list.php');
}

include '../header.php';
?>
<h2>Add Supplier</h2>
<form method="post">
  <label>Name:
    <input type="text" name="name" required>
  </label><br>
  <label>Contact Email:
    <input type="email" name="contact_email">
  </label><br>
  <label>Phone:
    <input type="text" name="phone">
  </label><br>
  <button type="submit">Create Supplier</button>
</form>
<?php include '../footer.php'; ?>

