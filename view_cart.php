<?php
session_start(); // Resume the session
@include 'config.php';

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    die("Error: You must log in to view your cart.");
}

$user_id = $_SESSION['user_id']; // Logged-in user's ID

// Handle quantity updates
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update_cart'])) {
    $cart_id = filter_var($_POST['cart_id'], FILTER_VALIDATE_INT);
    $quantity = filter_var($_POST['quantity'], FILTER_VALIDATE_INT);

    if ($cart_id && $quantity && $quantity > 0) {
        $stmt = $conn->prepare("UPDATE cart SET quantity = ? WHERE id = ? AND user_id = ?");
        $stmt->bind_param("iii", $quantity, $cart_id, $user_id);
        if ($stmt->execute()) {
            header("Location: view_cart.php"); // Reload the page to reflect updates
            exit;
        } else {
            echo "Error updating cart: " . $conn->error;
        }
    } else {
        echo "Invalid quantity.";
    }
}

// Retrieve cart items with gear details
$query = "
    SELECT c.id AS cart_id, g.gear_name, g.price, g.gear_image, c.quantity, (g.price * c.quantity) AS total_price
    FROM cart c
    INNER JOIN gear_list g ON c.gear_id = g.id
    WHERE c.user_id = '$user_id'
";
$result = mysqli_query($conn, $query);

$total_cart_price = 0; // Initialize total cart price
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Cart</title>
    <link href="https://fonts.googleapis.com/css2?family=Hind:wght@400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        * {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

/* Body */
body {
    font-family: 'Hind', sans-serif;
    background-color: #121212;
    color: #f1f1f1;
    padding: 20px;
}

/* Header */
.header {
    background-color: #1e1e1e;
    padding: 20px 0;
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
}

.header .logo {
    color: #f1f1f1;
    font-size: 2rem;
    font-weight: 600;
    margin-left: 20px;
}

.header nav ul {
    display: flex;
    list-style-type: none;
    margin-right: 20px;
}

.header nav ul li {
    margin: 0 15px;
}

.header nav ul li a {
    color: #f1f1f1;
    text-decoration: none;
    font-size: 1rem;
    transition: color 0.3s;
}

.header nav ul li a:hover {
    color: #03a9f4;
}

/* Cart Container */
.cart-container {
    background-color: #1e1e1e;
    padding: 20px;
    border-radius: 10px;
    max-width: 1200px;
    margin: 30px auto;
}

.cart-container h2 {
    color: #f1f1f1;
    font-size: 2rem;
    text-align: center;
    margin-bottom: 20px;
}

/* Cart Table */
.cart-table {
    width: 100%;
    border-collapse: collapse;
    margin-bottom: 20px;
}

.cart-table th, .cart-table td {
    padding: 15px;
    text-align: left;
}

.cart-table th {
    background-color: #333;
    color: #f1f1f1;
}

.cart-table td {
    background-color: #222;
}

.cart-table img {
    max-width: 100px;
    border-radius: 8px;
}

.cart-table input[type="number"] {
    background-color: #333;
    border: 1px solid #555;
    color: #f1f1f1;
    padding: 5px;
    border-radius: 5px;
    width: 60px;
}

/* Buttons */
.update-btn, .checkout-btn {
    background-color: #03a9f4;
    color: #fff;
    border: none;
    padding: 10px 20px;
    font-size: 1rem;
    cursor: pointer;
    border-radius: 5px;
    transition: background-color 0.3s;
}

.update-btn:hover, .checkout-btn:hover {
    background-color: #0288d1;
}

/* Cart Summary */
.cart-summary {
    text-align: center;
    font-size: 1.2rem;
    margin-top: 20px;
}

.cart-summary strong {
    color: #f1f1f1;
}

/* Footer */
footer {
    background-color: #1e1e1e;
    color: #f1f1f1;
    padding: 40px 0;
    margin-top: 40px;
}

footer .footer-content {
    display: flex;
    justify-content: space-between;
    max-width: 1200px;
    margin: 0 auto;
}

footer .footer-content div {
    width: 22%;
}

footer h3 {
    font-size: 1.4rem;
    color: #f1f1f1;
    margin-bottom: 15px;
}

footer p, footer ul li a {
    font-size: 1rem;
    color: #b0b0b0;
    line-height: 1.6;
    margin-bottom: 10px;
}

footer ul {
    list-style-type: none;
}

footer ul li {
    margin: 5px 0;
}

footer ul li a {
    text-decoration: none;
    color: #b0b0b0;
    transition: color 0.3s;
}

footer ul li a:hover {
    color: #03a9f4;
}

footer .social-icons {
    display: flex;
    gap: 15px;
}

footer .social-icons a {
    color: #b0b0b0;
    font-size: 1.5rem;
    transition: color 0.3s;
}

footer .social-icons a:hover {
    color: #03a9f4;
}

footer p {
    text-align: center;
    margin-top: 20px;
    font-size: 1rem;
    color: #888;
}

/* Media Queries */
@media (max-width: 768px) {
    .header nav ul {
        flex-direction: column;
        align-items: center;
    }

    .cart-container {
        padding: 15px;
    }

    .cart-table {
        font-size: 0.9rem;
    }

    .footer-content {
        flex-direction: column;
        align-items: center;
    }

    footer .footer-content div {
        width: 100%;
        margin-bottom: 20px;
    }
}


    </style>
</head>
<header class="header">
        <div class="container">
          <h1 class="logo">GameHaven</h1>
          <nav>
            <ul class="nav-links">
              <li><a href="homepage.php">Home</a></li>
              <li><a href="available_gears.php">Shop Now</a></li>
              <li><a href="share.php">Share</a></li>
              <li><a href="my_profile.php">My profile</a></li>

            </ul>
          </nav>
    </div>
</header>
    <div class="cart-container">
        <h2>Shopping Cart</h2>
        <?php if (mysqli_num_rows($result) > 0): ?>
            <form action="view_cart.php" method="post">
                <table class="cart-table">
                    <thead>
                        <tr>
                            <th>Image</th>
                            <th>Product Name</th>
                            <th>Price</th>
                            <th>Rent for (Days)</th>
                            <th>Total Price</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($row = mysqli_fetch_assoc($result)): ?>
                            <tr>
                                <td><img src="<?php echo $row['gear_image']; ?>" alt="<?php echo $row['gear_name']; ?>"></td>
                                <td><?php echo htmlspecialchars($row['gear_name']); ?></td>
                                <td>BDT<?php echo number_format($row['price'], 2); ?></td>
                                <td>
                                    <input type="number" name="quantity" class="quantity-input" value="<?php echo $row['quantity']; ?>" min="1">
                                    <input type="hidden" name="cart_id" value="<?php echo $row['cart_id']; ?>">
                                </td>
                                <td>BDT<?php echo number_format($row['total_price'], 2); ?></td>
                                <td>
                                    <button type="submit" name="update_cart" class="update-btn">Update</button>
                                </td>
                            </tr>
                            <?php $total_cart_price += $row['total_price']; ?>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </form>
            <div class="cart-summary">
                <strong>Total Price: BDT<?php echo number_format($total_cart_price, 2); ?></strong>
            </div>
            <a href="checkout.php" class="checkout-btn">Checkout</a>
        <?php else: ?>
            <p>Your cart is empty.</p>
        <?php endif; ?>
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

<?php
mysqli_close($conn);
?>



