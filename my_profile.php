<?php
@include 'config.php';

session_start();

// Redirect to login if not logged in
if (!isset($_SESSION['user_id'])) {
    header('location:login_form.php');
    exit();
}

$user_id = $_SESSION['user_id'];

// Fetch the logged-in user's information
$sql = "SELECT * FROM user_form WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param('s', $user_id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

if (!$user) {
    echo "User not found.";
    exit();
}

// Calculate total listings
$sql_listings = "SELECT COUNT(*) as total_listings FROM gear_list WHERE user_id = ?";
$stmt = $conn->prepare($sql_listings);
$stmt->bind_param('i', $user['id']);
$stmt->execute();
$listings_result = $stmt->get_result();
$total_listings = $listings_result->fetch_assoc()['total_listings'] ?? 0;

// Calculate total earnings
$sql_earnings = "SELECT SUM(price) as total_earnings FROM gear_list WHERE user_id = ? AND status = 'sold'";
$stmt = $conn->prepare($sql_earnings);
$stmt->bind_param('i', $user['id']);
$stmt->execute();
$earnings_result = $stmt->get_result();
$total_earnings = $earnings_result->fetch_assoc()['total_earnings'] ?? 0;

// Fetch user listings
$sql_posts = "SELECT * FROM gear_list WHERE user_id = ?";
$stmt = $conn->prepare($sql_posts);
$stmt->bind_param('i', $user['id']);
$stmt->execute();
$posts_result = $stmt->get_result();

// Check if user has any listings
$has_listings = $posts_result->num_rows > 0;

// Close the database connection
$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Profile</title>
    <link href="https://fonts.googleapis.com/css2?family=Hind:wght@400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
/* Global Styles */
body {
    font-family: 'Hind', sans-serif;
    background-color: #121212; /* Dark background */
    color: #e0e0e0; /* Light text for contrast */
    margin: 0;
    padding: 0;
}

a {
    text-decoration: none;
    color: inherit;
}

h1, h2, h3 {
    color: #e0e0e0;
}

/* Profile Container */
.profile-container {
    max-width: 1200px;
    margin: 0 auto;
    padding: 30px;
    background-color: #1e1e1e; /* Dark container */
    border-radius: 10px;
    box-shadow: 0 10px 20px rgba(0, 0, 0, 0.4);
}

/* Header */
header.header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 30px;
}

header h1 {
    font-size: 2em;
    color: #007bff; /* Accent color */
}

.btn-back {
    padding: 10px 20px;
    background-color: #007bff;
    color: white;
    border-radius: 5px;
    text-transform: uppercase;
    font-weight: bold;
    transition: background-color 0.3s ease;
}

.btn-back:hover {
    background-color: #0056b3;
}

/* Profile Info */
.profile-info {
    display: flex;
    justify-content: space-between;
    margin-bottom: 30px;
}

.profile-pic {
    text-align: center;
}

.profile-pic img {
    width: 150px;
    height: 150px;
    border-radius: 50%;
    object-fit: cover;
    border: 3px solid #007bff;
}

.btn-edit {
    display: inline-block;
    margin-top: 15px;
    padding: 8px 16px;
    background-color: #28a745;
    color: white;
    border-radius: 5px;
    font-size: 0.9em;
    transition: background-color 0.3s ease;
}

.btn-edit:hover {
    background-color: #218838;
}

.profile-details {
    max-width: 60%;
}

.profile-details h2 {
    font-size: 1.8em;
    color: #e0e0e0;
    margin-bottom: 10px;
}

.profile-details p {
    font-size: 1.1em;
    margin-bottom: 10px;
}

/* Profile Stats */
.profile-stats {
    display: flex;
    justify-content: space-around;
    margin-bottom: 30px;
}

.stat {
    background-color: #2c2c2c; /* Darker background for stats */
    padding: 20px;
    border-radius: 8px;
    text-align: center;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.3);
    width: 45%;
}

.stat h3 {
    font-size: 1.4em;
    margin-bottom: 10px;
    color: #007bff;
}

.stat p {
    font-size: 1.2em;
    color: #e0e0e0;
}

/* User Listings Section */
.user-listings {
    margin-top: 50px;
}

.user-listings h2 {
    text-align: center;
    margin-bottom: 20px;
    font-size: 2em;
    color: #e0e0e0;
}

.listings-grid {
    display: flex;
    flex-wrap: wrap;
    gap: 20px;
    justify-content: center;
}

