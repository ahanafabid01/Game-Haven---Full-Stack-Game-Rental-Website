<?php
session_start();
@include 'config.php'; // Include database connection

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Get the logged-in user's ID
$user_id = $_SESSION['user_id'];

// Fetch user's gear listings from the database
$query = "SELECT id, gear_name, gear_type, price, gear_description, gear_image, availability, location, status 
          FROM gear_list WHERE user_id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

// Handle delete requests
if (isset($_GET['delete'])) {
    $listing_id = intval($_GET['delete']);
    $delete_query = "DELETE FROM gear_list WHERE id = ? AND user_id = ?";
    $delete_stmt = $conn->prepare($delete_query);
    $delete_stmt->bind_param("ii", $listing_id, $user_id);
    if ($delete_stmt->execute()) {
        header("Location: my_listing.php?success=Listing deleted successfully");
        exit();
    } else {
        $error = "Failed to delete listing.";
    }
}

// Handle marking items as sold
if (isset($_GET['mark_sold'])) {
    $listing_id = intval($_GET['mark_sold']);
    $sold_query = "UPDATE gear_list SET status = 'Sold' WHERE id = ? AND user_id = ?";
    $sold_stmt = $conn->prepare($sold_query);
    $sold_stmt->bind_param("ii", $listing_id, $user_id);
    if ($sold_stmt->execute()) {
        header("Location: my_listing.php?success=Listing marked as sold");
        exit();
    } else {
        $error = "Failed to mark listing as sold.";
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Listings</title>
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
    background-color: #1c1c1c;
    padding: 20px 0;
    color: #fff;
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.3);
}

header .logo {
    font-size: 2rem;
    font-weight: 600;
    color: #28a745;
    margin-left: 20px;
}

header nav {
    float: right;
    margin-right: 20px;
}

header .nav-links {
    list-style: none;
    display: flex;
    gap: 15px;
}

header .nav-links li {
    display: inline;
}

header .nav-links li a {
    color: #f1f1f1;
    text-decoration: none;
    font-size: 1.1rem;
    transition: color 0.3s ease;
}

header .nav-links li a:hover {
    color: #28a745;
}

/* Main Container */
.container {
    max-width: 1200px;
    margin: 40px auto;
    padding: 20px;
    background-color: #1e1e1e;
    border-radius: 8px;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.3);
}

/* Heading */
h1 {
    text-align: center;
    font-size: 2.5rem;
    color: #28a745;
    margin-bottom: 20px;
}

/* Success and Error Messages */
.success {
    text-align: center;
    color: #28a745;
    font-size: 1.2rem;
    margin: 20px 0;
}

.error {
    text-align: center;
    color: #dc3545;
    font-size: 1.2rem;
    margin: 20px 0;
}

/* Listings Table */
.listing-table {
    width: 100%;
    margin-top: 20px;
    border-collapse: collapse;
}

.listing-table th, .listing-table td {
    padding: 15px;
    text-align: center;
    border: 1px solid #333;
}

.listing-table th {
    background-color: #2c2c2c;
    color: #fff;
    font-weight: bold;
}

.listing-table td {
    background-color: #333;
    color: #f1f1f1;
}

.listing-table td img {
    max-width: 100px;
    border-radius: 5px;
}

/* Actions (Edit, Delete, Mark Sold) */
.btn {
    padding: 8px 15px;
    margin: 5px;
    border-radius: 5px;
    font-size: 1rem;
    cursor: pointer;
    transition: background-color 0.3s ease;
}

.btn.edit {
    background-color: #007bff;
    color: #fff;
    text-decoration: none;
}

.btn.edit:hover {
    background-color: #0056b3;
}

.btn.delete {
    background-color: #dc3545;
    color: #fff;
    text-decoration: none;
}

.btn.delete:hover {
    background-color: #a71d2a;
}

.btn.sold {
    background-color: #ffc107;
    color: #fff;
    text-decoration: none;
}

.btn.sold:hover {
    background-color: #e0a800;
}

/* No Listings Message */
.no-listings {
    text-align: center;
    font-size: 1.2rem;
    color: #ccc;
    margin-top: 20px;
}

/* Footer */
footer {
    background-color: #1c1c1c;
    color: #f1f1f1;
    padding: 40px 20px;
    margin-top: 50px;
    text-align: center;
}

footer .footer-content {
    display: flex;
    justify-content: space-between;
    max-width: 1200px;
    margin: 0 auto;
    gap: 20px;
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
    color: #28a745;
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
    color: #28a745;
}

footer p {
    margin-top: 20px;
    font-size: 1rem;
    color: #888;
}

/* Media Queries */
@media (max-width: 768px) {
    header .nav-links {
        flex-direction: column;
        align-items: center;
    }

    footer .footer-content {
        flex-direction: column;
        align-items: center;
    }

    footer .footer-content div {
        width: 100%;
        margin-bottom: 20px;
    }

    .listing-table th, .listing-table td {
        font-size: 0.9rem;
        padding: 10px;
    }

    .listing-table td img {
        max-width: 80px;
    }

    .btn {
        font-size: 0.9rem;
        padding: 7px 12px;
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
              <li><a href="available_gears.php">All Products</a></li>
              <li><a href="my_profile.php">My Profile</a></li>
            </ul>
          </nav>
    </div>
</header>
    <div class="container">
        <h1>My Listings</h1>

        <!-- Display success or error messages -->
        <?php if (isset($_GET['success'])): ?>
            <p class="success"><?php echo htmlspecialchars($_GET['success']); ?></p>
        <?php elseif (isset($error)): ?>
            <p class="error"><?php echo htmlspecialchars($error); ?></p>
        <?php endif; ?>

        <?php if ($result->num_rows > 0): ?>
            <table class="listing-table">
                <thead>
                    <tr>
                        <th>Image</th>
                        <th>Name</th>
                        <th>Type</th>
                        <th>Price ($)</th>
                        <th>Description</th>
                        <th>Availability</th>
                        <th>Location</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td><img src="<?php echo htmlspecialchars($row['gear_image']); ?>" alt="Gear Image"></td>
                            <td><?php echo htmlspecialchars($row['gear_name']); ?></td>
                            <td><?php echo htmlspecialchars($row['gear_type']); ?></td>
                            <td><?php echo number_format($row['price'], 2); ?></td>
                            <td><?php echo htmlspecialchars($row['gear_description']); ?></td>
                            <td><?php echo htmlspecialchars($row['availability']); ?></td>
                            <td><?php echo htmlspecialchars($row['location']); ?></td>
                            <td><?php echo htmlspecialchars($row['status']); ?></td>
                            <td>
                                <a href="edit_listing.php?id=<?php echo $row['id']; ?>" class="btn edit">Edit</a>
                                <a href="my_listing.php?delete=<?php echo $row['id']; ?>" class="btn delete" onclick="return confirm('Are you sure you want to delete this listing?');">Delete</a>
                                <?php if ($row['status'] !== 'Sold'): ?>
                                    <a href="my_listing.php?mark_sold=<?php echo $row['id']; ?>" class="btn sold" onclick="return confirm('Mark this listing as sold?');">Mark as Sold</a>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p class="no-listings">You have no listings yet.</p>
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
$stmt->close();
$conn->close();
?>
