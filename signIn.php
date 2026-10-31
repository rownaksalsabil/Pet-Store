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

    $email = $_POST['email'];  
    $password = $_POST['password']; 

    try {
        $sql = "SELECT * FROM User WHERE UserEmail = :email";  
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':email', $email);
        $stmt->execute();

        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($password, $user['UserPass'])) {  
            $_SESSION['UserName'] = $user['UserName']; 
            $_SESSION['UserEmail'] = $email; 
            header("Location: index.php"); 
            exit();
        } else {
            $error_message = "Invalid email or password. Please try again.";
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
    <title>Sign-In</title>
    <link rel="stylesheet" href="SignIn.css">
</head>
<body>

<nav>
    <span>Shinu's</span>
    <a href="index.php">Home</a>
</nav>
<div class="form-container">
    <h2>Login</h2>

    <?php if (isset($error_message)): ?>
        <div class="error-message"><?= $error_message ?></div>
    <?php endif; ?>

    <form action="signIn.php" method="POST">
        <input type="email" id="email" name="email" placeholder="Email" required><br> 
        <input type="password" id="password" name="password" placeholder="Password" required><br>
        <button type="submit" onclick="userSignIn()">Login</button>
    </form>
</div>
<script>
    function userSignIn(){
        localStorage.setItem('signin','true');
        Window.location.href='index.php';
    }
</script>
</body>
</html>
