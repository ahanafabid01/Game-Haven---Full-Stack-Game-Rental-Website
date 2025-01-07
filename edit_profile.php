<?php
@include 'config.php';

session_start();

// Redirect to login if not logged in
if (!isset($_SESSION['user_name'])) {
    header('location:login_form.php');
    exit();
}

// Fetch the logged-in user's information
$user_name = $_SESSION['user_name'];
$sql = "SELECT * FROM user_form WHERE name = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param('s', $user_name);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

// Update user profile
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $address = $_POST['address'] ?? $user['address'];
    $birthdate = $_POST['birthdate'] ?? $user['birthdate'];
    $bio = $_POST['bio'] ?? $user['bio'];
    $contact_number = $_POST['contact_number'] ?? $user['contact_number'];

    // Handle profile picture upload
    if (!empty($_FILES['profile_pic']['name'])) {
        $target_dir = "uploads/";
        $target_file = $target_dir . basename($_FILES['profile_pic']['name']);
        move_uploaded_file($_FILES['profile_pic']['tmp_name'], $target_file);
    } else {
        $target_file = $user['profile_pic'];
    }

    $sql_update = "UPDATE user_form SET address = ?, birthdate = ?, bio = ?, contact_number = ?, profile_pic = ? WHERE id = ?";
    $stmt = $conn->prepare($sql_update);
    $stmt->bind_param('sssssi', $address, $birthdate, $bio, $contact_number, $target_file, $user['id']);

    if ($stmt->execute()) {
        header('Location: my_profile.php');
        exit();
    } else {
        $error_message = "Failed to update profile.";
    }
}

$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Profile</title>
    <link href="https://fonts.googleapis.com/css2?family=Hind:wght@400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        /* Global Styles */
body {
    font-family: 'Hind', sans-serif;
    background-color: #1e1e2f;
    color: #ddd;
    margin: 0;
    padding: 0;
    line-height: 1.6;
}

a {
    text-decoration: none;
    color: inherit;
}

h1, h2, h3 {
    color: #fff;
}

/* Container for Edit Profile */
.edit-profile-container {
    max-width: 900px;
    margin: 40px auto;
    padding: 20px;
    background-color: #2a2a3d;
    border-radius: 10px;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
}

/* Header */
header.header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 20px;
}

header h1 {
    font-size: 2.2em;
    color: #fff;
}

.btn-back {
    padding: 10px 20px;
    background-color: #007bff;
    color: white;
    border-radius: 5px;
    font-weight: bold;
    text-transform: uppercase;
    transition: background-color 0.3s ease;
}

.btn-back:hover {
    background-color: #0056b3;
}

/* Form Styles */
.edit-profile-form .form-group {
    margin-bottom: 20px;
}

.edit-profile-form label {
    font-size: 1.1em;
    color: #ccc;
    display: block;
    margin-bottom: 5px;
}

.edit-profile-form input, 
.edit-profile-form textarea {
    width: 100%;
    padding: 12px;
    background-color: #3b3b4f;
    color: #fff;
    border: 1px solid #555;
    border-radius: 5px;
    font-size: 1em;
}

.edit-profile-form input:focus, 
.edit-profile-form textarea:focus {
    outline: none;
    border-color: #007bff;
    background-color: #48485e;
}

.edit-profile-form textarea {
    height: 150px;
}

.btn-submit {
    display: inline-block;
    padding: 12px 20px;
    background-color: #28a745;
    color: white;
    border-radius: 5px;
    font-size: 1.1em;
    text-transform: uppercase;
    width: 100%;
    transition: background-color 0.3s ease;
}

.btn-submit:hover {
    background-color: #218838;
}

/* Error Message */
.error-message {
    color: #ff6347;
    font-size: 1em;
    margin-top: 20px;
}

/* Footer Styles */
footer {
    background-color: #333;
    color: #bbb;
    padding: 40px 0;
    text-align: center;
}

footer .footer-content {
    display: flex;
    justify-content: space-around;
    gap: 20px;
    flex-wrap: wrap;
    max-width: 1200px;
    margin: 0 auto;
}

footer h3 {
    font-size: 1.2em;
    color: #fff;
    margin-bottom: 15px;
}

footer p, footer a {
    font-size: 1em;
    color: #ccc;
    text-decoration: none;
}

footer a:hover {
    color: #007bff;
}

footer .social-icons {
    display: flex;
    gap: 15px;
}

footer .social-icons a {
    color: #bbb;
    font-size: 24px;
    transition: color 0.3s ease;
}

footer .social-icons a:hover {
    color: #007bff;
}

/* Footer Responsive */
@media (max-width: 768px) {
    footer .footer-content {
        flex-direction: column;
        align-items: center;
    }
}

    </style>
</head>
<body>
    <div class="edit-profile-container">
        <header class="header">
            <h1>Edit Profile</h1>
            <a href="my_profile.php" class="btn-back">Back to Profile</a>
        </header>

        <form action="" method="POST" enctype="multipart/form-data" class="edit-profile-form">
            <div class="form-group">
                <label for="profile_pic">Profile Picture:</label>
                <input type="file" name="profile_pic" id="profile_pic">
            </div>

            <div class="form-group">
                <label for="address">Address:</label>
                <input type="text" name="address" id="address" value="<?= htmlspecialchars($user['address'] ?? ''); ?>">
            </div>

            <div class="form-group">
                <label for="birthdate">Birthdate:</label>
                <input type="date" name="birthdate" id="birthdate" value="<?= htmlspecialchars($user['birthdate'] ?? ''); ?>">
            </div>

            <div class="form-group">
                <label for="bio">Bio:</label>
                <textarea name="bio" id="bio"><?= htmlspecialchars($user['bio'] ?? ''); ?></textarea>
            </div>

            <div class="form-group">
                <label for="contact_number">Contact Number:</label>
                <input type="text" name="contact_number" id="contact_number" value="<?= htmlspecialchars($user['contact_number'] ?? ''); ?>">
            </div>

            <button type="submit" class="btn-submit">Update Profile</button>
        </form>

        <?php if (isset($error_message)): ?>
            <p class="error-message"><?= htmlspecialchars($error_message); ?></p>
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

