<?php
session_start();
include 'config.php'; // Replace with your DB connection file

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Fetch available gears
$query = "SELECT * FROM gear_list WHERE status = 'Available'";
$result = $conn->query($query);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Available Gears</title>
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
    background-color: #121212; /* Dark background */
    color: #d1d1d1; /* Light text */
    line-height: 1.6;
    margin: 0;
    padding: 0;
}

/* Header */
header {
    background-color: #1f1f1f;
    padding: 20px 0;
    color: #ffffff;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.3);
}

header .logo {
    color: #03DAC6; /* Light accent color */
    font-size: 2rem;
    font-weight: 600;
    text-align: center;
}

header nav {
    text-align: center;
    margin-top: 10px;
}

header nav ul {
    list-style: none;
    display: inline-block;
}

header nav ul li {
    display: inline;
    margin: 0 15px;
}

header nav ul li a {
    color: #d1d1d1;
    text-decoration: none;
    font-size: 1.1rem;
    transition: color 0.3s ease;
}

header nav ul li a:hover {
    color: #03DAC6; /* Accent color on hover */
}

/* Main Content */
h1 {
    text-align: center;
    padding: 30px;
    color: #03DAC6; /* Accent color */
}

.gear-container {
    display: flex;
    flex-wrap: wrap;
    justify-content: center;
    gap: 20px;
    padding: 20px;
}

.gear-card {
    background-color: #1E1E1E;
    border: 1px solid #03DAC6;
    border-radius: 10px;
    width: 300px;
    padding: 20px;
    text-align: center;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.3);
    transition: transform 0.3s, box-shadow 0.3s;
}

.gear-card:hover {
    transform: scale(1.05);
    box-shadow: 0 6px 12px rgba(0, 0, 0, 0.5);
}

.gear-card img {
    width: 100%;
    height: 200px;
    object-fit: cover;
    border-radius: 10px;
    margin-bottom: 15px;
}

.gear-card h2 {
    color: #BB86FC; /* Lighter purple accent for the gear name */
}

.gear-card p {
    margin: 10px 0;
}

.gear-card button {
    background-color: #03DAC6;
    color: #121212;
    border: none;
    border-radius: 5px;
    padding: 10px 20px;
    cursor: pointer;
    font-size: 16px;
    transition: background-color 0.3s, transform 0.3s;
}

.gear-card button:hover {
    background-color: #BB86FC;
    transform: scale(1.1);
}

/* Footer */
footer {
    padding: 30px 0;
    background-color: #1f1f1f;
    color: #d1d1d1;
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
    color: #03DAC6; /* Accent color */
    margin-bottom: 10px;
}

footer p, footer a {
    font-size: 14px;
    color: #d1d1d1;
    text-decoration: none;
}

footer a:hover {
    text-decoration: underline;
    color: #03DAC6; /* Accent color */
}

footer .social-icons {
    display: flex;
    gap: 10px;
}

footer .social-icons a {
    color: #d1d1d1;
    font-size: 20px;
    transition: color 0.3s ease;
}

footer .social-icons a:hover {
    color: #03DAC6;
}

/* Responsive Layout */
@media (max-width: 768px) {
    .gear-container {
        flex-direction: column;
        align-items: center;
    }

    footer .footer-content {
        flex-direction: column;
        align-items: center;
    }

    footer .footer-content div {
        text-align: center;
        margin-bottom: 20px;
    }

    header nav ul {
        display: block;
    }

    header nav ul li {
        margin: 10px 0;
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
    <h1>Available Gears</h1>
    <div class="gear-container">
        <?php while ($row = $result->fetch_assoc()) { ?>
            <div class="gear-card">
            <a href="product_detail_page.php?id=<?= $row['id']; ?>" style="text-decoration: none; color: inherit;">
                            <img src="<?= htmlspecialchars($row['gear_image'], ENT_QUOTES); ?>" alt="<?= htmlspecialchars($row['gear_name'], ENT_QUOTES); ?>">
                            <h3><?= htmlspecialchars($row['gear_name'], ENT_QUOTES); ?></h3>
                        </a>
                <p>Type: <?php echo $row['gear_type']; ?></p>
                <p>Price:
                            <?php 
                            if ($row['transaction_type'] === 'sell') {
                                echo number_format($row['price'], 2) . " BDT";
                            } elseif ($row['transaction_type'] === 'rent') {
                                echo number_format($row['price'], 2) . " BDT/day";
                            } else {
                                echo "N/A";
                            }
                            ?>
                        </p>
                <p>Location: <?php echo $row['location']; ?></p>
                <form method="POST" action="add_to_cart.php">
                    <input type="hidden" name="gear_id" value="<?php echo $row['id']; ?>">
                    <button type="submit">Add to Cart</button>
                </form>
            </div>
        <?php } ?>
    </div>
        <!-- Footer Section -->
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
$conn->close();
?>
