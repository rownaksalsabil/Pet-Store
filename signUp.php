<?php
$host = "localhost";
$dbname = "shinudata";
$db_username = "root";
$db_password = ""; 

try {
    $conn = new PDO("mysql:host=$host;dbname=$dbname", $db_username, $db_password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $UserName = $_POST['UserName']; 
    $UserEmail = $_POST['UserEmail'];
    $UserNum = $_POST['UserNum'];
    $UserPass = password_hash($_POST['UserPass'], PASSWORD_DEFAULT); 
    $UserAddress = $_POST['UserAddress'];

    try {
        $sql = "INSERT INTO User (UserName, UserEmail, UserNum, UserPass, UserAddress)
                VALUES (:UserName, :UserEmail, :UserNum, :UserPass, :UserAddress)";
        $stmt = $conn->prepare($sql);

        $stmt->bindParam(':UserName', $UserName);
        $stmt->bindParam(':UserEmail', $UserEmail);
        $stmt->bindParam(':UserNum', $UserNum);
        $stmt->bindParam(':UserPass', $UserPass);
        $stmt->bindParam(':UserAddress', $UserAddress);

        $stmt->execute();
        header("Location: signIn.php");
        exit();
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Sign-Up</title>
    <link rel="stylesheet" href="signup.css">
</head>
<body>

<nav>
    <div class="nav-container">
        <div class="logo">Shinu's</div>
        <div class="nav-links">
            <a href="index.php">Home</a>
            <a href="signIn.php">Sign In</a>
        </div>
    </div>
</nav>

<h1>Sign Up</h1>
<form action="signup.php" method="POST">
    <label for="UserName">Name:</label>
    <input type="text" id="UserName" name="UserName" required><br><br>

    <label for="UserEmail">Email:</label>
    <input type="email" id="UserEmail" name="UserEmail" required><br><br>

    <label for="UserNum">Contact Number:</label>
    <input type="text" id="UserNum" name="UserNum" required><br><br>

    <label for="UserPass">Password:</label>
    <input type="password" id="UserPass" name="UserPass" required><br><br>

    <label for="UserAddress">Address:</label>
    <textarea id="UserAddress" name="UserAddress" required></textarea><br><br>

    <button type="submit">Register</button>
</form>

</body>
</html>
