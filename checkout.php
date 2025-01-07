<?php
session_start(); // Resume the session

@include 'config.php';
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    die("Error: You must log in to proceed with checkout.");
}

$user_id = $_SESSION['user_id']; // Logged-in user's ID

// Retrieve cart items for the logged-in user
$cart_query = "
    SELECT c.gear_id, c.quantity, g.gear_name, g.price, g.gear_image, (c.quantity * g.price) AS total_price
    FROM cart c
    INNER JOIN gear_list g ON c.gear_id = g.id
    WHERE c.user_id = '$user_id'
";
$cart_result = mysqli_query($conn, $cart_query);

$total_cart_price = 0; // Initialize total cart price
$cart_items = [];

// Fetch cart items and calculate total price
while ($row = mysqli_fetch_assoc($cart_result)) {
    $cart_items[] = $row;
    $total_cart_price += $row['total_price'];
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $shipping_address = mysqli_real_escape_string($conn, $_POST['shipping_address']);

    // Insert the order into the orders table
    $order_query = "INSERT INTO orders (user_id, total_price, shipping_address) VALUES ('$user_id', '$total_cart_price', '$shipping_address')";
    if (mysqli_query($conn, $order_query)) {
        $order_id = mysqli_insert_id($conn); // Get the newly created order ID

        // Insert order items into order_items table
        foreach ($cart_items as $item) {
            $gear_id = $item['gear_id'];
            $quantity = $item['quantity'];
            $price = $item['price'];
            $order_item_query = "INSERT INTO order_items (order_id, gear_id, quantity, price) VALUES ('$order_id', '$gear_id', '$quantity', '$price')";
            mysqli_query($conn, $order_item_query);
        }

        // Clear the user's cart after order is placed
        $clear_cart_query = "DELETE FROM cart WHERE user_id = '$user_id'";
        mysqli_query($conn, $clear_cart_query);

        // Redirect to a success page or display a success message
        header("Location: order_success.php");
        exit();
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout</title>
    <link href="https://fonts.googleapis.com/css2?family=Hind:wght@400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    
    <style>
/* General Reset */
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
    margin: 0;
    padding: 0;
}

/* Header */
header {
    background-color: #1e1e1e;
    padding: 20px 0;
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.3);
}

header .logo {
    color: #fff;
    font-size: 2rem;
    font-weight: 600;
    margin-left: 20px;
}

header nav ul {
    display: flex;
    justify-content: flex-end;
    list-style-type: none;
    margin-right: 20px;
}

header nav ul li {
    margin: 0 15px;
}

header nav ul li a {
    color: #f1f1f1;
    text-decoration: none;
    font-size: 1rem;
    transition: color 0.3s;
}

header nav ul li a:hover {
    color: #03a9f4;
}

/* Checkout Container */
.checkout-container {
    max-width: 800px;
    margin: 50px auto;
    padding: 20px;
    background: #2c2c2c;
    border-radius: 8px;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.3);
}

/* Checkout Header */
h2 {
    text-align: center;
    margin-bottom: 20px;
    color: #f1f1f1;
}

/* Cart Summary */
.cart-summary {
    margin-bottom: 30px;
}

.cart-summary h3 {
    color: #fff;
    font-size: 1.4rem;
    margin-bottom: 15px;
}

.cart-summary table {
    width: 100%;
    border-collapse: collapse;
}

.cart-summary th, .cart-summary td {
    padding: 10px;
    text-align: left;
    border-bottom: 1px solid #444;
}

.cart-summary th {
    background-color: #333;
    color: #fff;
}

.cart-summary td {
    background-color: #222;
    color: #ddd;
}

.cart-summary img {
    width: 50px;
    height: 50px;
    object-fit: cover;
    border-radius: 4px;
}

.cart-summary p {
    text-align: right;
    font-weight: bold;
    font-size: 1.2rem;
    color: #fff;
}

/* Form */
form {
    display: flex;
    flex-direction: column;
    gap: 20px;
}

form label {
    color: #fff;
    font-size: 1rem;
}

textarea {
    width: 100%;
    padding: 12px;
    font-size: 1rem;
    border: 1px solid #555;
    border-radius: 5px;
    background-color: #333;
    color: #fff;
}

textarea::placeholder {
    color: #aaa;
}

.submit-btn {
    padding: 12px 20px;
    background-color: #28a745;
    color: #fff;
    border: none;
    border-radius: 5px;
    font-size: 1rem;
    cursor: pointer;
    transition: background-color 0.3s;
}

.submit-btn:hover {
    background-color: #218838;
}

/* Footer */
footer {
    background-color: #1e1e1e;
    color: #f1f1f1;
    padding: 40px 0;
    margin-top: 50px;
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
    color: #fff;
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
    header nav ul {
        flex-direction: column;
        align-items: center;
    }

    .checkout-container {
        padding: 15px;
    }

    .cart-summary table {
        font-size: 0.9rem;
    }

    footer .footer-content {
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
<body>
<header class="header">
        <div class="container">
          <h1 class="logo">GameHaven</h1>
          <nav>
            <ul class="nav-links">
              <li><a href="homepage.php">Home</a></li>
              <li><a href="share.php">Share</a></li>
              <li><a href="available_gears.php">Shop More</a></li>
              
            </ul>
          </nav>
    </div>
</header>
    <div class="checkout-container">
        <h2>Checkout</h2>
        <div class="cart-summary">
            <h3>Order Summary</h3>
            <table>
                <thead>
                    <tr>
                        <th>Image</th>
                        <th>Product Name</th>
                        <th>Price</th>
                        <th>Quantity</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($cart_items as $item): ?>
                        <tr>
                            <td><img src="<?php echo $item['gear_image']; ?>" alt="<?php echo $item['gear_name']; ?>"></td>
                            <td><?php echo htmlspecialchars($item['gear_name']); ?></td>
                            <td>BDT<?php echo number_format($item['price'], 2); ?></td>
                            <td><?php echo $item['quantity']; ?></td>
                            <td>BDT<?php echo number_format($item['total_price'], 2); ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <p><strong>Total Price: BDT<?php echo number_format($total_cart_price, 2); ?></strong></p>
        </div>

        <form action="" method="POST">
            <label for="shipping_address">Shipping Address:</label>
            <textarea name="shipping_address" id="shipping_address" rows="5" placeholder="Enter your shipping address" required></textarea>
            <button type="submit" class="submit-btn">Place Order</button>
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
                        <li><a href="privacy_policy_popup.php?show_policy=1">Privacy Policy</a>
                        </li>
                        <li><a href="terms_and_conditions_popup.php?show_terms=1" >Terms and Conditions</a>
                        </li>
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
            <p>&copy; 2024 Game Haven. All Rights Reserved.</p>
        </div>
    </footer>
</body>
</html>

<?php
mysqli_close($conn);
?>
