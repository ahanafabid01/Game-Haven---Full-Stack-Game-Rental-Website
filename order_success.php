<?php
session_start(); // Resume the session
@include 'config.php';

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    die("Error: You must log in to view this page.");
}

$user_id = $_SESSION['user_id']; // Logged-in user's ID

// Retrieve the most recent order for the logged-in user
$order_query = "
    SELECT o.id AS order_id, o.total_price, o.shipping_address, o.order_date
    FROM orders o
    WHERE o.user_id = '$user_id'
    ORDER BY o.order_date DESC
    LIMIT 1
";
$order_result = mysqli_query($conn, $order_query);

if ($order_result && mysqli_num_rows($order_result) > 0) {
    $order = mysqli_fetch_assoc($order_result);
    $order_id = $order['order_id'];
    $shipping_address = $order['shipping_address'];
    $total_price = $order['total_price'];
    $order_date = $order['order_date'];

    // Retrieve the items for this order
    $items_query = "
        SELECT oi.quantity, oi.price, g.gear_name, g.gear_image
        FROM order_items oi
        INNER JOIN gear_list g ON oi.gear_id = g.id
        WHERE oi.order_id = '$order_id'
    ";
    $items_result = mysqli_query($conn, $items_query);
    $order_items = mysqli_fetch_all($items_result, MYSQLI_ASSOC);
} else {
    die("Error: Unable to fetch your order. Please contact support.");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Success</title>
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

/* Success Container */
.success-container {
    max-width: 800px;
    margin: 50px auto;
    padding: 30px;
    background-color: #2c2c2c;
    border-radius: 8px;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.2);
}

h2 {
    text-align: center;
    color: #28a745;
    font-size: 2rem;
    margin-bottom: 20px;
}

h3 {
    color: #fff;
    font-size: 1.5rem;
    margin-bottom: 15px;
}

/* Order Details */
.order-details p {
    font-size: 1.2rem;
    color: #ddd;
    margin: 10px 0;
}

.order-details strong {
    color: #28a745;
}

.order-items {
    margin-top: 30px;
}

.order-items table {
    width: 100%;
    border-collapse: collapse;
    background-color: #333;
    border-radius: 8px;
    overflow: hidden;
}

.order-items th, .order-items td {
    padding: 15px;
    text-align: left;
    border-bottom: 1px solid #444;
}

.order-items th {
    background-color: #444;
    color: #fff;
}

.order-items td {
    background-color: #222;
    color: #bbb;
}

.order-items img {
    width: 60px;
    height: 60px;
    object-fit: cover;
    border-radius: 6px;
}

/* Action Buttons */
.action-buttons {
    text-align: center;
    margin-top: 30px;
}

.action-buttons a {
    display: inline-block;
    padding: 12px 25px;
    background-color: #007bff;
    color: #fff;
    text-decoration: none;
    border-radius: 5px;
    font-size: 1.1rem;
    transition: background-color 0.3s;
    margin: 10px;
}

.action-buttons a:hover {
    background-color: #0056b3;
}

.action-buttons a.back-btn {
    background-color: #6c757d;
}

.action-buttons a.back-btn:hover {
    background-color: #5a6268;
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
    footer .footer-content {
        flex-direction: column;
        align-items: center;
    }

    footer .footer-content div {
        width: 100%;
        margin-bottom: 20px;
    }

    .order-items table {
        font-size: 0.9rem;
    }

    .action-buttons a {
        font-size: 1rem;
        padding: 10px 20px;
    }
}

 
    </style>
</head>
<body>
    <div class="success-container">
        <h2>Thank You for Your Order!</h2>
        <div class="order-details">
            <h3>Order Summary</h3>
            <p><strong>Order ID:</strong> <?php echo $order_id; ?></p>
            <p><strong>Order Date:</strong> <?php echo date("F j, Y, g:i a", strtotime($order_date)); ?></p>
            <p><strong>Shipping Address:</strong> <?php echo htmlspecialchars($shipping_address); ?></p>
            <p><strong>Total Price:</strong> BDT<?php echo number_format($total_price, 2); ?></p>
        </div>

        <div class="order-items">
            <h3>Ordered Items</h3>
            <table>
                <thead>
                    <tr>
                        <th>Image</th>
                        <th>Product Name</th>
                        <th>Rent for (Days)</th>
                        <th>Price</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($order_items as $item): ?>
                        <tr>
                            <td><img src="<?php echo $item['gear_image']; ?>" alt="<?php echo $item['gear_name']; ?>"></td>
                            <td><?php echo htmlspecialchars($item['gear_name']); ?></td>
                            <td><?php echo $item['quantity']; ?></td>
                            <td>BDT<?php echo number_format($item['price'], 2); ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>

        <div class="action-buttons">
            <a href="homepage.php" class="back-btn">Return to Homepage</a>
            <a href="order_history.php">View Order History</a>
        </div>
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
