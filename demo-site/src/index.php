<?php include 'config.php'; ?>
<!DOCTYPE html>
<html>
<head>
  <title>VulnShop</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>

<header>
  <a href="index.php">VulnShop</a>
  <a href="admin.php">Admin</a>
</header>

<div class="container">
  <h2>Search Products</h2>
  <form action="search.php">
    <input name="q" placeholder="Search...">
    <button>Search</button>
  </form>

  <h2>Products</h2>
  <div class="products">
    <?php
    $res = $conn->query("SELECT * FROM products");
    while ($p = $res->fetch_assoc()) {
      echo "<div class='card'>
              <img src='product_images/{$p['image']}' class='product-img'>
              <h3>{$p['name']}</h3>
              <p>{$p['description']}</p>
              <strong>\${$p['price']}</strong><br>
              <a href='product.php?id={$p['id']}'>View</a>
            </div>";
    }

    ?>
  </div>
</div>

<footer>VulnShop © 2026</footer>
</body>
</html>

