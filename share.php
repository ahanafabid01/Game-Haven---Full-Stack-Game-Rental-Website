<?php
@include 'config.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Share | GameHaven</title>
  <link href="https://fonts.googleapis.com/css2?family=Hind:wght@400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
  <style>
    /* General Reset */
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
    line-height: 1.6;
    padding: 0;
    margin: 0;
}

/* Header */
header {
    background-color: #1a1a1a;
    padding: 20px 0;
}

header .logo {
    font-size: 2.5rem;
    font-weight: 600;
    color: #28a745;
    text-align: center;
}

header nav {
    display: flex;
    justify-content: center;
    margin-top: 15px;
}

header .nav-links {
    list-style: none;
    display: flex;
    gap: 25px;
}

header .nav-links li {
    display: inline;
}

header .nav-links li a {
    text-decoration: none;
    color: #ddd;
    font-size: 1.1rem;
    font-weight: 500;
    transition: color 0.3s ease;
}

header .nav-links li a:hover {
    color: #28a745;
}

/* Share Section */
.share-header {
    text-align: center;
    padding: 40px 20px;
    background-color: #1a1a1a;
    margin-bottom: 30px;
    border-radius: 10px;
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.3);
}

.share-header h2 {
    font-size: 2.5rem;
    color: #28a745;
    margin-bottom: 15px;
}

.share-header p {
    font-size: 1.2rem;
    color: #ddd;
}

/* Share Steps */
.share-steps {
    display: flex;
    justify-content: space-between;
    gap: 20px;
    margin-bottom: 40px;
    flex-wrap: wrap;
}

.step {
    background-color: #1e1e1e;
    border-radius: 10px;
    padding: 20px;
    text-align: center;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
    width: 30%;
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.step img {
    width: 80px;
    height: 80px;
    margin-bottom: 15px;
}

.step h3 {
    font-size: 1.6rem;
    color: #28a745;
    margin-bottom: 10px;
}

.step p {
    font-size: 1rem;
    color: #bbb;
}

.step:hover {
    transform: translateY(-5px);
    box-shadow: 0 6px 12px rgba(0, 0, 0, 0.4);
}

@media (max-width: 768px) {
    .step {
        width: 100%;
        margin-bottom: 20px;
    }
}

/* Call to Action Section */
.share-cta {
    text-align: center;
    margin-top: 30px;
}

.share-cta h3 {
    font-size: 2rem;
    color: #28a745;
    margin-bottom: 10px;
}

.share-cta p {
    font-size: 1.2rem;
    color: #ddd;
    margin-bottom: 20px;
}

.share-cta .cta-button {
    background-color: #28a745;
    color: #fff;
    font-size: 1.3rem;
    padding: 15px 30px;
    border: none;
    border-radius: 8px;
    cursor: pointer;
    text-decoration: none;
    transition: background-color 0.3s ease;
}

.share-cta .cta-button:hover {
    background-color: #218838;
}

/* Footer */
footer {
    background-color: #1c1c1c;
    color: #f1f1f1;
    padding: 40px 20px;
    text-align: center;
    margin-top: 50px;
}

footer .footer-content {
    display: flex;
    justify-content: space-between;
    gap: 30px;
    max-width: 1200px;
    margin: 0 auto;
    flex-wrap: wrap;
}

footer .footer-content div {
    width: 22%;
    margin-bottom: 20px;
}

footer h3 {
    font-size: 1.5rem;
    color: #28a745;
    margin-bottom: 10px;
}

footer p, footer ul li a {
    font-size: 1rem;
    color: #bbb;
    line-height: 1.6;
}

footer ul {
    list-style-type: none;
}

footer ul li {
    margin: 5px 0;
}

footer ul li a {
    text-decoration: none;
    color: #bbb;
    transition: color 0.3s ease;
}

footer ul li a:hover {
    color: #28a745;
}

footer .social-icons {
    display: flex;
    gap: 15px;
    justify-content: center;
}

footer .social-icons a {
    color: #bbb;
    font-size: 1.5rem;
    transition: color 0.3s ease;
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
    footer .footer-content {
        flex-direction: column;
        align-items: center;
    }

    footer .footer-content div {
        width: 100%;
        margin-bottom: 20px;
    }

    .share-steps {
        flex-direction: column;
        align-items: center;
    }

    .share-header h2 {
        font-size: 2rem;
    }

    .share-cta .cta-button {
        font-size: 1.1rem;
        padding: 12px 20px;
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
              <li><a href="available_gears.php">All Products</a></li>
              <li><a href="share.php">Share</a></li>
              <li><a href="homepage.php">Home</a></li>
            </ul>
          </nav>
    </div>
</header>
  <section id="share" class="share-section">
    <div class="share-header">
      <h2>💰 Share & Earn</h2>
      <p>Turn your unused gaming gear into a source of income while helping other gamers level up!</p>
    </div>
    <div class="share-content">
      <div class="share-steps">
        <div class="step">
          <img src="images/gear.webp" alt="List Your Gear">
          <h3>📦 List Your Gear</h3>
          <p>Upload your consoles or disks with ease and make them available to other gamers.</p>
        </div>
        <div class="step">
          <img src="images/coonnect.png" alt="Connect with Gamers">
          <h3>🔗 Connect with Gamers</h3>
          <p>Allow others to rent your items and enjoy the joy of shared gaming experiences.</p>
        </div>
        <div class="step">
          <img src="images/money.webp" alt="Earn Money">
          <h3>💵 Earn Money</h3>
          <p>Get paid securely while your gaming gear finds its next player!</p>
        </div>
      </div>
      <div class="share-cta">
        <h3>Ready to Start Sharing?</h3>
        <p>Join the GameHaven community and share your love for gaming!</p>
        <a href="list-gear.php" class="cta-button">List Your Gear Now</a>
      </div>
    </div>
  </section>
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