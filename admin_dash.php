<?php

include 'config.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            display: flex;
        }
        .sidebar {
            width: 250px;
            background-color: #2c3e50;
            color: white;
            height: 100vh;
            padding: 20px;
            box-sizing: border-box;
        }
        .sidebar h2 {
            text-align: center;
            margin-bottom: 20px;
        }
        .sidebar ul {
            list-style-type: none;
            padding: 0;
        }
        .sidebar ul li {
            margin: 15px 0;
        }
        .sidebar ul li a {
            color: white;
            text-decoration: none;
            display: block;
            padding: 10px;
            border-radius: 5px;
        }
        .sidebar ul li a:hover {
            background-color:rgb(14, 12, 12);
        }
        .content {
            flex: 1;
            padding: 20px;
            box-sizing: border-box;
        }
        .dashboard-overview {
            display: flex;
            justify-content: space-around;
            margin-bottom: 20px;
        }
        .dashboard-box {
            background-color: #f4f4f4;
            padding: 20px;
            border-radius: 10px;
            text-align: center;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            width: 30%;
        }
        .dashboard-box h3 {
            margin-bottom: 10px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        table th, table td {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: left;
        }
        table th {
            background-color: #f4f4f4;
        }
        .hidden {
            display: none;
        }
        .logout-button {
        background-color: #2c3e50; 
        color: white;
        padding: 10px;
        width: 100%;
        border: none;
        border-radius: 5px;
        text-align: left;
        cursor: pointer;
        font-size: 16px;
        /* transition: background-color 0.3s ease, box-shadow 0.3s ease; */
        }

        .logout-button:hover {
        background-color:rgb(14, 12, 12);
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
        }

    </style>
</head>
<body>
<div class="sidebar">
    <h2>Admin Dashboard</h2>
    <ul>
        <li><a href="#" onclick="showSection('overview')">Overview</a></li>
        <li><a href="#" onclick="showSection('users')">User Details</a></li>
        <li><a href="#" onclick="showSection('products')">Product Details</a></li>
        <li><a href="#" onclick="showSection('orders')">Orders</a></li>
        <li>
            <form method="POST" action="logout.php" style="display:inline;">
                <button 
                    type="submit" 
                    class="logout-button">
                    Logout
                 </button>
            </form>
        </li>
    </ul>
</div>

    <div class="content">
        <div id="overview" class="section">
            <h2>Dashboard Overview</h2>
            <div class="dashboard-overview">
                <div class="dashboard-box">
                    <h3>Total Users</h3>
                    <p>
                        <?php
                        $user_query = "SELECT COUNT(*) AS total_users FROM user_form WHERE user_type = 'user';";
                        $user_result = mysqli_query($conn, $user_query);
                        $total_users = mysqli_fetch_assoc($user_result)['total_users'];
                        echo $total_users;
                        ?>
                    </p>
                </div>
                <div class="dashboard-box">
                    <h3>Total Products</h3>
                    <p>
                        <?php
                        $product_query = "SELECT COUNT(*) AS total_products FROM gear_list;";
                        $product_result = mysqli_query($conn, $product_query);
                        $total_products = mysqli_fetch_assoc($product_result)['total_products'];
                        echo $total_products;
                        ?>
                    </p>
                </div>
                <div class="dashboard-box">
                    <h3>Total Order Placed</h3>
                    <p>
                        <?php
                        $order_query = "SELECT COUNT(*) AS total_orders FROM orders where order_tracking='Order Placed';";
                        $order_result = mysqli_query($conn, $order_query);
                        $total_orders = mysqli_fetch_assoc($order_result)['total_orders'];
                        echo $total_orders;
                        ?>
                    </p>
                </div>
                <div class="dashboard-box">
                    <h3>Total Order Processing</h3>
                    <p>
                        <?php
                        $order_query = "SELECT COUNT(*) AS total_orders FROM orders where order_tracking='Processing';";
                        $order_result = mysqli_query($conn, $order_query);
                        $total_orders = mysqli_fetch_assoc($order_result)['total_orders'];
                        echo $total_orders;
                        ?>
                    </p>
                </div>
                <div class="dashboard-box">
                    <h3>Total Order Shipped</h3>
                    <p>
                        <?php
                        $order_query = "SELECT COUNT(*) AS total_orders FROM orders where order_tracking='Shipped';";
                        $order_result = mysqli_query($conn, $order_query);
                        $total_orders = mysqli_fetch_assoc($order_result)['total_orders'];
                        echo $total_orders;
                        ?>
                    </p>
                </div>
                <div class="dashboard-box">
                    <h3>Total Order Delivered</h3>
                    <p>
                        <?php
                        $order_query = "SELECT COUNT(*) AS total_orders FROM orders where order_tracking='Delivered';";
                        $order_result = mysqli_query($conn, $order_query);
                        $total_orders = mysqli_fetch_assoc($order_result)['total_orders'];
                        echo $total_orders;
                        ?>
                    </p>
                </div>
                <div class="dashboard-box">
                    <h3>Total Order Cancelled</h3>
                    <p>
                        <?php
                        $order_query = "SELECT COUNT(*) AS total_orders FROM orders where order_tracking='Cancelled';";
                        $order_result = mysqli_query($conn, $order_query);
                        $total_orders = mysqli_fetch_assoc($order_result)['total_orders'];
                        echo $total_orders;
                        ?>
                    </p>
                </div>
            </div>
        </div>


    <div class="content">
        <div id="users" class="section hidden">
            <h2>User Details</h2>
            <?php

                $sql = "SELECT * FROM user_form where user_type='user'";
                $result = $conn->query($sql);
                if ($result->num_rows > 0) {
                    echo "<table><tr><th>ID</th><th>Name</th><th>Email</th><th>Contact no</th><th>Location</th></tr>";
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr><td>{$row['id']}</td><td>{$row['name']}</td><td>{$row['email']}</td><td>{$row['contact_number']}</td><td>{$row['address']}</td></tr>";
                    }
                    echo "</table>";
                } else {
                    echo "No users found.";
                }
            ?>
        </div>

        <div id="products" class="section hidden">
            <h2>Product Details</h2>
            <?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['delete_gear_id'])) {
        // Delete gear
        $gear_id = intval($_POST['delete_gear_id']);
        $delete_query = "DELETE FROM gear_list WHERE id = $gear_id";
        if (mysqli_query($conn, $delete_query)) {
            $message = "Gear with ID #$gear_id has been deleted.";
        } else {
            $message = "Error deleting gear: " . mysqli_error($conn);
        }
    }
    
    if (isset($_POST['mark_sold_gear_id'])) {
        // Mark gear as sold
        $gear_id = intval($_POST['mark_sold_gear_id']);
        $sold_query = "UPDATE gear_list SET status = 'sold' WHERE id = $gear_id";
        if (mysqli_query($conn, $sold_query)) {
            $message = "Gear with ID #$gear_id has been marked as sold.";
        } else {
            $message = "Error marking gear as sold: " . mysqli_error($conn);
        }
    }
}

