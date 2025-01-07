<?php
@include 'config.php';

if (!isset($_GET['id'])) {
    die("Product ID is required.");
}

$product_id = intval($_GET['id']);

// Fetch product details from the database

$sql = "SELECT * FROM gear_list WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $product_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $product = $result->fetch_assoc();
} else {
    die("Product not found.");
}

$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($product['gear_name'], ENT_QUOTES); ?> - Details</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Hind:wght@400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
 /* General Reset */
/* General Reset */
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

/* Body */
body {
    font-family: 'Hind', sans-serif;
    background-color: #121212; /* Dark background for the entire page */
    color: #e0e0e0; /* Light grey text for good readability */
    line-height: 1.6;
}

/* Header */
header {
    background-color: #1f1f1f;
    padding: 20px 0;
    color: #ffffff;
}

header .logo {
    font-size: 24px;
    font-weight: bold;
    color: #74b9ff;
    text-align: center;
    margin-bottom: 10px;
}

header nav {
    text-align: center;
}

header .nav-links {
    list-style-type: none;
    display: inline-flex;
    gap: 20px;
}

header .nav-links li {
    display: inline;
}

header .nav-links a {
    color: #ffffff;
    text-decoration: none;
    font-size: 18px;
    font-weight: 500;
    transition: color 0.3s;
}

header .nav-links a:hover {
    color: #74b9ff;
}

/* Product Details Section */
.product-details {
    max-width: 800px;
    margin: 30px auto;
    padding: 20px;
    background-color: #1f1f1f; /* Dark background for the product section */
    border-radius: 10px;
    box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
}

/* Product Image */
.product-details img {
    width: 100%;
    height: auto;
    border-radius: 8px;
}

/* Product Name */
.product-details h1 {
    font-size: 28px;
    margin-top: 15px;
    color: #ffffff;
}

/* Product Description and Information */
.product-details p {
    font-size: 16px;
    margin: 10px 0;
    color: #ccc; /* Light grey text for descriptions */
}

/* Buttons */
.product-details .btn {
    background-color: #0984e3; /* Blue button */
    color: white;
    padding: 12px 25px;
    border: none;
    border-radius: 8px;
    text-decoration: none;
    display: inline-block;
    font-size: 18px;
    cursor: pointer;
    transition: background-color 0.3s ease;
}

/* Button Hover Effect */
.product-details .btn:hover {
    background-color: #74b9ff; /* Lighter blue on hover */
}

/* Footer */
footer {
    background-color: #1f1f1f;
    padding: 50px 20px;
    color: #e0e0e0;
    text-align: center;
    margin-top: 2rem;
}

footer .footer-content {
    display: flex;
    justify-content: space-between;
    margin-bottom: 20px;
}

footer .footer-content div {
    width: 23%;
}

footer .footer-content h3 {
    font-size: 1.2rem;
    margin-bottom: 15px;
    color: #74b9ff;
}

footer .footer-content ul {
    list-style: none;
}

footer .footer-content ul li {
    margin-bottom: 10px;
}

footer .footer-content ul li a {
    text-decoration: none;
    color: #74b9ff;
    font-size: 1rem;
}

footer .footer-content ul li a:hover {
    text-decoration: underline;
}

footer .social-icons a {
    color: #74b9ff;
    font-size: 1.5rem;
    margin-right: 15px;
    transition: color 0.3s ease;
}

footer .social-icons a:hover {
    color: #0984e3;
}

footer p {
    font-size: 1rem;
    margin-top: 20px;
}

/* Responsive Layout */
@media (max-width: 768px) {
    .product-details {
        width: 95%;
    }

    footer .footer-content {
        flex-direction: column;
        align-items: center;
    }

    footer .footer-content div {
        width: 100%;
        text-align: center;
        margin-bottom: 20px;
    }

    footer .footer-content h3 {
        font-size: 1rem;
    }
}

    </style>
</head>
<body>
<header class="header">
        <div class="container">
          <h1 class="logo">GameHaven</h1>
          <nav>
            <ul class="nav-links">
              <li><a href="homepage.php">Home</a></li>
              <li><a href="share.php">Share</a></li>
              <li><a href="available_gears.php">Rent</a></li>
              <li><a href="my_profile.php">My Profile</a></li>
            </ul>
          </nav>
    </div>
</header>
    <div class="product-details">
        <img src="<?= htmlspecialchars($product['gear_image'], ENT_QUOTES); ?>" alt="<?= htmlspecialchars($product['gear_name'], ENT_QUOTES); ?>">
        <h1><?= htmlspecialchars($product['gear_name'], ENT_QUOTES); ?></h1>
        <p><strong>Type:</strong> <?= htmlspecialchars($product['gear_type'], ENT_QUOTES); ?></p>
        <p><strong>Description:</strong> <?= htmlspecialchars($product['gear_description'], ENT_QUOTES); ?></p>
        <p><strong>Price:</strong> <?= number_format($product['price'], 2); ?> BDT/day</p>
        <p><strong>Location:</strong> <?= htmlspecialchars($product['location'], ENT_QUOTES); ?></p>
        <form method="POST" action="add_to_cart.php">
            <input type="hidden" name="gear_id" value="<?= $product['id']; ?>">
            <input type="hidden" name="gear_name" value="<?= htmlspecialchars($product['gear_name'], ENT_QUOTES); ?>">
            <input type="hidden" name="price" value="<?= $product['price']; ?>">
            <input type="hidden" name="gear_image" value="<?= $product['gear_image']; ?>">
            <button type="submit" class="btn">Add to Cart</button>
        </form>
    </div>
  <footer>
    <div class="container">
      <div class="footer-content">
        <div>
          <h3>About GameHaven</h3>
          <p>GameHaven is a leading platform for renting gaming equipment, offering an extensive selection and seamless user experience. We connect renters and providers across Bangladesh.</p>
        </div>
        <div>
          <h3>Quick Links</h3>
          <ul>
            <li><a href="homepage.php">Home</a></li>
            <li><a href="about_us.php">About Us</a></li>
            <li><a href="help.php">FAQs</a></li>
            <li><a href="privacy_policy_popup.php">Privacy Policy</a></li>
            <li><a href="terms_and_conditions_popup.php">Terms of Service</a></li>
          </ul>
        </div>
        <div>
          <h3>Follow Us</h3>
          <div class="social-icons">
                        <a href="https://www.facebook.com"><i class="fab fa-facebook"></i></a>
                        <a href="https://www.twitter.com"><i class="fab fa-twitter"></i></a>
                        <a href="https://www.instagram.com"><i class="fab fa-instagram"></i></a>
                        <a href="https://www.discord.com"><i class="fab fa-discord"></i></a>
                        <a href="https://www.gmail.com"><i class="fas fa-envelope"></i></a>
          </div>
        </div>
        <div>
          <h3>Contact</h3>
          <p>Email: support@gamehaven.com</p>
          <p>Phone: +880-123-456789</p>
          <p>Address: Dhaka, Bangladesh</p>
        </div>
      </div>
      <p>&copy; 2024 GameHaven. All Rights Reserved.</p>
    </div>
  </footer>
</body>
</html>
