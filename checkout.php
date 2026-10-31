<?php
@include 'header.php';
$host = 'localhost'; 
$dbname = 'shinudata'; 
$username = 'root'; 
$password = ''; 

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}

$errors = [];
$successMessage = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $cardName = $_POST['card_name'] ?? '';
    $cardNumber = $_POST['card_number'] ?? '';
    $expiryDate = $_POST['expiry_date'] ?? '';
    $cvv = $_POST['cvv'] ?? '';

    // Validate form inputs
    if (empty($cardName)) {
        $errors[] = "Cardholder's Name is required.";
    }
    if (empty($cardNumber) || !preg_match('/^\d{16}$/', $cardNumber)) {
        $errors[] = "Valid 16-digit Card Number is required.";
    }
    if (empty($expiryDate) || !preg_match('/^\d{2}\/\d{2}$/', $expiryDate)) {
        $errors[] = "Expiry Date in MM/YY format is required.";
    }
    if (empty($cvv) || !preg_match('/^\d{3}$/', $cvv)) {
        $errors[] = "Valid 3-digit CVV is required.";
    }

    // If no errors, save to database
    if (empty($errors)) {
        try {
            // Prepare SQL statement to insert data
            $stmt = $pdo->prepare("INSERT INTO payments (card_name, card_number, expiry_date, cvv) 
                                   VALUES (:card_name, :card_number, :expiry_date, :cvv)");
            
            // Bind parameters to the SQL query
            $stmt->bindParam(':card_name', $cardName);
            $stmt->bindParam(':card_number', $cardNumber);
            $stmt->bindParam(':expiry_date', $expiryDate);
            $stmt->bindParam(':cvv', $cvv);

            // Execute the statement
            $stmt->execute();
            $successMessage = "Payment successfully submitted!";
        } catch (PDOException $e) {
            $errors[] = "Error saving data to the database: " . $e->getMessage();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Form</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            height: auto;
            display: flex;
            justify-content: center; 
            align-items: center;
            background-color: #f8f9fa; 
        }

        .payment-container {
            background-color: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); 
            width: 100%;
            max-width: 400px; 
            box-sizing: border-box;
        }

        h2 {
            text-align: center;
            margin-bottom: 20px;
            color: #333;
        }

        .form-group {
            margin-bottom: 15px;
        }

        input {
            width: 100%;
            padding: 10px;
            font-size: 14px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        button {
            width: 100%;
            padding: 10px;
            font-size: 16px;
            color: #fff;
            background: #007bff;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            margin-top: 10px;
        }

        button:hover {
            opacity: 0.9;
        }


        .error p {
            color: #dc3545;
            font-size: 14px;
            margin: 5px 0;
        }

        .success {
            color: #28a745;
            text-align: center;
            margin-bottom: 10px;
        }
        
        .close-btn {
            width: 100%;
            padding: 10px;
            font-size: 16px;
            color: #fff;
            background: #dc3545; 
            border: none;
            border-radius: 4px;
            cursor: pointer;
            margin-top: 10px;
        }
        
        .close-btn:hover {
            opacity: 0.9;
        }
    </style>
    <script>
        function clearForm() {
            document.getElementById('card_name').value = '';
            document.getElementById('card_number').value = '';
            document.getElementById('expiry_date').value = '';
            document.getElementById('cvv').value = '';
        }

        function closeForm() {
            document.querySelector('.payment-container').style.display = 'none';
        }
    </script>
</head>
<body>
<div class="payment-container">
    <h2>Payment Form</h2>
    
    <?php if (!empty($successMessage)) : ?>
        <p class="success"><?php echo htmlspecialchars($successMessage); ?></p>
    <?php endif; ?>

    <?php if (!empty($errors)) : ?>
        <div class="error">
            <?php foreach ($errors as $error) : ?>
                <p><?php echo htmlspecialchars($error); ?></p>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>


    <form method="POST" action="">
        <div class="form-group">
            <label for="card_name">Cardholder's Name</label>
            <input type="text" id="card_name" name="card_name" value="<?php echo htmlspecialchars($_POST['card_name'] ?? ''); ?>" required>
        </div>
        <div class="form-group">
            <label for="card_number">Card Number</label>
            <input type="text" id="card_number" name="card_number" maxlength="16" value="<?php echo htmlspecialchars($_POST['card_number'] ?? ''); ?>" required>
        </div>
        <div class="form-group">
            <label for="expiry_date">Expiry Date (MM/YY)</label>
            <input type="text" id="expiry_date" name="expiry_date" value="<?php echo htmlspecialchars($_POST['expiry_date'] ?? ''); ?>" required>
        </div>
        <div class="form-group">
            <label for="cvv">CVV</label>
            <input type="text" id="cvv" name="cvv" maxlength="3" value="<?php echo htmlspecialchars($_POST['cvv'] ?? ''); ?>" required>
        </div>
        <button type="submit" class="submit-button">Submit Payment</button>
        <button type="button" class="close-btn" onclick="window.location.href = 'index.php';">Close</button>

    </form>
</div>
</body>
</html>
 