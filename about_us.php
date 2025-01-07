<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>About Us - GameHaven</title>
  <link rel="stylesheet" href="styles.css">
  <script src="https://kit.fontawesome.com/a076d05399.js"></script> <!-- Font Awesome for social icons -->
  <style>
    /* General Styles */
* {
  margin: 0;
  padding: 0;
  box-sizing: border-box;
}

body {
  font-family: 'Arial', sans-serif;
  background-color: #1c1c1c;
  color: #fff;
  line-height: 1.6;
  padding-top: 60px;
}

h1, h2, h3 {
  color: #00b4d8; /* Stunning cyan color */
}

a {
  color: #00b4d8;
  text-decoration: none;
}

ul {
  list-style: none;
}

/* Header */
.header {
  background: #333;
  padding: 20px 0;
  position: fixed;
  width: 100%;
  top: 0;
  left: 0;
  z-index: 999;
}

.header .container {
  display: flex;
  justify-content: space-between;
  align-items: center;
  padding: 0 20px;
}

.nav-links li {
  display: inline;
  margin: 0 15px;
}

.nav-links li a {
  font-size: 18px;
  text-transform: uppercase;
}

/* About Section */
.about-us, .mission, .vision, .why-choose-us, .offerings {
  padding: 60px 20px;
  margin-top: 80px; /* To offset the header */
}

.container {
  width: 80%;
  margin: 0 auto;
}



/* Footer */
footer {
  background: #333;
  padding: 20px 0;
  margin-top: 60px;
  color: #bbb;
}

.footer-content {
  display: flex;
  justify-content: space-between;
  padding: 0 20px;
}

.footer-content h3 {
  color: #00b4d8;
}

.footer-content ul li {
  margin: 10px 0;
}

.social-icons a {
  margin: 0 10px;
  color: #00b4d8;
  font-size: 20px;
}

.social-icons a:hover {
  color: #fff;
}

/* Hover Effects */
.nav-links li a:hover,
.footer-content ul li a:hover {
  color: #00f9a8; /* Green Hover Effect */
  transition: all 0.3s ease;
}

footer p {
  text-align: center;
  margin-top: 20px;
}

/* Media Queries */
@media (max-width: 768px) {
  .video-container {
    flex-direction: column;
  }

  .gaming-video {
    width: 80%;
    margin-bottom: 20px;
  }
}

  </style>
</head>
<body>
  <!-- Header Section -->
  <header class="header">
    <div class="container">
      <h1 class="logo">GameHaven</h1>
      <nav>
        <ul class="nav-links">
          <li><a href="homepage.php">Home</a></li>
          <li><a href="share.php">Share</a></li>
          <li><a href="available_gears.php">Products</a></li>
          <li><a href="my_profile.php">My Profile</a></li>
        </ul>
      </nav>
    </div>
  </header>

  <!-- About Us Section -->
  <section class="about-us">
    <div class="about-content">
      <h2>About Us</h2>
      <p>Welcome to <strong>GameHaven</strong>, your ultimate destination for everything gaming. We are a passionate team of gamers, developers, and enthusiasts who share a common goal: to bring the best of the gaming world to you. Whether you're a casual player or a competitive gamer, GameHaven is your home for exciting news, reviews, and top-notch gaming products.</p>
    </div>
  </section>

  <!-- Our Mission Section -->
  <section class="mission">
    <div class="container">
      <h3>Our Mission</h3>
      <p>Our mission at GameHaven is to create a community that offers valuable insights, fresh news, and high-quality gaming content. We strive to empower gamers with the tools, knowledge, and products they need to level up their gaming experience.</p>
    </div>
  </section>

  <!-- Our Vision Section -->
  <section class="vision">
    <div class="container">
      <h3>Our Vision</h3>
      <p>Our vision is to become the leading platform that connects gamers globally, providing them with innovative and engaging content. We aim to cultivate a space where gamers can interact, learn, and grow together, while making a lasting impact on the gaming industry.</p>
    </div>
  </section>

  <!-- Why Choose Us Section -->
  <section class="why-choose-us">
    <div class="container">
      <h3>Why Choose Us?</h3>
      <ul>
        <li>Expert Reviews: Get honest and thorough reviews on the latest games and gaming tech.</li>
        <li>Comprehensive Coverage: Stay updated with all the news and trends in the gaming world.</li>
        <li>Strong Community: Join a community of like-minded gamers who share your passion.</li>
        <li>Exclusive Offers: Get access to exclusive deals, discounts, and promotions for gaming gear and accessories.</li>
      </ul>
    </div>
  </section>

  <!-- What We Offer Section -->
  <section class="offerings">
    <div class="container">
      <h3>What We Offer</h3>
      <p>At GameHaven, we offer a range of services and products tailored to enhance your gaming experience:</p>
      <ul>
        <li>Latest Game Reviews</li>
        <li>Exclusive Product Deals</li>
        <li>Gaming Tips & Tricks</li>
        <li>In-Depth Guides</li>
        <li>Interactive Community Engagement</li>
      </ul>
    </div>
  </section>

  <!-- Featured Gaming Videos Section -->

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
            <li><a href="#">About Us</a></li>
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
