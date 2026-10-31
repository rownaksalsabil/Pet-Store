<?php
$host = "localhost";
$dbname = "shinudata";
$username = "root"; 
$password = ""; 

try {
    $conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Fetch the first 8 products from the products table
    $stmt = $conn->query("SELECT * FROM products LIMIT 8");
    $products = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $stmt = $conn->query("SELECT * FROM blog LIMIT 3");
    $blog = $stmt->fetchAll(PDO::FETCH_ASSOC);



} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shinu's</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/css2?family=Satisfy&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="desktop.css" media="screen and (min-width: 992px)">
    <style>
        .title {
            font-family: 'Satisfy', cursive;
            color: black; 
            text-align: center; 
            margin: 10px 0;
        }
        .nav-logo img {
        border-radius: 50%; 
    }
        .featured-products .product .product-button {
            display: inline-block;
            background-color: #333;
            color: #fff;
            padding: 10px;
            text-align: center;
            text-decoration: none;
            width: 100%;
            border-radius: 0 0 8px 8px;
            font-size: 10px;
            transition: background-color 0.3s ease;
        }
        .featured-products .product .product-button:hover {
            background-color: #f60;
        }
        .featured-products .product .buttons-container {
            display: flex;
            justify-content: space-between;
            gap: 10px;
        }
        .featured-products .product .buttons-container .product-button,
        .featured-products .product .buttons-container .cart-button {
            width: 48%; 
        }
        .featured-products .product .buttons-container .cart-button {
            text-decoration: none;
            display: inline-block;
            background-color: #000;
            color: #fff;
            font-family: 'Helvetica Neue', Arial, sans-serif;
            font-size: 8px;
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
        .featured-products .product .buttons-container .cart-button:hover {
            background-color: #444;
            color: #ffd700;
            box-shadow: 0 6px 8px rgba(0, 0, 0, 0.2);
            transform: scale(1.05);
        }
        .featured-products .product .buttons-container .cart-button:active {
            background-color: #222;
            box-shadow: 0 3px 5px rgba(0, 0, 0, 0.15);
            transform: scale(0.98);
        }

    </style>
</head>
<body>
    <h1 class="title">Shinu's</h1>
    <header>
        <nav>
            <div class="logo">Pet Store</div>
            <ul class="nav-links">
                <li><a href="#home">Home</a></li>
                <li><a href="#products">Products</a></li>
                <li><a href="#about">About</a></li>
                <li><a href="#blogs">Blogs</a></li>
                <li><a href="#policies">Policies</a></li>
            </ul>
            <form class="search-bar" id="searchForm">
                <input type="text" id="searchInput" placeholder="Search products...">
                <button type="submit">Search</button>
            </form>
            <button class="cart" onclick="window.location.href='cart.php';">
    <i class="bi bi-cart"></i> Cart
</button>


            <div class="nav-buttons">
                <div class="dropdown">
                    <button class="dropbtn" id= "signInBtn">Sign In</button>
                    <div class="dropdown-content">
                        <a href="signIn_admin.php">Admin</a>
                        <a href="signIn.php">User</a>
                    </div>
                </div >
                <a href="signUp.php" class="btn-signin" id="signUpBtn">Sign Up</a>
            </div>
        </nav>
    </header>

    <div class="nav-logo col-2">
        <img src="image/Shi.jpeg" alt="Shinu" width="100%" height="100%">
    </div>

    <main>
    
    <section id="products" class="featured-products">
    <h2>Featured Products</h2>
    <div class="content">
        <a href="viewAll.php">Click Here To View All Products</a>
    </div>
    <div class="product-grid">
        <?php foreach ($products as $product): ?>
            <div class="product" data-name="<?= htmlspecialchars($product['name']); ?>" data-price="<?= htmlspecialchars($product['price']); ?>">
                <img src="image/<?= htmlspecialchars($product['image']); ?>" alt="<?= htmlspecialchars($product['name']); ?>">
                <h3><?= htmlspecialchars($product['name']); ?></h3>
                <p>৳<?= htmlspecialchars($product['price']); ?></p>
                <div class="buttons-container">
                    <a href="product_details.php?id=<?= $product['id']; ?>" class="product-button">View Details</a>
                    <a href="cart.php?add=<?= $product['id']; ?>" class="cart-button">Add to Cart</a>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</section>




                
            </div>
        </section>

        <section id="about" class="about-section">
            <h2>About Us</h2>
            <p>At Shinu's, we are passionate about providing the best products for your beloved pets. From furry friends to feathery companions and even scaly buddies, our wide range of pet essentials ensures they are safe, happy, and healthy.</p> 
        </section>

        <section id="blogs" class="blog-section">
    <h2>Latest Blogs</h2>
    <?php if (!empty($blog)): ?>
        <?php foreach ($blog as $item): ?>
            <div class="blog" data-name="<?= htmlspecialchars($item['title']); ?>" 
                 data-feature="<?= htmlspecialchars($item['feature']); ?>">
                <img src="image/<?= htmlspecialchars($item['image']); ?>" alt="<?= htmlspecialchars($item['title']); ?>">
                <h3><?= htmlspecialchars($item['title']); ?></h3>
                <p><?= htmlspecialchars($item['feature']); ?></p>
                <div class="buttons-container">
                    <a href="blog_details.php?id=<?= htmlspecialchars($item['id']); ?>" class="product-button">View</a>
                </div>
            </div>
        <?php endforeach; ?>
    <?php else: ?>
        <p>No blogs available at the moment.</p>
    <?php endif; ?>
</section>


        <section id="policies" class="policies">
            <h2>Our Policies</h2>
            <p>Learn more about our policies regarding product returns, shipping, and <a href="policies.php">more.....</a></p>
        </section>
       
       
    
        
    </main>

    <footer>
        <p>&copy; 2024 Pet Store | <a href="contact.php">Contact Us</a></p>
    </footer>
    <script>
    document.getElementById('searchInput').addEventListener('input', function () {
        const searchQuery = this.value.toLowerCase().trim();
        const products = document.querySelectorAll('.product');
        let found = false;

        if (searchQuery) {
            products.forEach(product => {
                const productName = product.dataset.name.toLowerCase();
                if (productName.includes(searchQuery)) {
                    product.style.display = "block";
                    found = true;
                } else {
                    product.style.display = "none";
                }
            });
        } else {
            products.forEach(product => {
                product.style.display = "block";
            });
        }
    });


    document.addEventListener('DOMContentLoaded', function () {
    const isLoggedIn = localStorage.getItem('signin') === 'true';
    const signInBtn = document.getElementById('signInBtn');
    const signUpBtn = document.getElementById('signUpBtn');

    if (isLoggedIn) {
        signInBtn.style.display = 'none';
        signUpBtn.style.display = 'none';

        const logoutBtn = document.createElement('button');
        logoutBtn.innerText = 'Logout';
        logoutBtn.classList.add('btn-logout');
        logoutBtn.addEventListener('click', function () {
            localStorage.setItem('signin', 'false');
            location.reload();
        });

      

        const navButtons = document.querySelector('.nav-buttons');
        navButtons.appendChild(logoutBtn);
    } else {
        signInBtn.style.display = 'block';
        signUpBtn.style.display = 'block';
    }
});

</script>

</body>
</html>
