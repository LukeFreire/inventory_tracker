<?php
require 'functions.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $u = trim($_POST['username']);
    $e = trim($_POST['email']);
    $p = password_hash($_POST['password'], PASSWORD_BCRYPT);

    // insert user
    $stmt = $pdo->prepare("INSERT INTO users (username,email,password_hash) VALUES (?,?,?)");
    $stmt->execute([$u,$e,$p]);
    redirect('login.php');
}

include 'header.php';
?>
<h2>Register</h2>
<form method="post">
  <label>Username:<input name="username" required></label><br>
  <label>Email:<input name="email" type="email" required></label><br>
  <label>Password:<input name="password" type="password" required></label><br>
  <button>Register</button>
</form>
<?php include 'footer.php'; ?>
