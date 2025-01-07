<?php
@include 'config.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>List Your Gear | GameHaven</title>
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
    color: #f1f1f1; /* Light text */
    line-height: 1.6;
    padding: 0;
    margin: 0;
}

/* Header */
header {
    background-color: #1a1a1a; /* Dark background for the header */
    padding: 40px 20px;
    text-align: center;
    border-bottom: 3px solid #28a745; /* Green border for a clean effect */
}

header .logo {
    font-size: 2.5rem;
    color: #28a745;
    text-transform: uppercase;
    font-weight: bold;
}

header nav ul {
    list-style: none;
    padding: 0;
    display: flex;
    justify-content: center;
    gap: 20px;
}

header nav ul li {
    display: inline-block;
}

header nav ul li a {
    color: #f1f1f1;
    font-size: 1.1rem;
    text-decoration: none;
    transition: color 0.3s ease;
}

header nav ul li a:hover {
    color: #28a745;
}

h2 {
    color: #28a745;
    font-size: 2.4rem;
    margin-top: 20px;
    text-align: center;
}

p {
    color: #ccc;
    font-size: 1.2rem;
    text-align: center;
    margin-bottom: 40px;
}

/* Form Section */
.list-gear-form-section {
    padding: 50px 20px;
    background-color: #1e1e1e; /* Dark background for the form section */
    margin-bottom: 50px;
}

.form-container {
    max-width: 800px;
    margin: 0 auto;
    background-color: #2b2b2b;
    padding: 30px;
    border-radius: 10px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.3);
}

.form-container h2 {
    color: #28a745;
    font-size: 2.2rem;
    margin-bottom: 20px;
    text-align: center;
}

.form-group {
    margin-bottom: 20px;
}

.form-group label {
    font-size: 1.1rem;
    color: #bbb;
    display: block;
    margin-bottom: 8px;
}

.form-group input,
.form-group select,
.form-group textarea {
    width: 100%;
    padding: 12px;
    background-color: #333;
    border: 1px solid #444;
    border-radius: 8px;
    color: #f1f1f1;
    font-size: 1rem;
}

.form-group input:focus,
.form-group select:focus,
.form-group textarea:focus {
    border-color: #28a745;
    outline: none;
}

.form-group textarea {
    resize: vertical;
}

.form-group small {
    color: #888;
    font-size: 0.9rem;
    margin-top: 5px;
    display: block;
}

.submit-btn {
    background-color: #28a745;
    color: #fff;
    font-size: 1.3rem;
    padding: 15px 30px;
    border: none;
    border-radius: 8px;
    cursor: pointer;
    width: 100%;
    transition: background-color 0.3s ease;
}

.submit-btn:hover {
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

    .form-container {
        padding: 20px;
    }

    h2 {
        font-size: 1.8rem;
    }

    .submit-btn {
        font-size: 1.1rem;
        padding: 12px 20px;
    }
}

  </style>
  </head>
<body><header class="header">
        <div class="container">
          <h1 class="logo">GameHaven</h1>
          <nav>
            <ul class="nav-links">
              <li><a href="homepage.php">Home</a></li>
              <li><a href="share.php">Share</a></li>
              <li><a href="#features">Features</a></li>
              <li><a href="contact.html">Contact</a></li>
            </ul>
          </nav>
    </div>

    <h2>List Your Gear</h2>
    <p>Turn your unused gaming gear into earnings by sharing with the gaming community!</p>
  </header>

  <section class="list-gear-form-section">
    <div class="form-container">
      <h2>Enter Your Gear Details</h2>
      <form action="gear.php" method="post" enctype="multipart/form-data">
      <div class="form-group">
        <label for="gear-name">🎮 Gear Name</label>
        <input type="text" id="gear-name" name="gear-name" placeholder="e.g., PlayStation 5" required>
      </div>
      <div class="form-group">
        <label for="gear-type">📦 Gear Type</label>
        <select id="gear-type" name="gear-type" required>
          <option value="console">Console</option>
          <option value="disk">Game Disk</option>
          <option value="accessory">Accessory</option>
        </select>
      </div>
      <div class="form-group">
        <label>Do you want to:</label>
        <div>
          <input type="radio" id="sell" name="transaction-type" value="sell" required>
          <label for="sell">Sell</label>
        </div>
        <div>
          <input type="radio" id="rent" name="transaction-type" value="rent">
          <label for="rent">Rent</label>
        </div>
      </div>
      <div class="form-group">
        <label for="price">💰 Price</label>
        <input type="number" id="price" name="price" placeholder="Enter price in BDT" required>
      </div>
      <div class="form-group">
        <label for="gear-description">📝 Description</label>
        <textarea id="gear-description" name="gear-description" rows="4" placeholder="Describe your gear" required></textarea>
      </div>
      <div class="form-group">
        <label for="gear-image">📸 Upload Image</label>
        <input type="file" id="gear-image" name="gear-image" accept="image/*" required>
      </div>
      <div class="form-group">
        <label for="availability">📅 Availability</label>
        <input type="date" id="availability" name="availability" required>
      </div>
      <div class="form-group">
        <label for="location">📍 Location</label>
        <input type="text" id="location" name="location" placeholder="Enter your city or location" required>
      </div>
      <button type="submit" class="submit-btn">List Your Gear</button>
    </form>
    </div>
  </section>

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