// Fetch gears for admin
$gear_query = "SELECT g.id, g.gear_name, g.price, g.status, u.name AS owner_name 
               FROM gear_list g 
               JOIN user_form u ON g.user_id = u.id";
$gear_result = mysqli_query($conn, $gear_query);
$gears = mysqli_fetch_all($gear_result, MYSQLI_ASSOC);

?>
        <table>
            <thead>
                <tr>
                    <th>Gear ID</th>
                    <th>Gear Name</th>
                    <th>Owner</th>
                    <th>Price</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Display gear listings
                foreach ($gears as $gear) {
                    echo "<tr>";
                    echo "<td>" . htmlspecialchars($gear['id']) . "</td>";
                    echo "<td>" . htmlspecialchars($gear['gear_name']) . "</td>";
                    echo "<td>" . htmlspecialchars($gear['owner_name']) . "</td>";
                    echo "<td>$" . number_format($gear['price'], 2) . "</td>";
                    echo "<td>" . htmlspecialchars($gear['status']) . "</td>";
                    echo '<td>
                            <form method="POST" style="display:inline;">
                                <input type="hidden" name="mark_sold_gear_id" value="' . $gear['id'] . '">
                                <button type="submit" class="btn" style="background-color: #28a745;">Mark as Sold</button>
                            </form>
                            <form method="POST" style="display:inline;">
                                <input type="hidden" name="delete_gear_id" value="' . $gear['id'] . '">
                                <button type="submit" class="btn" style="background-color: #dc3545;" onclick="return confirm(\'Are you sure you want to delete this gear?\')">Delete</button>
                            </form>
                          </td>';
                    echo "</tr>";
                }
                ?>
            </tbody>
        </table>

        </div>
        <div id="orders" class="section hidden">
            <h2>Orders</h2>
            <?php
            if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_order_id'], $_POST['tracking_status'])) {
                $order_id = intval($_POST['update_order_id']);
                $tracking_status = mysqli_real_escape_string($conn, $_POST['tracking_status']);
            
                $update_query = "UPDATE orders SET order_tracking = '$tracking_status' WHERE id = '$order_id'";
                if (mysqli_query($conn, $update_query)) {
                    $message = "Order #$order_id status updated successfully.";
                } else {
                    $message = "Error updating order: " . mysqli_error($conn);
                }
            }
            // $page = isset($_GET['page']) ? intval($_GET['page']) : 1;
            // $limit = 20; // Orders per page
            // $offset = ($page - 1) * $limit;
            
            $order_query = "SELECT o.id AS order_id, o.total_price, o.shipping_address, o.order_date, o.order_tracking, u.email AS user_email, GROUP_CONCAT(oi.gear_id SEPARATOR ', ') AS gear_ids
                            FROM orders o 
                            JOIN user_form u ON o.user_id = u.id
                            LEFT JOIN order_items oi ON o.id = oi.order_id
                            GROUP BY o.id
                            ORDER BY o.order_date DESC";
            
            $order_result = mysqli_query($conn, $order_query);
            $orders = mysqli_fetch_all($order_result, MYSQLI_ASSOC);
            
            // Count total orders for pagination
            $count_query = "SELECT COUNT(*) AS total_orders FROM orders";
            $count_result = mysqli_query($conn, $count_query);
            $total_orders = mysqli_fetch_assoc($count_result)['total_orders'];
            // $total_pages = ceil($total_orders / $limit);
            
            if (!empty($message)) echo "<p class='message'>$message</p>"; ?>

