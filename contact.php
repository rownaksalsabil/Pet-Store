<?php
$host = "localhost";
$dbname = "shinudata";
$username = "root"; 
$password = ""; 

try {
    // Database connection
    $conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $message = $_POST['message'];

    try {
        // Insert into database
        $sql = "INSERT INTO contact_messages (name, email, message)
                VALUES (:name, :email, :message)";
        $stmt = $conn->prepare($sql);

        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':message', $message);

        $stmt->execute();

        // Redirect or show success message
        echo "<script>alert('Thank you for contacting us! We will get back to you shortly.');</script>";
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
    <title>Contact Us</title>
    <link rel="stylesheet" href="contact.css">
</head>
<body>
    <header>
        <nav>
            <div class="logo">Shinu's</div>
            <ul class="nav-links">
                <li><a href="index.php">Home</a></li>
                <li><a href="contact.php" class="active">Contact</a></li>
            </ul>
        </nav>
    </header>

    <main>
        <section class="contact-section">
            <h1>Contact Us</h1>
            <p>We would love to hear from you! Feel free to reach out to us using the form below or through our contact details.</p>

            <div class="contact-info">
                <p><strong>Phone:</strong> +880-123-456789</p>
                <p><strong>Email:</strong> support@petstore.com</p>
                <p><strong>Address:</strong> 123 Pet Street, Dhaka, Bangladesh</p>
            </div>

            <form id="contactForm" class="form-container" method="POST" action="">
    <div class="form-group">
        <label for="name">Your Name</label>
        <input type="text" id="name" name="name" placeholder="Enter your name" required>
    </div>

    <div class="form-group">
        <label for="email">Your Email</label>
        <input type="email" id="email" name="email" placeholder="Enter your email" required>
    </div>

    <div class="form-group">
        <label for="message">Your Message</label>
        <textarea id="message" name="message" placeholder="Enter your message" rows="5" required></textarea>
    </div>

    <button type="submit">Submit</button>
</form>

        </section>
    </main>

    <footer>
        <p>&copy; 2024 Pet Store | <a href="index.html">Home</a></p>
    </footer>

    <script>
        document.getElementById('contactForm').addEventListener('submit', function(event) {
            event.preventDefault();
            alert('Thank you for contacting us! We will get back to you shortly.');
            this.reset();
        });
    </script>
</body>
</html>