<?php
$host = "localhost";
$dbname = "shinudata";
$username = "root"; 
$password = ""; 

try {
    // Establishing the database connection
    $conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    if (isset($_GET['id'])) {
        $id = intval($_GET['id']);
        
        // Preparing the query to prevent SQL injection
        $stmt = $conn->prepare("SELECT * FROM products WHERE id = :id");
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            $product = $stmt->fetch(PDO::FETCH_ASSOC);
        } else {
            echo "Product not found.";
            exit;
        }
    } else {
        echo "No product ID provided.";
        exit;
    }
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($product['name']); ?> Details</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            background-color: #f5f5f5;
            margin: 0;
            padding: 0;
        }
   
        .product-details {
            width: 100%;
            margin: 20px auto;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            padding: 20px;
            width: 200px;
            height: 200px;
            overflow: hidden;
            position: relative;
        }

        .product-details img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            display: block;
        }

        .des {
            width: 100%;
            margin: 20px auto;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            padding: 20px;
            text-align: center; 
        }

        .des p {
            font-size: 14px;
            color: #333;
            line-height: 1.5;
        }

        .des h1 {
            font-size: 28px;
            margin: 20px 0;
        }

        .des .price {
            font-size: 22px;
            font-weight: bold;
            color: #f60;
        }

        .des .cart-container .cart-button {
            text-decoration: none;
            display: inline-block;
            background-color: #000;
            color: #fff;
            font-family: 'Helvetica Neue', Arial, sans-serif;
            font-size: 16px;
            font-weight: bold;
            padding: 12px 20px;
            border: none;
            border-radius: 25px;
            cursor: pointer;
            text-transform: uppercase;
            letter-spacing: 1.2px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease-in-out;
        }

        .des .cart-container .cart-button:hover {
            background-color: #444;
            color: #ffd700;
            box-shadow: 0 6px 8px rgba(0, 0, 0, 0.2);
            transform: scale(1.05);
        }

        .des .cart-container .cart-button:active {
            background-color: #222;
            box-shadow: 0 3px 5px rgba(0, 0, 0, 0.15);
            transform: scale(0.98);
        }
    </style>
</head>
<body>

<div class="product-details">
    <img src="image/<?php echo htmlspecialchars($product['image']); ?>" alt="<?php echo htmlspecialchars($product['name']); ?>">
</div>  

<div class="des">
    <h1><?php echo htmlspecialchars($product['name']); ?></h1>
    <p><?php echo nl2br(htmlspecialchars($product['description'])); ?></p>
    <p class="price">৳<?php echo number_format($product['price'], 2); ?></p>
    <div class="cart-container">
    <button onclick="window.history.back()">Go Back</button>
    </div>
</div>

</body>
</html>