<table class="orders-table">
    <thead>
        <tr>
            <th>Order ID</th>
            <th>User Email</th>
            <th>Total Price</th>
            <th>Order Date</th>
            <th>Tracking Status</th>
            <th>Shipping Address</th>
            <th>Gear IDs</th>
            <th>Update Status</th>
        </tr>
    </thead>
    <tbody>
    <?php if (!empty($orders)): ?>
                    <?php foreach ($orders as $order): ?>
                        <tr>
                            <td><?php echo $order['order_id']; ?></td>
                            <td><?php echo htmlspecialchars($order['user_email']); ?></td>
                            <td>$<?php echo number_format($order['total_price'], 2); ?></td>
                            <td><?php echo date("F j, Y, g:i a", strtotime($order['order_date'])); ?></td>
                            <td><?php echo htmlspecialchars($order['order_tracking']); ?></td>
                            <td><?php echo htmlspecialchars($order['shipping_address']); ?></td>
                            <td><?php echo htmlspecialchars($order['gear_ids']); ?></td>
                            <td>
                                <form method="POST" class="update-form">
                                    <input type="hidden" name="update_order_id" value="<?php echo $order['order_id']; ?>">
                                    <select name="tracking_status">
                                        <option value="Order Placed" <?php if ($order['order_tracking'] == 'Order Placed') echo 'selected'; ?>>Order Placed</option>
                                        <option value="Processing" <?php if ($order['order_tracking'] == 'Processing') echo 'selected'; ?>>Processing</option>
                                        <option value="Shipped" <?php if ($order['order_tracking'] == 'Shipped') echo 'selected'; ?>>Shipped</option>
                                        <option value="Delivered" <?php if ($order['order_tracking'] == 'Delivered') echo 'selected'; ?>>Delivered</option>
                                        <option value="Cancelled" <?php if ($order['order_tracking'] == 'Cancelled') echo 'selected'; ?>>Cancelled</option>
                                    </select>
                                    <button type="submit">Update</button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="7">No orders found.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>

        </div>
    </div>
        <script>
        document.addEventListener('DOMContentLoaded', () => {
            showSection('overview');
        });

        function showSection(sectionId) {
            document.querySelectorAll('.section').forEach(section => {
                section.classList.add('hidden');
            });
            document.getElementById(sectionId).classList.remove('hidden');
        }
    </script>
</body>
</html>
