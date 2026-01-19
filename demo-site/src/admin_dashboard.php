<?php
$user = $_GET['user'];
?>

<!DOCTYPE html>
<html>
<head>
  <title>Admin Dashboard</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>

<header>
  <a href="index.php">VulnShop</a>
  <a href="admin.php">Logout</a>
</header>

<div class="container">
  <h1>Admin Dashboard</h1>

  <p>Welcome, <strong><?php echo $user; ?></strong></p>

  <div class="card">
    <h2>🎉 Congratulations!</h2>
    <p class="success">
      You have successfully learned <strong>authentication bypass using SQL injection</strong>.
    </p>

    <p>
      This login system directly concatenates user input into SQL queries,
      allowing attackers to bypass authentication without valid credentials.
    </p>

    <p>
      In real applications, this should be prevented using:
    </p>
    <ul>
      <li>Prepared statements</li>
      <li>Parameterized queries</li>
      <li>Proper input validation</li>
    </ul>

    <p><strong>CTF Flag:</strong></p>
    <code>flag{sql_injection_auth_bypass}</code>
  </div>
</div>

</body>
</html>

