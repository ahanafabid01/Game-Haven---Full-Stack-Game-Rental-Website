<?php
// Database connection
@include 'config.php';


// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle Add to Cart Action
if (isset($_POST['add_to_cart'])) {
    $gear_id = $_POST['gear_id'];
    $gear_name = $_POST['gear_name'];
    $price = $_POST['price'];
    $gear_image = $_POST['gear_image'];

    // Check if the item already exists in the cart
    $check_cart = "SELECT * FROM cart WHERE gear_id = $gear_id";
    $result_cart = $conn->query($check_cart);

    if ($result_cart->num_rows > 0) {
        // If item exists, update quantity
        $update_cart = "UPDATE cart SET quantity = quantity + 1 WHERE gear_id = $gear_id";
        $conn->query($update_cart);
    } else {
        // If item doesn't exist, insert into cart
        $insert_cart = "INSERT INTO cart (gear_id, gear_name, price, gear_image, quantity) 
                        VALUES ('$gear_id', '$gear_name', '$price', '$gear_image', 1)";
        $conn->query($insert_cart);
    }
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
    <title>Search Items</title>
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

body {
    font-family: 'Hind', sans-serif;
    background-color: #121212; /* Dark background */
    color: #d1d1d1; /* Light grey text for readability */
    line-height: 1.6;
}

/* Header */
header {
    background-color: #1e1e1e;
    padding: 1rem 0;
}

header .logo {
    color: #74b9ff;
    font-size: 1.5rem;
    text-align: center;
    text-transform: uppercase;
    font-weight: 600;
}

header nav ul {
    display: flex;
    justify-content: center;
    gap: 2rem;
}

header nav ul li {
    list-style: none;
}

header nav ul li a {
    color: #d1d1d1;
    text-decoration: none;
    font-size: 1.2rem;
    font-weight: 500;
    transition: color 0.3s ease;
}

header nav ul li a:hover {
    color: #74b9ff;
}

/* Main Content */
h2 {
    text-align: center;
    margin: 2rem 0;
    color: #74b9ff;
}

.search-container {
    display: flex;
    justify-content: center;
    margin-bottom: 2rem;
}

form {
    display: flex;
    flex-wrap: wrap;
    gap: 1rem;
    background: #2d3436;
    padding: 1rem;
    border-radius: 8px;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    width: 80%;
}

input,
button {
    padding: 0.75rem;
    font-size: 1rem;
    border: 1px solid #444;
    border-radius: 5px;
}

input {
    flex: 1;
    background-color: #333;
    color: #d1d1d1;
}

button {
    background-color: #0984e3;
    color: #fff;
    border: none;
    cursor: pointer;
    transition: background-color 0.3s;
}

button:hover {
    background-color: #74b9ff;
}

/* Results Section */
.results-container {
    width: 80%;
    margin: 0 auto;
    display: flex;
    flex-direction: column;
    gap: 1.5rem;
}

.gear-item {
    display: flex;
    background: #2d3436;
    border-radius: 8px;
    overflow: hidden;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.3);
}

.gear-item img {
    width: 150px;
    height: 150px;
    object-fit: cover;
}

.gear-details {
    padding: 1rem;
    flex: 1;
}

.gear-details h3 {
    margin: 0;
    font-size: 1.25rem;
    color: #fff;
}

.gear-details p {
    margin: 0.5rem 0;
    color: #d1d1d1;
}

form.add-to-cart {
    margin-top: 1rem;
}

form.add-to-cart button {
    background-color: #28a745;
    padding: 0.5rem 1rem;
    border: none;
    border-radius: 5px;
    color: #fff;
    cursor: pointer;
    transition: background-color 0.3s;
}

form.add-to-cart button:hover {
    background-color: #218838;
}

/* No Results Message */
.no-results {
    text-align: center;
    color: #bbb;
}

/* Footer */
footer {
    background-color: #1e1e1e;
    padding: 50px 20px;
    color: #d1d1d1;
    text-align: center;
    margin-top: 2rem;
}

footer .footer-content {
    display: flex;
    justify-content: space-around;
    margin-bottom: 20px;
}

footer .footer-content div {
    width: 25%;
}

footer .footer-content h3 {
    font-size: 1.2rem;
    margin-bottom: 10px;
    color: #74b9ff;
}

footer .footer-content ul {
    list-style: none;
}

footer .footer-content ul li {
    margin-bottom: 10px;
}

footer .footer-content ul li a {
    text-decoration: none;
    color: #74b9ff;
    font-size: 1rem;
}

footer .footer-content ul li a:hover {
    text-decoration: underline;
}

footer .social-icons a {
    color: #74b9ff;
    font-size: 1.5rem;
    margin-right: 15px;
    transition: color 0.3s ease;
}

footer .social-icons a:hover {
    color: #0984e3;
}

footer p {
    font-size: 1rem;
    margin-top: 20px;
}

/* Responsive Layout */
@media (max-width: 768px) {
    .results-container {
        width: 100%;
    }

    footer .footer-content {
        flex-direction: column;
        align-items: center;
    }

    footer .footer-content div {
        width: 100%;
        text-align: center;
        margin-bottom: 20px;
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
<h2>Search for Gear</h2>

<!-- Search Form -->
<div class="search-container">
    <form method="POST" action="search_items.php">
        <input type="text" name="searchTerm" placeholder="Search gear or location..." value="<?php echo htmlspecialchars($searchTerm); ?>" />
        <button type="submit">Search</button>
    </form>
</div>

<!-- Results Section -->
<div class="results-container">
    <?php if (!empty($results)): ?>
        <?php foreach ($results as $row): ?>
            <div class="gear-item">
            <a href="product_detail_page.php?id=<?= $row['id']; ?>" style="text-decoration: none; color: inherit;">
                            <img src="<?= htmlspecialchars($row['gear_image'], ENT_QUOTES); ?>" alt="<?= htmlspecialchars($row['gear_name'], ENT_QUOTES); ?>"> </a>
                
                <div class="gear-details">
                <a href="product_detail_page.php?id=<?= $row['id']; ?>" style="text-decoration: none; color: inherit;">
                    <h3><?= htmlspecialchars($row['gear_name']); ?> (<?= htmlspecialchars($row['gear_type']); ?>)</h3>
                    <p><?= htmlspecialchars($row['gear_description']); ?></p>
                    <p><strong>Price:</strong> <?= number_format($row['price'], 2); ?> BDT/day</p>
                    <p><strong>Location:</strong> <?= htmlspecialchars($row['location']); ?></p>
                    <p><strong>Available From:</strong> <?= htmlspecialchars($row['availability']); ?></p>
                    <p><strong>Status:</strong> <?= htmlspecialchars($row['status'], ENT_QUOTES); ?></p> </a>

                    <form method="POST" class="add-to-cart">
                        <input type="hidden" name="gear_id" value="<?= $row['id']; ?>">
                        <input type="hidden" name="gear_name" value="<?= htmlspecialchars($row['gear_name']); ?>">
                        <input type="hidden" name="price" value="<?= $row['price']; ?>">
                        <input type="hidden" name="gear_image" value="<?= htmlspecialchars($row['gear_image']); ?>">
                        <button type="submit" name="add_to_cart">Add to Cart</button>
                    </form>
                </div>
            </div>
        <?php endforeach; ?>
    <?php elseif ($_SERVER["REQUEST_METHOD"] == "POST" && !isset($_POST['add_to_cart'])): ?>
        <p class="no-results">No results found for your search criteria.</p>
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
$conn->close();
?>
