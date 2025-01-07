<?php

@include 'config.php';

session_start();

if(!isset($_SESSION['user_name'])){
   header('location:login_form.php');
}


// Search Logic
$searchTerm = "";
$results = [];

if ($_SERVER["REQUEST_METHOD"] == "POST" && !isset($_POST['add_to_cart'])) {
  $searchTerm = $conn->real_escape_string($_POST['searchTerm']);

  // SQL query to search gear by name or location
  $sql = "SELECT * FROM gear_list WHERE 
          (gear_name LIKE '%$searchTerm%' OR gear_description LIKE '%$searchTerm%')
          OR (location LIKE '%$searchTerm%')";

    $result = $conn->query($sql);

    if ($result && $result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $results[] = $row;
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>GameHaven</title>
  <link href="https://fonts.googleapis.com/css2?family=Hind:wght@400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
   <link rel="stylesheet" href="css/test.css">
   <style>
 * {
  margin: 0;
  padding: 0;
  box-sizing: border-box;
}

/* Body Styling */
body {
  font-family: 'Arial', sans-serif;
  background-color: #121212; /* Dark background */
  color: #fff; /* Light text for contrast */
}

/* Header Styling */
.header {
  background-color: #1c1c1c; /* Dark grey background */
  padding: 15px 20px;
  display: flex;
  justify-content: space-between;
  align-items: center;
  box-shadow: 0 4px 8px rgba(0, 0, 0, 0.5);
}

/* Container for Content */
.container {
  display: flex;
  justify-content: space-between;
  align-items: center;
  width: 100%;
}

/* Logo Styling */
.logo {
  font-size: 28px;
  font-weight: bold;
  color: #fff;
  text-transform: uppercase;
  letter-spacing: 2px;
  text-decoration: none;
}

/* Navbar Links */
nav {
  flex-grow: 1;
  text-align: center;
}

.nav-links {
  list-style: none;
  display: flex;
  justify-content: center;
  gap: 20px;
}

/* Navbar Link Styles */
.nav-links li {
  display: inline-block;
}

.nav-links a {
  text-decoration: none;
  color: #bbb; /* Light grey color for links */
  font-size: 16px;
  text-transform: uppercase;
  padding: 8px 16px;
  border-radius: 4px;
  transition: all 0.3s ease;
}

/* Hover Effect for Links */
.nav-links a:hover {
  background-color: #333; /* Darker grey background on hover */
  color: #fff; /* White text on hover */
}

/* Search Bar and Profile Menu Container */
.header-right {
  display: flex; /* Use flexbox to align the search bar and profile icon */
  align-items: center; /* Center vertically */
  gap: 15px; /* Space between the search bar and the profile icon */
}

/* Search Bar */
.search-bar form {
  display: flex;
  align-items: center;
  background-color: #333;
  border-radius: 5px;
  padding: 5px 10px;
}

.search-bar input[type="text"] {
  background-color: #444;
  border: none;
  padding: 8px 12px;
  font-size: 14px;
  color: #fff;
  border-radius: 5px;
  width: 250px;
}

.search-bar button {
  background-color: #444;
  border: none;
  color: #fff;
  font-size: 18px;
  cursor: pointer;
  padding: 8px 12px;
  border-radius: 5px;
  margin-left: 5px;
  transition: background-color 0.3s ease;
}

.search-bar button:hover {
  background-color: #555; /* Slightly lighter grey on hover */
}

/* Profile Menu Container */
.profile-menu-container {
  position: relative;
  display: inline-block;
}

/* Profile Icon */
.profile-icon img {
  width: 40px;
  height: 40px;
  border-radius: 50%;
  cursor: pointer;
  transition: all 0.3s ease; /* Smooth transition */
}

/* Hover Effect for Profile Icon */
.profile-icon img:hover {
  transform: scale(1.1); /* Slightly enlarge the icon */
  background-color: #444; /* Darker background color on hover */
  padding: 5px; /* Adds spacing to the icon when hovered */
}

/* Dropdown Menu */
.dropdown-menu {
  display: none;
  position: absolute;
  right: 0;
  top: 40px;
  background-color: #333;
  border-radius: 5px;
  box-shadow: 0 4px 8px rgba(0, 0, 0, 0.5);
  width: 200px;
  z-index: 1000;
  opacity: 0; /* Start with hidden state */
  visibility: hidden; /* Start with hidden visibility */
  transition: opacity 0.3s ease, visibility 0s 0.3s; /* Delay visibility change */
}

.dropdown-menu ul {
  list-style: none;
  padding: 10px 0;
  margin: 0;
}

.dropdown-menu li {
  padding: 10px;
  text-align: left;
}

.dropdown-menu a {
  color: #ccc;
  text-decoration: none;
  display: block;
  padding: 5px 10px;
  font-size: 14px;
  transition: background-color 0.3s ease;
}

/* Hover Effect for Dropdown Links */
.dropdown-menu a:hover {
  background-color: #444;
  color: #fff;
}

/* Show Dropdown when Profile Icon is Hovered */
.profile-menu-container:hover .dropdown-menu {
  display: block;
  opacity: 1; /* Make it visible */
  visibility: visible; /* Ensure it's visible */
  transition: opacity 0.3s ease, visibility 0s 0s; /* Immediately change visibility */
}

/* Responsive Design */
@media (max-width: 768px) {
  .header {
      flex-direction: column;
      align-items: flex-start;
  }

  .container {
      flex-direction: column;
      align-items: flex-start;
      gap: 20px;
  }

  .nav-links {
      justify-content: flex-start;
      width: 100%;
      gap: 15px;
  }

  .search-bar form {
      width: 100%;
      justify-content: space-between;
  }

  .search-bar input[type="text"] {
      width: 70%;
  }

  .profile-menu-container {
      align-self: flex-end;
  }
}

/* Hero Section */
.hero {
  position: relative;
  background-color: #121212;
}

.carousel img {
  width: 100%;
  height: 450px;
  object-fit: cover;
}

.hero-overlay {
  position: absolute;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background: rgba(0, 0, 0, 0.5);
  display: flex;
  justify-content: center;
  align-items: center;
  color: white;
  text-align: center;
}

.hero-content h2 {
  font-size: 2.5rem;
  margin-bottom: 10px;
}

.hero-content p {
  font-size: 1.2rem;
  margin-bottom: 20px;
}

.cta-button {
  background-color: #007bff;
  color: #fff;
  padding: 15px 30px;
  font-size: 1rem;
  border-radius: 5px;
  transition: background 0.3s;
}

.cta-button:hover {
  background-color: #0056b3;
}

/* Featured Items Section */

.featured-section {
  background-color: #1f1f1f;
  padding: 40px 20px;
}

.featured-section h2 {
  font-size: 2rem;
  color: #ffffff;
  margin-bottom: 20px;
  text-align: center;
}

.featured-container {
  display: flex;
  flex-wrap: wrap;
  gap: 20px;
  justify-content: center;
}

.featured-item {
  background-color: #2c2c2c;
  width: 250px;
  border-radius: 10px;
  padding: 15px;
  text-align: center;
  transition: transform 0.3s;
}

.featured-item:hover {
  transform: scale(1.05);
}

.featured-item img {
  width: 100%;
  height: 200px;
  object-fit: cover;
  border-radius: 5px;
  margin-bottom: 15px;
}

.featured-item h3 {
  font-size: 1.2rem;
  color: #ffffff;
  margin-bottom: 10px;
}

.featured-item p {
  font-size: 1rem;
  color: #f1f1f1;
  margin-bottom: 10px;
}

.featured-item button {
  background-color: #28a745;
  color: #ffffff;
  border: none;
  padding: 10px;
  border-radius: 5px;
  cursor: pointer;
  transition: background 0.3s;
}

.featured-item button:hover {
  background-color: #218838;
}

/* Product Section */
.product-section {
  background-color: #181818;
  padding: 40px 20px;
}

.product-section h2 {
  font-size: 2rem;
  color: #ffffff;
  margin-bottom: 20px;
  text-align: center;
}

.product-container {
  display: flex;
  flex-wrap: wrap;
  gap: 20px;
  justify-content: center;
}

.product-item {
  background-color: #2c2c2c;
  width: 250px;
  border-radius: 10px;
  padding: 15px;
  text-align: center;
  transition: transform 0.3s;
}

.product-item:hover {
  transform: scale(1.05);
}

.product-item img {
  width: 100%;
  height: 200px;
  object-fit: cover;
  border-radius: 5px;
  margin-bottom: 15px;
}

.product-item h3 {
  font-size: 1.2rem;
  color: #ffffff;
  margin-bottom: 10px;
}

.product-item p {
  font-size: 1rem;
  color: #f1f1f1;
  margin-bottom: 10px;
}

.product-item button {
  background-color: #007bff;
  color: #ffffff;
  border: none;
  padding: 10px;
  border-radius: 5px;
  cursor: pointer;
  transition: background 0.3s;
}

.product-item button:hover {
  background-color: #0056b3;
}
/* About Us Section */
.about-us {
  background-color: #1f1f1f;
  padding: 60px 20px;
  color: #fff;
  text-align: center;
}

.about-us h2 {
  font-size: 2.5rem;
  color: #fff;
  margin-bottom: 20px;
}

.about-us p {
  font-size: 1.2rem;
  color: #ccc;
  line-height: 1.6;
  margin-bottom: 20px;
}

.about-us .cta-button {
  background-color: #007bff;
  color: #fff;
  padding: 15px 30px;
  font-size: 1.1rem;
  border-radius: 5px;
  text-decoration: none;
  transition: background-color 0.3s ease;
}

.about-us .cta-button:hover {
  background-color: #0056b3;
}

/* Contact Us Section */
.contact-us {
  background-color: #333;
  color: #fff;
  padding: 40px 0;
}

.contact-us h2 {
  font-size: 2.5em;
  margin-bottom: 20px;
}

.contact-us p {
  font-size: 1.2em;
  margin-bottom: 20px;
}

.form-group {
  margin-bottom: 15px;
}

.form-group label {
  display: block;
  margin-bottom: 5px;
}

.form-group input,
.form-group textarea {
  width: 100%;
  padding: 10px;
  background-color: #444;
  color: #fff;
  border: 1px solid #555;
  border-radius: 5px;
}

.contact-btn {
  padding: 10px 20px;
  background-color:#007bff;
  border-radius: 5px;
  color: #fff;
  font-size: 1.2em;
}

.contact-btn:hover {
  background-color:#0056b3;
}

/* Footer Styles */
footer {
  
  background-color: #1f1f1f;
  color: #f1f1f1;
  padding: 40px 20px;
  text-align: center;
}

.footer-content {
  display: flex;
  justify-content: space-between;
  flex-wrap: wrap;
  gap: 40px;
  margin-bottom: 20px;
}

.footer-content h3 {
  font-size: 1.5rem;
  margin-bottom: 10px;
}

.footer-content p,
.footer-content ul li {
  font-size: 1rem;
}

.footer-content ul {
  list-style: none;
}

.footer-content ul li a {
  color: #f1f1f1;
  margin-bottom: 10px;
  display: block;
}

.footer-content ul li a:hover {
  color:#007bff;
}

.social-icons a {
  color: #f1f1f1;
  font-size: 1.5rem;
  margin: 0 10px;
}

.social-icons a:hover {
  color: #007bff;
}

/* Footer Bottom */
footer p {
  font-size: 1rem;
  margin-top: 20px;
  text-align: center;
}

/* Responsive Styles */
@media (max-width: 768px) {
  .header .logo {
      font-size: 20px;
      flex: 1 1 100%;
  }

  .header nav ul {
      flex-direction: column;
      align-items: center;
  }

  .header-right {
      flex-direction: column;
      align-items: center;
  }

  .featured-container,
  .product-container {
      flex-direction: column;
      align-items: center;
  }

  .featured-item, .product-item {
      width: 100%;
      max-width: 300px;
      margin-bottom: 20px;
  }

  .hero-content h2 {
      font-size: 1.8rem;
  }

  .hero-content p {
      font-size: 1rem;
  }

  .cta-button {
      padding: 12px 24px;
      font-size: 0.9rem;
  }

  .contact-us form {
      padding: 20px;
  }

  .footer-content {
      flex-direction: column;
      align-items: center;
  }

  .footer-content ul {
      text-align: center;
  }
}

@media (max-width: 480px) {
  .header .logo {
      font-size: 18px;
  }

  .hero-content h2 {
      font-size: 1.5rem;
  }

  .hero-content p {
      font-size: 0.9rem;
  }

  .cta-button {
      padding: 10px 20px;
      font-size: 0.8rem;
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
              <li><a href="available_gears.php">Products</a></li>
              <li><a href="share.php">Share</a></li>
              <li><a href="about_us.php">About Us</a></li>
              <li><a href="#contact-us">Contact Us</a></li>
            </ul>
          </nav>
          <div class="header-right">
            <div class="search-bar">
            <form method="POST" action="search_items.php">
            <input type="text" name="searchTerm" placeholder="Search gear or location..." value="<?php echo htmlspecialchars($searchTerm); ?>" />
            <button>🔍</button>
            </form>
            </div>
            <div class="profile-menu-container">
              <div class="profile-icon">
                <img src="icons/profile.webp" alt="Profile">
              </div>
              <div class="dropdown-menu">
                <ul>
                  <li><a href="my_profile.php">👤 My Profile</a></li>
                  <li><a href="my_listing.php">🛒 My Listing</a></li>
                  <li><a href="view_cart.php">🛒 My Cart</a></li>
                  <li><a href="order_history.php">📜 Order History</a></li>
                  <li><a href="help.php">❓ Help</a></li>
                  <li><a href="settings.php">⚙️ Settings</a></li>
                  <li><a href="logout.php">🔓 Log Out</a></li>
                </ul>
              </div>
            </div>
        </div>

      </header>

      <section class="hero">
        <div class="carousel">
              <img src="hero/hero4.jpg" alt="Gaming Setup 1">
        </div>
        <div class="hero-overlay">
          <div class="hero-content">
            <h2>Welcome to GameHaven</h2>
            <p>Your ultimate destination for gaming gear on demand! Dive into endless gaming possibilities.</p>
            <a href="available_gears.php" class="cta-button">Explore Now</a>
          </div>
        </div>
      </section>
    <!-- Featured Items Section -->
        <!-- Featured Items Section -->
        <section class="featured-section">
        <div class="container">
            <h2>Featured Items</h2>
            <div class="featured-container">
                <?php
                // Database connection
                @include 'config.php';

                // Check connection
                if ($conn->connect_error) {
                    die("Connection failed: " . $conn->connect_error);
                }

                // Fetch featured items from the last 3 days
                $sql = "SELECT * FROM gear_list WHERE status = 'Available' AND DATEDIFF(CURDATE(), added_date) <= 3 LIMIT 9";
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    // Display each featured item
                    while ($row = $result->fetch_assoc()) {
                        ?>
                        <div class="featured-item">
                        <a href="product_detail_page.php?id=<?= $row['id']; ?>" style="text-decoration: none; color: inherit;">
                            <img src="<?= htmlspecialchars($row['gear_image'], ENT_QUOTES); ?>" alt="<?= htmlspecialchars($row['gear_name'], ENT_QUOTES); ?>">
                            <h3><?= htmlspecialchars($row['gear_name'], ENT_QUOTES); ?></h3>
                        </a>
                            <strong>Price:</strong> 
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
                            <p><strong>Location:</strong> <?= htmlspecialchars($row['location'], ENT_QUOTES); ?></p>
                            <form method="POST" action="add_to_cart.php">
                                <input type="hidden" name="gear_id" value="<?= $row['id']; ?>">
                                <input type="hidden" name="gear_name" value="<?= htmlspecialchars($row['gear_name'], ENT_QUOTES); ?>">
                                <input type="hidden" name="price" value="<?= $row['price']; ?>">
                                <input type="hidden" name="gear_image" value="<?= $row['gear_image']; ?>">
                                <button type="submit">Add to Cart</button>
                            </form>
                        </div>
                        <?php
                    }
                } else {
                    echo "<p>No featured items available at the moment.</p>";
                }

                $conn->close();
                ?>
            </div>
            <div style="text-align: right; margin-top: 20px;">
                <a href="available_gears.php" class="btn btn-primary">View More</a>
            </div>
        </div>
    </section>
    <!-- Console Products Section -->
    <section class="product-section" id="products">
    <div class="container">
        <h2>Consoles</h2>
        <div class="product-container">
            <?php
            @include 'config.php';
            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }

            $sql = "SELECT * FROM gear_list WHERE status = 'Available' AND gear_type = 'console' ORDER BY added_date DESC LIMIT 9";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    ?>
                    <div class="product-item">
                        <a href="product_detail_page.php?id=<?= $row['id']; ?>" style="text-decoration: none; color: inherit;">
                            <img src="<?= htmlspecialchars($row['gear_image'], ENT_QUOTES); ?>" alt="<?= htmlspecialchars($row['gear_name'], ENT_QUOTES); ?>">
                            <h3><?= htmlspecialchars($row['gear_name'], ENT_QUOTES); ?></h3>
                        </a>
                        <p>
                            <strong>Price:</strong> 
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
                        <form method="POST" action="add_to_cart.php">
                            <input type="hidden" name="gear_id" value="<?= $row['id']; ?>">
                            <input type="hidden" name="gear_name" value="<?= htmlspecialchars($row['gear_name'], ENT_QUOTES); ?>">
                            <input type="hidden" name="price" value="<?= $row['price']; ?>">
                            <input type="hidden" name="gear_image" value="<?= $row['gear_image']; ?>">
                            <button type="submit">Add to Cart</button>
                        </form>
                    </div>
                    <?php
                }
            } else {
                echo "<p>No consoles available at the moment.</p>";
            }
            ?>
        </div>
        <div style="text-align: right; margin-top: 20px;">
            <a href="available_gears.php" class="btn btn-primary">View More</a>
        </div>
    </div>
