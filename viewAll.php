<?php
@include 'header.php';
$host = "localhost";
$dbname = "shinudata";
$username = "root"; 
$password = ""; 

try {
    $conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Get total users count
    $stmt = $conn->query("SELECT COUNT(*) AS totalUsers FROM user");
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    $totalUsers = $result['totalUsers'];

    // Fetch product data
    $stmt = $conn->query("SELECT id, name, price, image, description FROM products");
    $products = $stmt->fetchAll(PDO::FETCH_ASSOC);  // Fetch all products in an associative array

} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View All Products</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="viewAll.css"> <!-- Link to the external CSS file -->
</head>
<body>

<div class="container">
    <?php if (count($products) > 0): ?>
        <?php foreach ($products as $product): ?>
            <div class="product">
                <img src="image/<?php echo htmlspecialchars($product['image']); ?>" alt="<?php echo htmlspecialchars($product['name']); ?>">
                <div class="product-info">
                    <h3 class="product-name"><?php echo htmlspecialchars($product['name']); ?></h3>
                    <p class="product-price">$<?php echo number_format($product['price'], 2); ?></p>
                    <div class="buttons-container">
                        <a href="product_details.php?id=<?php echo $product['id']; ?>" class="product-button">View Details</a>
                        <a href="cart.php?add=<?php echo $product['id']; ?>" class="cart-button">Add to Cart</a>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    <?php else: ?>
        <p>No products available.</p>
    <?php endif; ?>
</div>

</body>
</html>
