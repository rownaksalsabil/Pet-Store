<?php
session_start();

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
    $AdminEmail = $_POST['AdminEmail'];
    $AdminPass = $_POST['AdminPass'];

    try {
        $sql = "SELECT * FROM Admin WHERE AdminEmail = :AdminEmail";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':AdminEmail', $AdminEmail);
        $stmt->execute();

        $admin = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($admin && $AdminPass === $admin['AdminPass']) {
            // Set session variables for logged-in admin
            $_SESSION['admin_id'] = $admin['AdminID'];
            $_SESSION['admin_name'] = $admin['AdminName'];
            $_SESSION['admin_email'] = $admin['AdminEmail'];
            header("Location: admin1.php");
            exit();
        } else {
            $error_message = "Invalid Admin Email or Password. Please try again.";
        }
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
    <title>Admin Login</title>
    <link rel="stylesheet" href="SignIn_admin.css">
</head>
<body>

<nav>
    <span>Shinu's</span>
    <a href="index.php">Home</a>
</nav>

<div class="form-container">
    <h2>Admin Login</h2>

    <?php if (isset($error_message)): ?>
        <div class="error-message"><?= htmlspecialchars($error_message) ?></div>
    <?php endif; ?>

    <form action="signIn_admin.php" method="POST">
        <input type="text" name="AdminEmail" placeholder="Admin Email" required><br>
        <input type="password" name="AdminPass" placeholder="Password" required><br>
        <button type="submit">Login</button>
    </form>
</div>

</body>
</html>
