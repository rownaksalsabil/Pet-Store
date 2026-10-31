<?php
@include 'header.php';
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
        $stmt = $conn->prepare("SELECT * FROM blog WHERE id = :id");
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            $blog = $stmt->fetch(PDO::FETCH_ASSOC);
        } else {
            echo "Blog not found.";
            exit;
        }
    } else {
        echo "No blog ID provided.";
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
    <title><?php echo htmlspecialchars($blog['title']); ?> Details</title>
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
            max-width: 600px;
            margin: 20px auto;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }
        .product-details img {
            width: 100%;
            height: auto;
            display: block;
        }
        .des {
            width: 100%;
            max-width: 600px;
            margin: 20px auto;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            padding: 20px;
            text-align: center; 
        }
        .des p {
            font-size: 16px;
            color: #333;
            line-height: 1.5;
        }
        .des h1 {
            font-size: 28px;
            margin: 20px 0;
        }
        .des .details {
            font-size: 16px;
            color: #555;
            margin-top: 10px;
        }
    </style>
</head>
<body>

<div class="product-details">
    <img src="image/<?php echo htmlspecialchars($blog['image']); ?>" alt="<?php echo htmlspecialchars($blog['title']); ?>">
</div>  

<div class="des">
    <h1><?php echo htmlspecialchars($blog['title']); ?></h1>
    <p><?php echo nl2br(htmlspecialchars($blog['feature'])); ?></p>
    <p class="details"><?php echo htmlspecialchars($blog['details']); ?></p>
    <button onclick="window.history.back()">Go Back</button>

</div>

</body>
</html>
