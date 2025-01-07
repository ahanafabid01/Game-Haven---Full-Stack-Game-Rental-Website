<?php
session_start(); // Resume the session

// Ensure user is logged in
if (!isset($_SESSION['user_id'])) {
    die("Error: You must log in to add gear.");
}

// Include database configuration
@include 'config.php';

// Check database connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user_id = $_SESSION['user_id']; // Logged-in user's ID
    $gear_name = mysqli_real_escape_string($conn, $_POST['gear-name']);
    $gear_type = mysqli_real_escape_string($conn, $_POST['gear-type']);
    $price = mysqli_real_escape_string($conn, $_POST['price']);
    $gear_description = mysqli_real_escape_string($conn, $_POST['gear-description']);
    $availability = mysqli_real_escape_string($conn, $_POST['availability']);
    $location = mysqli_real_escape_string($conn, $_POST['location']);
    $transaction_type = mysqli_real_escape_string($conn, $_POST['transaction-type']); // Rent or Sell

    // Handle image upload
    if (isset($_FILES['gear-image']) && $_FILES['gear-image']['error'] === UPLOAD_ERR_OK) {
        $gear_image = $_FILES['gear-image']['name'];
        $image_tmp_name = $_FILES['gear-image']['tmp_name'];
        $target_dir = "uploads/";
        $target_file = $target_dir . basename($gear_image);
        $image_extension = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        // Validate image file type
        $allowed_extensions = ['jpg', 'jpeg', 'png','webp'];
        if (!in_array($image_extension, $allowed_extensions)) {
            die("Error: Invalid file type. Only JPG, JPEG, and PNG files are allowed.");
        }

        // Create uploads directory if it doesn't exist
        if (!is_dir($target_dir)) {
            mkdir($target_dir, 0755, true);
        }

        // Move uploaded file
        if (move_uploaded_file($image_tmp_name, $target_file)) {
            // Insert gear data into the database
            $sql = "INSERT INTO gear_list 
                        (user_id, gear_name, gear_type, transaction_type, price, gear_description, gear_image, availability, location) 
                    VALUES 
                        ('$user_id', '$gear_name', '$gear_type', '$transaction_type', '$price', '$gear_description', '$target_file', '$availability', '$location')";

            if (mysqli_query($conn, $sql)) {
                header('Location: homepage.php'); // Redirect on success
                exit();
            } else {
                echo "Error: " . mysqli_error($conn);
            }
        } else {
            echo "Error: Failed to upload image.";
        }
    } else {
        echo "Error: No file uploaded or upload error occurred.";
    }
}

// Close database connection
mysqli_close($conn);
?>

