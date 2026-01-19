<?php
include 'config.php';
$id = $_GET['id'];

$product = $conn->query("SELECT * FROM products WHERE id=$id")->fetch_assoc();

if ($_POST) {
  $author = $_POST['author'];
  $content = $_POST['content'];

  $conn->query("INSERT INTO reviews VALUES (NULL, $id, '$author', '$content')");

  if ($_FILES['attachment'] && $_FILES['attachment']['error'] == 0) {
    $uploadDir = 'uploads/';
    $filename = $_FILES['attachment']['name'];
    $tmpName = $_FILES['attachment']['tmp_name'];

    move_uploaded_file($tmpName, $uploadDir . $filename);
    $conn->query("INSERT INTO attachments VALUES (NULL, $id, '$filename')");
  }
}
?>

<!DOCTYPE html>
<html>
<head>
  <title><?php echo $product['name']; ?> - VulnShop</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>

<header>
  <a href="index.php">VulnShop</a>
</header>

<div class="container">

  <div class="card">
    <h2><?php echo $product['name']; ?></h2>
    <p><?php echo $product['description']; ?></p>
  </div>

  <div class="card">
    <h3>Reviews</h3>

    <?php
    $reviews = $conn->query("SELECT * FROM reviews WHERE product_id=$id");
    while ($r = $reviews->fetch_assoc()) {
      echo "<p><strong>{$r['author']}:</strong> {$r['content']}</p>";
    }
    ?>
  </div>

  <div class="card">
    <h3>Add Review</h3>
    <form method="POST" enctype="multipart/form-data">
      <input name="author" placeholder="name">
      <textarea name="content"></textarea>
      <input type="file" name="attachment">
      <button>Submit</button>
    </form>
  </div>

</div>

</body>
</html>