.listing-box {
    background-color: #333; /* Darker background for listings */
    border: 1px solid #444;
    border-radius: 8px;
    padding: 20px;
    text-align: center;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.3);
    transition: transform 0.3s ease, box-shadow 0.3s ease;
    width: calc(20% - 20px);
}

.listing-box:hover {
    transform: translateY(-5px);
    box-shadow: 0 6px 12px rgba(0, 0, 0, 0.4);
}

.listing-box h3 {
    font-size: 1.3em;
    color: #007bff;
    margin-bottom: 15px;
}

.listing-box p {
    font-size: 1em;
    margin: 5px 0;
    color: #bbb; /* Lighter text for listings */
}

/* Responsive Layouts */
@media (max-width: 1200px) {
    .listing-box {
        width: calc(25% - 20px); /* 4 boxes per row */
    }
}

@media (max-width: 992px) {
    .listing-box {
        width: calc(33.33% - 20px); /* 3 boxes per row */
    }
}

@media (max-width: 768px) {
    .listing-box {
        width: calc(50% - 20px); /* 2 boxes per row */
    }
}

@media (max-width: 576px) {
    .listing-box {
        width: 100%; /* 1 box per row */
    }
}

/* Footer */
footer {
    padding: 30px 0;
    background-color: #121212; /* Dark footer */
    color: #bbb;
    text-align: center;
}

footer .footer-content {
    display: flex;
    justify-content: space-between;
    gap: 20px;
    flex-wrap: wrap;
}

footer h3 {
    font-size: 18px;
    color: #e0e0e0;
}

footer p, footer a {
    font-size: 14px;
    color: #bbb;
    text-decoration: none;
}

footer a:hover {
    text-decoration: underline;
}

footer .social-icons {
    display: flex;
    gap: 10px;
}

footer .social-icons a {
    color: #bbb;
    font-size: 20px;
}

/* Footer Responsive */
@media (max-width: 768px) {
    footer .container {
        flex-direction: column;
        align-items: center;
    }
}


    </style>
</head>
<body>
    <div class="profile-container">
        <header class="header">
            <h1>My Profile</h1>
            <a href="homepage.php" class="btn-back">Back to Home</a>
        </header>
        
        <section class="profile-info">
            <div class="profile-pic">
                <img src="<?= htmlspecialchars($user['profile_pic'] ?? 'images/default-profile.png'); ?>" alt="Profile Picture">
                <a href="edit_profile.php" class="btn-edit">Edit Profile</a>
            </div>
            <div class="profile-details">
                <h2><?= htmlspecialchars($user['name']); ?></h2>
                <p><strong>Address:</strong> <?= htmlspecialchars($user['address'] ?? 'Not provided'); ?></p>
                <p><strong>Birthdate:</strong> <?= htmlspecialchars($user['birthdate'] ?? 'Not provided'); ?></p>
                <p><strong>Bio:</strong> <?= htmlspecialchars($user['bio'] ?? 'No bio available'); ?></p>
                <p><strong>Contact Number:</strong> <?= htmlspecialchars($user['contact_number'] ?? 'Not provided'); ?></p>
            </div>
        </section>

        <section class="profile-stats">
            <div class="stat">
                <h3>Total Earnings</h3>
                <p><?= htmlspecialchars(number_format($total_earnings, 2)); ?> BDT</p>
                <?php if ($total_earnings <= 0): ?>
                    <p>No earnings yet.</p>
                <?php endif; ?>
            </div>
            <div class="stat">
                <h3>Total Listings</h3>
                <p><?= htmlspecialchars($total_listings); ?></p>
                <?php if (!$has_listings): ?>
                    <p>No listings yet.</p>
                <?php endif; ?>
            </div>
        </section>

        <section class="user-listings">
    <h2>Your Listings</h2>
    <?php if ($has_listings): ?>
        <div class="listings-grid">
            <?php while ($post = $posts_result->fetch_assoc()): ?>
                <div class="listing-box">
                    <h3><?= htmlspecialchars($post['gear_name']); ?></h3>
                    <p><strong>Price:</strong> <?= htmlspecialchars($post['price']); ?> BDT</p>
                    <p><strong>Status:</strong> <?= htmlspecialchars($post['status']); ?></p>
                </div>
            <?php endwhile; ?>
        </div>
    <?php else: ?>
        <p>No listings yet.</p>
    <?php endif; ?>
</section>

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


