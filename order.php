<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

$conn = new mysqli("localhost", "root", "", "online-ordering-coffee-system");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$name = $_POST['name'] ?? '';
$coffee = $_POST['coffee'] ?? '';
$quantity = (int) ($_POST['quantity'] ?? 0);
$address = $_POST['address'] ?? '';

$successMessage = "";
$errorMessage = "";

if ($name && $coffee && $quantity > 0 && $address) {
    $stmt = $conn->prepare("INSERT INTO orders (name, coffee, quantity, address) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssis", $name, $coffee, $quantity, $address);

    if ($stmt->execute()) {
        $successMessage = "✅ Order placed successfully!";
    } else {
        $errorMessage = "❌ Error placing order: " . $stmt->error;
    }

    $stmt->close();
} else {
    $errorMessage = "❌ Please fill in all the fields correctly.";
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Order Status - TaraKape</title>
  <link rel="stylesheet" href="style.css" />
  <style>
    .confirmation {
      max-width: 600px;
      margin: 100px auto;
      text-align: center;
      background-color: #fff8f1;
      padding: 2rem;
      border-radius: 15px;
      box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
    }

    .confirmation h2 {
      margin-bottom: 1rem;
      font-size: 1.8rem;
    }

    .confirmation a {
      display: inline-block;
      margin-top: 1rem;
      padding: 0.8rem 1.5rem;
      background-color: #6d4c41;
      color: #fff;
      text-decoration: none;
      border-radius: 8px;
      transition: background 0.3s;
    }

    .confirmation a:hover {
      background-color: #4e342e;
    }
  </style>
</head>
<body>
  <div class="confirmation">
    <?php if ($successMessage): ?>
      <h2><?= $successMessage ?></h2>
    <?php else: ?>
      <h2><?= $errorMessage ?></h2>
    <?php endif; ?>
    <a href="index.html">← Back to Home</a>
  </div>
</body>
</html>
