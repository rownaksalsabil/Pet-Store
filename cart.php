<?php
session_start();
@include 'config.php';
@include 'header.php';

if (isset($_GET['add'])) {
    $productId = intval($_GET['add']);
    $query = "SELECT * FROM products WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $productId);
    $stmt->execute();
    $result = $stmt->get_result();
    $product = $result->fetch_assoc();

    if ($product) {
        if (!isset($_SESSION['cart'])) {
            $_SESSION['cart'] = [];
        }
        if (isset($_SESSION['cart'][$productId])) {
            $_SESSION['cart'][$productId]['quantity'] += 1;
        } else {
            $_SESSION['cart'][$productId] = [
                'id' => $product['id'],
                'name' => $product['name'],
                'price' => $product['price'],
                'image' => $product['image'],
                'quantity' => 1
            ];
        }
    }
    header('Location: cart.php');
    exit();
}

// Remove from cart
if (isset($_GET['remove'])) {
    $productId = intval($_GET['remove']);
    if (isset($_SESSION['cart'][$productId])) {
        unset($_SESSION['cart'][$productId]);
    }
    header('Location: cart.php');
    exit();
}

// Clear cart
if (isset($_GET['clear'])) {
    unset($_SESSION['cart']);
    header('Location: cart.php');
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Your Cart</title>
    <style>
       /* General Reset */
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

/* Body Styling */
body {
    font-family: 'Arial', sans-serif;
    background-color: #f4f7fc;
    color: #333;
    padding: 20px;
}


h1 {
    text-align: center;
    font-size: 2em;
    margin-bottom: 20px;
    color: #444;
    font: bold;
}

table {
    width: 100%;
    border-collapse: collapse;
    margin-bottom: 20px;
    background-color: #fff;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
}

thead {
    background-color: #0044cc;
    color: white;
}

th, td {
    padding: 12px;
    text-align: left;
}

th {
    font-size: 1.1em;
}

td {
    font-size: 1em;
}


td img {
    width: 50px;
    height: 50px;
    border-radius: 5px;
}

td a {
    color: #d9534f;
    text-decoration: none;
    font-weight: bold;
}

td a:hover {
    text-decoration: underline;
}


tfoot {
    background-color: #f8f8f8;
    font-size: 1.2em;
    font-weight: bold;
}

tfoot td {
    padding: 15px;
}

a {
    color: #0044cc;
    text-decoration: none;
    font-weight: 500;
}

a:hover {
    color: #002a80;
    text-decoration: underline;
}

button {
    background-color: #0044cc;
    color: white;
    border: none;
    padding: 12px 25px;
    font-size: 1em;
    cursor: pointer;
    border-radius: 5px;
    transition: background-color 0.3s ease;
}

button:hover {
    background-color: #002a80;
}

button:focus {
    outline: none;
}


.clear-cart {
    text-align: center;
    margin-top: 30px;
}


.empty-cart {
    text-align: center;
    font-size: 1.1em;
    color: #888;
    margin-top: 50px;
}

.empty-cart a {
    font-weight: bold;
    color: #0044cc;
}

.empty-cart a:hover {
    text-decoration: underline;
}


@media (max-width: 768px) {
    table {
        font-size: 0.9em;
    }

    td img {
        width: 40px;
        height: 40px;
    }

    th, td {
        padding: 10px;
    }

    h2 {
        font-size: 1.6em;
    }
}

    </style>
</head>
<body>
    <h1>Cart</h1>
    <?php if (isset($_SESSION['cart']) && !empty($_SESSION['cart'])): ?>
        <table>
            <thead>
                <tr>
                    <th>Image</th>
                    <th>Name</th>
                    <th>Price</th>
                    <th>Quantity</th>
                    <th>Total</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $grandTotal = 0;
                foreach ($_SESSION['cart'] as $item):
                    $itemTotal = $item['price'] * $item['quantity'];
                    $grandTotal += $itemTotal;
                ?>
                <tr>
                    <td><img src="image/<?= htmlspecialchars($item['image']); ?>" alt="<?= htmlspecialchars($item['name']); ?>" width="50"></td>
                    <td><?= htmlspecialchars($item['name']); ?></td>
                    <td>৳<?= htmlspecialchars($item['price']); ?></td>
                    <td><?= htmlspecialchars($item['quantity']); ?></td>
                    <td>৳<?= $itemTotal; ?></td>
                    <td>
                        <a href="cart.php?remove=<?= $item['id']; ?>">Remove</a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="4" style="text-align:right;">Grand Total</td>
                    <td>৳<?= $grandTotal; ?></td>
                    <td><a href="cart.php?clear=1">Clear Cart</a></td>
                </tr>
            </tfoot>
        </table>
        <br>
        <a href="order.php">Confirm your order</a>
    <?php else: ?>
        <p>Your cart is empty. <a href="index.php">Go back to shop</a></p>
    <?php endif; ?>
</body>
</html>
