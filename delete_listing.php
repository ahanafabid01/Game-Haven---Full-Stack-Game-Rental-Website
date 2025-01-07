<?php
session_start();
@include 'config.php'; // Database connection

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

if (!isset($_GET['id'])) {
    die("Invalid request. No listing ID provided.");
}

$listing_id = intval($_GET['id']);
$user_id = $_SESSION['user_id'];

// Delete the listing only if it belongs to the logged-in user
$query = "DELETE FROM gear_list WHERE id = ? AND user_id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("ii", $listing_id, $user_id);

if ($stmt->execute()) {
    header("Location: my_listing.php?success=Listing deleted successfully");
    exit();
} else {
    echo "Error deleting listing: " . $conn->error;
}
?>


