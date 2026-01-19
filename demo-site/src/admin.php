<?php
include 'config.php';

$error = "";

if ($_POST) {
  $u = $_POST['username'];
  $p = $_POST['password'];

  // INTENTIONALLY VULNERABLE
  $sql = "SELECT * FROM admins WHERE username='$u' AND password='$p'";
  $res = $conn->query($sql);

  if ($res && $res->num_rows > 0) {
    header("Location: admin_dashboard.php?user=$u");
    exit;
  } else {
    $error = "Invalid credentials for $u";
  }
}
?>

<!DOCTYPE html>
<html>
<head>
  <title>Admin Login</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>

<header>
  <a href="index.php">VulnShop</a>
</header>

<div class="admin-container">
  <div class="admin-card">
    <h2>Admin Login</h2>

    <?php if ($error): ?>
      <div class="error"><?php echo $error; ?></div>
    <?php endif; ?>

    <form method="POST">
      <input name="username" placeholder="Username">
      <input name="password" placeholder="Password" type="password">
      <button>Login</button>
    </form>
  </div>
</div>

</body>
</html>

