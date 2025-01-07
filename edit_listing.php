<?php
session_start();
@include 'config.php'; // Database connection

// Ensure the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Validate listing ID
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    die("Invalid request. No valid listing ID provided.");
}

$listing_id = intval($_GET['id']);
$user_id = $_SESSION['user_id'];

// Fetch listing details
$query = "SELECT * FROM gear_list WHERE id = ? AND user_id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("ii", $listing_id, $user_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    die("No listing found or you are not authorized.");
}

$listing = $result->fetch_assoc();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Sanitize user inputs
    // Gather form data
    $gearName = $conn->real_escape_string($_POST['gear-name']);
    $gearType = $conn->real_escape_string($_POST['gear-type']);
    $price = (float)$_POST['price'];
    $transactionType = $conn->real_escape_string($_POST['transaction-type']);
    $description = $conn->real_escape_string($_POST['gear-description']);
    $availability = $conn->real_escape_string($_POST['availability']);
    $location = $conn->real_escape_string($_POST['location']);
    $status = $conn->real_escape_string($_POST['status']);
    $gearId = (int)$listing['id'];

    // Handle image upload
    if (isset($_FILES['gear-image']) && $_FILES['gear-image']['error'] === UPLOAD_ERR_OK) {
        $targetDir = "uploads/";
        $targetFile = $targetDir . basename($_FILES['gear-image']['name']);
        move_uploaded_file($_FILES['gear-image']['tmp_name'], $targetFile);
        $imagePath = $conn->real_escape_string($targetFile);

        // Update query with image
        $sql = "UPDATE gear_list SET 
                    gear_name = '$gearName', 
                    gear_type = '$gearType', 
                    price = $price, 
                    transaction_type = '$transactionType', 
                    gear_description = '$description', 
                    availability = '$availability', 
                    location = '$location', 
                    status = '$status', 
                    gear_image = '$imagePath' 
                WHERE id = $gearId";
    } else {
        // Update query without image
        $sql = "UPDATE gear_list SET 
                    gear_name = '$gearName', 
                    gear_type = '$gearType', 
                    price = $price, 
                    transaction_type = '$transactionType', 
                    gear_description = '$description', 
                    availability = '$availability', 
                    location = '$location', 
                    status = '$status' 
                WHERE id = $gearId";
    }

    // Execute update query
    if ($conn->query($sql) === TRUE) {
        header("Location: my_listing.php" );
        echo "<p>Listing updated successfully.</p>";
    } else {
        echo "<p>Error updating listing: " . $conn->error . "</p>";
    }

    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Listing</title>
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
    max-width: 800px;
    margin: 40px auto;
    padding: 20px;
    background-color: #1e1e1e;
    border-radius: 8px;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.3);
}

h1 {
    text-align: center;
    font-size: 2.5rem;
    color: #28a745;
    margin-bottom: 30px;
}

/* Form Styles */
form {
    display: grid;
    gap: 20px;
}

.form-group {
    display: flex;
    flex-direction: column;
}

label {
    font-size: 1.1rem;
    color: #ddd;
    margin-bottom: 8px;
}

input, select, textarea {
    padding: 12px;
    font-size: 1rem;
    border: 1px solid #333;
    border-radius: 5px;
    background-color: #333;
    color: #f1f1f1;
    transition: border-color 0.3s ease;
}

input:focus, select:focus, textarea:focus {
    border-color: #28a745;
    outline: none;
}

textarea {
    resize: vertical;
}

/* File Upload */
input[type="file"] {
    padding: 10px;
    border: 1px solid #333;
    background-color: #333;
    color: #f1f1f1;
    font-size: 1rem;
    border-radius: 5px;
}

small {
    font-size: 0.85rem;
    color: #aaa;
}

/* Submit Button */
button[type="submit"] {
    background-color: #28a745;
    color: #fff;
    padding: 12px;
    font-size: 1.2rem;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    transition: background-color 0.3s ease;
    text-align: center;
    width: 100%;
}

button[type="submit"]:hover {
    background-color: #218838;
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

    form {
        gap: 15px;
    }

    button[type="submit"] {
        font-size: 1.1rem;
        padding: 10px;
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
              <li><a href="my_listing.php">My Listing</a></li>
            </ul>
          </nav>
    </div>
</header>
<div class="container">
    <h1>Edit Listing</h1>
    <form method="POST" enctype="multipart/form-data">
        <div class="form-group">
            <label for="gear-name">🎮 Gear Name</label>
            <input type="text" id="gear-name" name="gear-name" value="<?php echo htmlspecialchars($listing['gear_name']); ?>" required>
        </div>

        <div class="form-group">
            <label for="gear-type">📦 Gear Type</label>
            <select id="gear-type" name="gear-type" required>
                <option value="console" <?php if ($listing['gear_type'] === 'console') echo 'selected'; ?>>Console</option>
                <option value="disk" <?php if ($listing['gear_type'] === 'disk') echo 'selected'; ?>>Game Disk</option>
                <option value="accessory" <?php if ($listing['gear_type'] === 'accessory') echo 'selected'; ?>>Accessory</option>
            </select>
        </div>

        <div class="form-group">
            <label for="price">💰 Price ($)</label>
            <input type="number" id="price" name="price" value="<?php echo htmlspecialchars($listing['price']); ?>" required>
        </div>

        <div class="form-group">
            <label for="transaction-type">💼 Transaction Type</label>
            <select id="transaction-type" name="transaction-type" required>
                <option value="sell" <?php if ($listing['transaction_type'] === 'sell') echo 'selected'; ?>>Sell</option>
                <option value="rent" <?php if ($listing['transaction_type'] === 'rent') echo 'selected'; ?>>Rent</option>
            </select>
        </div>

        <div class="form-group">
            <label for="gear-description">📝 Description</label>
            <textarea id="gear-description" name="gear-description" rows="5" required><?php echo htmlspecialchars($listing['gear_description']); ?></textarea>
        </div>

        <div class="form-group">
            <label for="availability">📅 Availability</label>
            <input type="date" id="availability" name="availability" value="<?php echo htmlspecialchars($listing['availability']); ?>" required>
        </div>

        <div class="form-group">
            <label for="location">📍 Location</label>
            <input type="text" id="location" name="location" value="<?php echo htmlspecialchars($listing['location']); ?>" required>
        </div>

        <div class="form-group">
            <label for="gear-image">📸 Upload New Image (Optional)</label>
            <input type="file" id="gear-image" name="gear-image" accept="image/*">
            <small>Allowed formats: JPG, PNG. Max size: 2MB</small>
        </div>

        <div class="form-group">
            <label for="status">📦 Status</label>
            <select id="status" name="status" required>
                <option value="Available" <?php if ($listing['status'] === 'Available') echo 'selected'; ?>>Available</option>
                <option value="Sold" <?php if ($listing['status'] === 'Sold') echo 'selected'; ?>>Sold</option>
            </select>
        </div>

        <button type="submit" class="btn">Update Listing</button>
    </form>
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
                    <p>Email: support@gamehaven.com</p>
                    <p>Phone: +880-123-456789</p>
                    <p>Address: Dhaka, Bangladesh</p>
                </div>
            </div>
            <p>&copy; 2024 Game Haven. All Rights Reserved.</p>
        </div>
    </footer>
</body>
</html>