</section>

    <!-- Disk Products Section -->
    <section class="product-section">
        <div class="container">
            <h2>Disks</h2>
            <div class="product-container">
                <?php
                @include 'config.php';
                $sql = "SELECT * FROM gear_list WHERE status = 'Available' AND gear_type = 'disk' ORDER BY added_date DESC LIMIT 9";
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        ?>
                        <div class="product-item">
                        <a href="product_detail_page.php?id=<?= $row['id']; ?>" style="text-decoration: none; color: inherit;">
                            <img src="<?= htmlspecialchars($row['gear_image'], ENT_QUOTES); ?>" alt="<?= htmlspecialchars($row['gear_name'], ENT_QUOTES); ?>">
                            <h3><?= htmlspecialchars($row['gear_name'], ENT_QUOTES); ?></h3>
                        </a>
                        <p>
                            <strong>Price:</strong> 
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
                            <form method="POST" action="add_to_cart.php">
                                <input type="hidden" name="gear_id" value="<?= $row['id']; ?>">
                                <input type="hidden" name="gear_name" value="<?= htmlspecialchars($row['gear_name'], ENT_QUOTES); ?>">
                                <input type="hidden" name="price" value="<?= $row['price']; ?>">
                                <input type="hidden" name="gear_image" value="<?= $row['gear_image']; ?>">
                                <button type="submit">Add to Cart</button>
                            </form>
                        </div>
                        <?php
                    }
                } else {
                    echo "<p>No disks available at the moment.</p>";
                }
                ?>
            </div>
            <div style="text-align: right; margin-top: 20px;">
                <a href="available_gears.php" class="btn btn-primary">View More</a>
            </div>
        </div>
    </section>

    <!-- Accessory Products Section -->
    <section class="product-section">
        <div class="container">
            <h2>Accessories</h2>
            <div class="product-container">
                <?php
                @include 'config.php';
                $sql = "SELECT * FROM gear_list WHERE status = 'Available' AND gear_type = 'accessory' ORDER BY added_date DESC LIMIT 10";
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        ?>
                        <div class="product-item">
                        <a href="product_detail_page.php?id=<?= $row['id']; ?>" style="text-decoration: none; color: inherit;">
                            <img src="<?= htmlspecialchars($row['gear_image'], ENT_QUOTES); ?>" alt="<?= htmlspecialchars($row['gear_name'], ENT_QUOTES); ?>">
                            <h3><?= htmlspecialchars($row['gear_name'], ENT_QUOTES); ?></h3>
                        </a>
                        <p>
                            <strong>Price:</strong> 
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
                            <form method="POST" action="add_to_cart.php">
                                <input type="hidden" name="gear_id" value="<?= $row['id']; ?>">
                                <input type="hidden" name="gear_name" value="<?= htmlspecialchars($row['gear_name'], ENT_QUOTES); ?>">
                                <input type="hidden" name="price" value="<?= $row['price']; ?>">
                                <input type="hidden" name="gear_image" value="<?= $row['gear_image']; ?>">
                                <button type="submit">Add to Cart</button>
                            </form>
                        </div>
                        <?php
                    }
                } else {
                    echo "<p>No accessories available at the moment.</p>";
                }
                $conn->close();
                ?>
            </div>
            <div style="text-align: right; margin-top: 20px;">
                <a href="available_gears.php" class="btn btn-primary">View More</a>
            </div>
        </div>
   </section>
   <section id="about-us" class="about-us" >
  <div class="about-content">
    <h2>About Us</h2>
    <p>Welcome to GameHaven, your ultimate destination for everything gaming. We are a passionate team of gamers, developers, and enthusiasts dedicated to bringing you the latest and greatest in gaming news, reviews, products, and experiences.</p>
    <p>At GameHaven, we believe in the power of games to connect, entertain, and inspire. Whether you’re a casual player or a competitive gamer, we strive to create a community where everyone can come together to share their love for gaming.</p>
    <p>Our mission is simple – to be the go-to platform for all things gaming, offering high-quality content and engaging products that enrich your gaming journey.</p>
    <a href="about_us.php" class="cta-button">Learn More</a>
  </div>
