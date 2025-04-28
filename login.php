<?php
require 'functions.php';

if ($_SERVER['REQUEST_METHOD']==='POST') {
    $e = trim($_POST['email']);
    $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->execute([$e]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && password_verify($_POST['password'], $user['password_hash'])) {
        $_SESSION['user_id']=$user['id'];
        $_SESSION['username']=$user['username'];
        $_SESSION['role']=$user['role'];
        redirect('dashboard.php');
    } else {
        $error = "Invalid login.";
    }
}

include 'header.php';
?>
<h2>Login</h2>
<?php if(!empty($error)) echo "<p style='color:red;'>$error</p>"; ?>
<form method="post">
  <label>Email:<input name="email" type="email" required></label><br>
  <label>Password:<input name="password" type="password" required></label><br>
  <button>Login</button>
</form>
<?php include 'footer.php'; ?>
