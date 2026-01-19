<?php
include 'config.php';
$q = $_GET['q'];

$sql = "SELECT * FROM products WHERE name LIKE '%$q%'";
$result = $conn->query($sql);
?>

<h2>Results for: <?php echo $q; ?></h2>

<?php
while ($row = $result->fetch_assoc()) {
    echo "<p>{$row['name']} - \${$row['price']}</p>";
}
?>