</section>

    <!-- Contact Us Section -->
    <section id="contact-us" class="contact-us">
    <div class="container">
        <h2>Contact Us</h2>
        <p>Have questions or need support? Reach out to us!</p>
        <form action="contact.php" method="POST">
            <div class="form-group">
                <label for="name">Name:</label>
                <input type="text" id="name" name="name" placeholder="Your Name" required>
            </div>
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" placeholder="Your Email" required>
            </div>
            <div class="form-group">
                <label for="message">Message:</label>
                <textarea id="message" name="message" placeholder="Your Message" required></textarea>
            </div>
            <button type="submit" class="contact-btn">Send Message</button>
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
                        <li><a href="#">Home</a></li>
                        <li><a href="about_us.php">About Us</a></li>
                        <li><a href="#contact-us">Contact Us</a></li>
                        <li><a href="help.php">FAQs</a></li>
                        <li><a href="privacy_policy_popup.php?show_policy=1">Privacy Policy</a>
                        </li>
                        <li><a href="terms_and_conditions_popup.php?show_terms=1" >Terms and Conditions</a>
                        </li>
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
                    <p>Email: gamehaven.bd@gmail.com</p>
                    <p>Phone: +880-123-456789</p>
                    <p>Address: Dhaka, Bangladesh</p>
                </div>
            </div>
            <p>&copy; 2024 GameHaven. All Rights Reserved.</p>
        </div>
    </footer>
</body>
</html>