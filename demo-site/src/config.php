<?php
$attempts = 0;
while ($attempts < 5) {
    try {
        $conn = new mysqli('db', 'root', 'root', 'shop');
        break; // Success! Exit the loop.
    } catch (mysqli_sql_exception $e) {
        $attempts++;
        sleep(2); // Wait 2 seconds before trying again
        if ($attempts === 5) throw $e; // Give up after 5 tries
    }
}