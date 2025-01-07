<?php
session_start(); // Resume the session

@include 'config.php';
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    die("Error: You must log in to add items to your cart.");
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user_id = $_SESSION['user_id']; // Logged-in user's ID
    $gear_id = filter_var($_POST['gear_id'], FILTER_VALIDATE_INT); // Gear item ID
    $quantity = filter_var($_POST['quantity'], FILTER_VALIDATE_INT) ?: 1; // Default quantity is 1

    if ($gear_id === false || $quantity === false || $quantity < 1) {
        die("Invalid input. Please try again.");
    }

    // Check if the item is already in the cart
    $stmt = $conn->prepare("SELECT * FROM cart WHERE user_id = ? AND gear_id = ?");
    $stmt->bind_param("ii", $user_id, $gear_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Update the quantity if the item is already in the cart
        $stmt = $conn->prepare("UPDATE cart SET quantity = quantity + ? WHERE user_id = ? AND gear_id = ?");
        $stmt->bind_param("iii", $quantity, $user_id, $gear_id);
        if ($stmt->execute()) {
            header("Location: view_cart.php");
            exit;
        } else {
            echo "Error: " . $conn->error;
        }
    } else {
        // Add the item to the cart
        $stmt = $conn->prepare("INSERT INTO cart (user_id, gear_id, quantity) VALUES (?, ?, ?)");
        $stmt->bind_param("iii", $user_id, $gear_id, $quantity);
        if ($stmt->execute()) {
            header("Location: view_cart.php");
            exit;
        } else {
            echo "Error: " . $conn->error;
        }
    }
}

$conn->close();
?>