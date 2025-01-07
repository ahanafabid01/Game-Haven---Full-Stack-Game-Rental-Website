<?php
@include 'config.php';
session_start();

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header('location:login_form.php');
    exit();
}

$user_id = $_SESSION['user_id'];
$message = "";

// Fetch user details
$query = "SELECT * FROM user_form WHERE id = '$user_id'";
$result = mysqli_query($conn, $query);
$user = mysqli_fetch_assoc($result);

// Update profile details
if (isset($_POST['update_profile'])) {
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $update_query = "UPDATE user_form SET name = '$name', email = '$email' WHERE id = '$user_id'";
    if (mysqli_query($conn, $update_query)) {
        $message = "Profile updated successfully!";
    } else {
        $message = "Failed to update profile.";
    }
}

// Change password
if (isset($_POST['change_password'])) {
    $current_password = md5($_POST['current_password']);
    $new_password = md5($_POST['new_password']);
    $confirm_password = md5($_POST['confirm_password']);

    if ($current_password === $user['password']) {
        if ($new_password === $confirm_password) {
            $password_query = "UPDATE user_form SET password = '$new_password' WHERE id = '$user_id'";
            if (mysqli_query($conn, $password_query)) {
                $message = "Password updated successfully!";
            } else {
                $message = "Failed to update password.";
            }
        } else {
            $message = "New passwords do not match!";
        }
    } else {
        $message = "Current password is incorrect.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Settings</title>
    <link href="https://fonts.googleapis.com/css2?family=Hind:wght@400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">

    <style>
/* Global styles */
/* Global styles */
body {
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    background-color: #121212; /* Dark background for the page */
    color: #f1f1f1; /* Light text for contrast */
    margin: 0;
    padding: 0;
}

.container {
    max-width: 800px;
    margin: 50px auto;
    padding: 30px;
    background-color: #1f1f1f; /* Dark background for the form */
    border-radius: 12px;
    box-shadow: 0 8px 16px rgba(0, 0, 0, 0.4);
}

/* Header */
.header {
    background-color: #333;
    margin: 0;
    padding: 10px;
    text-align: center;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.3);
}

header .logo {
    font-family: 'Impact', Haettenschweiler, 'Arial Narrow Bold', sans-serif;
    font-size: 30px;
    color: #e74c3c; /* Logo color */
    margin: 0;
    text-transform: uppercase;
}

header .nav-links {
    font-family: 'Gill Sans', Calibri, sans-serif;
    margin-top: 20px;
}

header .nav-links li {
    display: inline;
    margin: 0 20px;
}

header .nav-links a {
    color: #ddd; /* Light gray text for links */
    text-decoration: none;
    font-size: 16px;
}

header .nav-links a:hover {
    color: #e74c3c; /* Highlight color on hover */
    text-decoration: underline;
}

/* Settings Page */
h2 {
    font-size: 28px;
    text-align: center;
    margin-bottom: 20px;
    color: #e74c3c; /* Red color for headings */
}

.section {
    margin-bottom: 30px;
}

.section h3 {
    font-size: 22px;
    color: #ddd; /* Light gray for section titles */
    margin-bottom: 10px;
}

/* Form Inputs */
.form-group {
    margin-bottom: 20px;
}

.form-group label {
    display: block;
    color: #bbb; /* Light gray for labels */
    margin-bottom: 8px;
    font-size: 14px;
}

.form-group input {
    width: 100%;
    padding: 12px;
    font-size: 14px;
    border: 1px solid #444; /* Dark borders */
    border-radius: 8px;
    background-color: #333; /* Dark background for inputs */
    color: #f1f1f1; /* Light text inside input fields */
}

.form-group input:focus {
    border-color: #0984e3; /* Blue border on focus */
    outline: none;
    background-color: #444; /* Slightly lighter background on focus */
}

.btn {
    padding: 12px 20px;
    background-color: #0984e3; /* Blue button background */
    color: #fff;
    border: none;
    border-radius: 8px;
    font-size: 16px;
    cursor: pointer;
    width: 100%;
    text-align: center;
    transition: background-color 0.3s, box-shadow 0.3s;
}

.btn:hover {
    background-color: #74b9ff; /* Lighter blue on hover */
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
}

/* Messages (Success/Error) */
.message, .error {
    text-align: center;
    font-size: 16px;
    margin-bottom: 20px;
}

.message {
    color: #27ae60; /* Green color for success messages */
}

.error {
    color: #e74c3c; /* Red color for error messages */
}

/* Footer */
footer {
    background-color: #333;
    padding: 40px 20px;
    text-align: center;
    font-size: 14px;
    color: #f1f1f1;
}

footer .footer-content {
    max-width: 1200px;
    margin: 0 auto;
    display: flex;
    justify-content: space-between;
    flex-wrap: wrap;
    gap: 30px;
}

footer .footer-content div {
    flex: 1;
    min-width: 250px;
    max-width: 300px;
}

footer .footer-content h3 {
    font-size: 18px;
    margin-bottom: 10px;
    color: #e74c3c; /* Red color for footer headings */
}

footer .footer-content p, footer .footer-content ul, footer .footer-content li {
    font-size: 14px;
    color: #bbb; /* Light gray text for footer content */
}

footer .footer-content ul {
    list-style: none;
    padding: 0;
}

footer .footer-content li {
    margin: 5px 0;
}

footer .footer-content a {
    text-decoration: none;
    color: #0984e3; /* Blue links */
}

footer .footer-content a:hover {
    text-decoration: underline;
}

footer .social-icons a {
    color: #ddd;
    font-size: 18px;
    margin: 0 10px;
    transition: color 0.3s ease;
}

footer .social-icons a:hover {
    color: #0984e3; /* Blue color on hover for social icons */
}

/* Responsive adjustments */
@media (max-width: 768px) {
    footer .footer-content {
        flex-direction: column;
        text-align: center;
    }

    footer .footer-content div {
        margin-bottom: 20px;
    }

    .section h3 {
        font-size: 20px;
    }

    .form-group input {
        font-size: 16px;
    }

    .btn {
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
              <li><a href="share.php">Share</a></li>

              <li><a href="my_profile.php">My Profile</a></li>
            </ul>
          </nav>
    </div>
</header>
<div class="container">
    <h2>Settings</h2>

    <?php if (!empty($message)): ?>
        <p class="message"><?= $message ?></p>
    <?php endif; ?>

    <!-- Update Profile Section -->
    <div class="section">
        <h3>Update Profile</h3>
        <form action="" method="POST">
            <div class="form-group">
                <label for="name">Full Name</label>
                <input type="text" name="name" id="name" value="<?= htmlspecialchars($user['name']) ?>" required>
            </div>
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" name="email" id="email" value="<?= htmlspecialchars($user['email']) ?>" required>
            </div>
            <button type="submit" name="update_profile" class="btn">Save Changes</button>
        </form>
    </div>

    <!-- Change Password Section -->
    <div class="section">
        <h3>Change Password</h3>
        <form action="" method="POST">
            <div class="form-group">
                <label for="current_password">Current Password</label>
                <input type="password" name="current_password" id="current_password" required>
            </div>
            <div class="form-group">
                <label for="new_password">New Password</label>
                <input type="password" name="new_password" id="new_password" required>
            </div>
            <div class="form-group">
                <label for="confirm_password">Confirm New Password</label>
                <input type="password" name="confirm_password" id="confirm_password" required>
            </div>
            <button type="submit" name="change_password" class="btn">Change Password</button>
        </form>
    </div>

    <!-- Account Settings Section -->
    <div class="section">
        <h3>Change Account</h3>
        <form action="logout.php" method="POST">
            <button type="submit" class="btn">Log Out</button>
        </form>
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
