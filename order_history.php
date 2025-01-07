<?php
session_start(); // Start session to get user info
@include 'config.php';

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    die("Error: You must log in to view your order history.");
}

$user_id = $_SESSION['user_id']; // Get user ID

// Initialize filter variables
$start_date = isset($_GET['start_date']) ? $_GET['start_date'] : '';
$end_date = isset($_GET['end_date']) ? $_GET['end_date'] : '';
$tracking_status = isset($_GET['tracking_status']) ? $_GET['tracking_status'] : '';
$min_price = isset($_GET['min_price']) ? $_GET['min_price'] : '';
$max_price = isset($_GET['max_price']) ? $_GET['max_price'] : '';

// Handle Order Cancellation
if (isset($_POST['cancel_order_id'])) {
    $cancel_order_id = intval($_POST['cancel_order_id']);

    // Check if the order is cancellable
    $check_query = "SELECT id FROM orders WHERE id = '$cancel_order_id' AND user_id = '$user_id' AND order_tracking = 'Order Placed'";
    $check_result = mysqli_query($conn, $check_query);

    if (mysqli_num_rows($check_result) > 0) {
        $cancel_query = "UPDATE orders SET order_tracking = 'Cancelled' WHERE id = '$cancel_order_id'";
        if (mysqli_query($conn, $cancel_query)) {
            $message = "Order #$cancel_order_id has been cancelled successfully.";
        } else {
            $message = "Error cancelling the order.";
        }
    } else {
        $message = "Order cannot be cancelled. It may already be processed or delivered.";
    }
}

// Build query for fetching orders with filters
$order_query = "SELECT id AS order_id, total_price, shipping_address, order_date, order_tracking FROM orders WHERE user_id = '$user_id'";

if (!empty($start_date) && !empty($end_date)) {
    $order_query .= " AND DATE(order_date) BETWEEN '$start_date' AND '$end_date'";
}

if (!empty($tracking_status)) {
    $order_query .= " AND order_tracking = '$tracking_status'";
}

if (!empty($min_price) && !empty($max_price)) {
    $order_query .= " AND total_price BETWEEN '$min_price' AND '$max_price'";
}

$order_query .= " ORDER BY order_date DESC";

$order_result = mysqli_query($conn, $order_query);
$orders = mysqli_fetch_all($order_result, MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order History</title>
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

/* Container */
.container {
    max-width: 900px;
    margin: 50px auto;
    padding: 30px;
    background: #1e1e1e;
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
}

/* Form */
form fieldset {
    border: 1px solid #333;
    margin-bottom: 20px;
    padding: 20px;
    border-radius: 8px;
    background: #2a2a2a;
}

form legend {
    font-weight: bold;
    color: #fff;
}

form label {
    color: #ccc;
    margin-right: 10px;
    display: block;
}

form input,
form select,
form button {
    margin-bottom: 10px;
    padding: 12px;
    width: calc(100% - 24px);
    max-width: 400px;
    display: block;
    border-radius: 5px;
    border: 1px solid #444;
    background-color: #333;
    color: #f1f1f1;
}

form button {
    background-color: #007bff;
    color: #fff;
    cursor: pointer;
    transition: background-color 0.3s;
}

form button:hover {
    background-color: #0056b3;
}

/* Order */
.order {
    margin-bottom: 20px;
    padding: 20px;
    background: #2c2c2c;
    border-radius: 8px;
    border: 1px solid #333;
}

.order h3 {
    margin: 0 0 10px;
}

.order p {
    margin: 5px 0;
}

.status {
    font-weight: bold;
    color: #007bff;
}

.cancel-btn {
    background: #dc3545;
    color: white;
    border: none;
    padding: 8px 12px;
    border-radius: 4px;
    cursor: pointer;
    margin-top: 10px;
    transition: background 0.3s;
}

.cancel-btn:hover {
    background: #a71d2a;
}

/* Message */
.message {
    text-align: center;
    color: #28a745;
    margin-bottom: 20px;
}

/* Back Buttons */
.action-buttons {
    text-align: center;
    margin-top: 20px;
}

.action-buttons a {
    display: inline-block;
    padding: 12px 25px;
    margin: 5px;
    background-color: #007bff;
    color: #fff;
    text-decoration: none;
    border-radius: 5px;
    transition: background-color 0.3s;
    font-size: 1.1rem;
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

footer p,
footer ul li a {
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

    .order {
        padding: 15px;
    }

    .order h3 {
        font-size: 1.3rem;
    }

    .order p {
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
    <div class="container">
        <h2>Order History</h2>
        <?php if (!empty($message)) echo "<p class='message'>$message</p>"; ?>

        <form method="GET">
            <fieldset>
                <legend>Filter Orders</legend>
                <label for="start_date">Start Date:</label>
                <input type="date" name="start_date" id="start_date" value="<?php echo htmlspecialchars($start_date); ?>">
                
                <label for="end_date">End Date:</label>
                <input type="date" name="end_date" id="end_date" value="<?php echo htmlspecialchars($end_date); ?>">
                
                <label for="tracking_status">Tracking Status:</label>
                <select name="tracking_status" id="tracking_status">
                    <option value="">All</option>
                    <option value="Order Placed" <?php if ($tracking_status == 'Order Placed') echo 'selected'; ?>>Order Placed</option>
                    <option value="Processing" <?php if ($tracking_status == 'Processing') echo 'selected'; ?>>Processing</option>
                    <option value="Shipped" <?php if ($tracking_status == 'Shipped') echo 'selected'; ?>>Shipped</option>
                    <option value="Delivered" <?php if ($tracking_status == 'Delivered') echo 'selected'; ?>>Delivered</option>
                    <option value="Cancelled" <?php if ($tracking_status == 'Cancelled') echo 'selected'; ?>>Cancelled</option>
                </select>

                <label for="min_price">Min Price:</label>
                <input type="number" name="min_price" id="min_price" step="0.01" value="<?php echo htmlspecialchars($min_price); ?>">

                <label for="max_price">Max Price:</label>
                <input type="number" name="max_price" id="max_price" step="0.01" value="<?php echo htmlspecialchars($max_price); ?>">

                <button type="submit">Apply Filters</button>
            </fieldset>
        </form>

        <?php if (!empty($orders)): ?>
            <?php foreach ($orders as $order): ?>
                <div class="order">
                    <h3>Order ID: <?php echo $order['order_id']; ?></h3>
                    <p><strong>Date:</strong> <?php echo date("F j, Y, g:i a", strtotime($order['order_date'])); ?></p>
                    <p><strong>Total Price:</strong> $<?php echo number_format($order['total_price'], 2); ?></p>
                    <p><strong>Status:</strong> <span class="status"><?php echo htmlspecialchars($order['order_tracking']); ?></span></p>
                    <p><strong>Shipping Address:</strong> <?php echo htmlspecialchars($order['shipping_address']); ?></p>
                    <?php if ($order['order_tracking'] == 'Order Placed'): ?>
                        <form method="POST">
                            <input type="hidden" name="cancel_order_id" value="<?php echo $order['order_id']; ?>">
                            <button type="submit" class="cancel-btn">Cancel Order</button>
                        </form>
                    <?php endif; ?>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p>No orders found.</p>
        <?php endif; ?>
    </div>
    <div class="action-buttons">
            <a href="homepage.php" class="back-btn">Return to Homepage</a>
            <!-- <a href="order_success.php">Previous Page</a> -->
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

