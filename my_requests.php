<?php
include 'config.php';
session_start();

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header('location:login_form.php');
    exit();
}

$user_id = $_SESSION['user_id'];

// Fetch user requests from the database
$query = "SELECT subject, message, created_at FROM user_queries WHERE user_id = ? ORDER BY created_at DESC";
$stmt = $conn->prepare($query);
$stmt->bind_param('i', $user_id);
$stmt->execute();
$result = $stmt->get_result();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Requests</title>
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

/* Body and Global Styles */
body {
    font-family: 'Hind', sans-serif;
    background-color: #181818;
    color: #f1f1f1;
    line-height: 1.6;
    padding-top: 50px; /* to account for header */
}

/* Header */
header {
    background-color: #1c1c1c;
    color: #f1f1f1;
    padding: 15px 0;
}

header .container {
    display: flex;
    justify-content: space-between;
    align-items: center;
}

header .logo {
    font-size: 24px;
    font-weight: 600;
    color: #f1f1f1;
}

header nav ul {
    list-style: none;
    display: flex;
}

header nav ul li {
    margin: 0 15px;
}

header nav ul li a {
    text-decoration: none;
    color: #f1f1f1;
    font-weight: 500;
}

header nav ul li a:hover {
    color: #ff6347; /* Light coral for hover effect */
}

/* Container */
.container {
    max-width: 1200px;
    margin: 0 auto;
    padding: 20px;
}

/* Page Title */
h2 {
    font-size: 28px;
    font-weight: 600;
    color: #ff6347;
    margin-bottom: 20px;
}

/* Request List */
.request-list {
    list-style: none;
    margin-top: 20px;
}

.request-item {
    background-color: #2a2a2a;
    border-radius: 8px;
    padding: 15px;
    margin-bottom: 15px;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.2);
}

.request-item h3 {
    font-size: 22px;
    font-weight: 600;
    color: #ff6347;
    margin-bottom: 10px;
}

.request-item p {
    font-size: 16px;
    color: #dcdcdc;
    margin-bottom: 10px;
}

.request-item small {
    font-size: 14px;
    color: #b0b0b0;
}

/* Footer */
footer {
    background-color: #1c1c1c;
    color: #f1f1f1;
    padding: 40px 0;
    margin-top: 40px;
}

footer .footer-content {
    display: flex;
    justify-content: space-between;
    flex-wrap: wrap;
}

footer .footer-content div {
    flex: 1;
    margin: 10px;
}

footer h3 {
    font-size: 20px;
    font-weight: 600;
    margin-bottom: 10px;
}

footer ul {
    list-style: none;
}

footer ul li {
    margin: 8px 0;
}

footer ul li a {
    text-decoration: none;
    color: #f1f1f1;
}

footer ul li a:hover {
    color: #ff6347;
}

footer .social-icons a {
    color: #f1f1f1;
    font-size: 20px;
    margin-right: 15px;
}

footer .social-icons a:hover {
    color: #ff6347;
}

footer p {
    font-size: 14px;
    color: #b0b0b0;
    text-align: center;
    margin-top: 20px;
}

/* Responsive Design */
@media (max-width: 768px) {
    header .container {
        flex-direction: column;
        align-items: flex-start;
    }

    header nav ul {
        flex-direction: column;
        align-items: flex-start;
        margin-top: 15px;
    }

    footer .footer-content {
        flex-direction: column;
        align-items: flex-start;
    }

    footer .footer-content div {
        margin-bottom: 20px;
    }

    footer .social-icons a {
        font-size: 18px;
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
                <li><a href="my_profile.php">My Profile</a></li>
                    <li><a href="help.php">Help</a></li>
                </ul>
            </nav>
        </div>
    </header>
    <div class="container">
        <h2>My Submitted Requests</h2>
        <?php if ($result->num_rows > 0): ?>
            <ul class="request-list">
                <?php while ($row = $result->fetch_assoc()): ?>
                    <li class="request-item">
                        <h3><?php echo htmlspecialchars($row['subject']); ?></h3>
                        <p><?php echo nl2br(htmlspecialchars($row['message'])); ?></p>
                        <small>Submitted on: <?php echo date('F j, Y, g:i a', strtotime($row['created_at'])); ?></small>
                    </li>
                <?php endwhile; ?>
            </ul>
        <?php else: ?>
            <p>You have not submitted any requests yet.</p>
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
