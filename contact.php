<?php
@include 'config.php';

session_start();

if(!isset($_SESSION['user_name'])){
   header('location:login_form.php');
}
// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Step 2: Process the form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize input to prevent SQL injection and XSS attacks
    $name = htmlspecialchars(mysqli_real_escape_string($conn, $_POST['name']));
    $email = htmlspecialchars(mysqli_real_escape_string($conn, $_POST['email']));
    $message = htmlspecialchars(mysqli_real_escape_string($conn, $_POST['message']));

    // Step 3: Insert the data into the database
    $sql = "INSERT INTO contact_messages (name, email, message) VALUES ('$name', '$email', '$message')";

    if ($conn->query($sql) === TRUE) {
        // Success: Inform the user and redirect or show confirmation
        echo "<script>alert('Message sent successfully!'); window.location.href='homepage.php';</script>";
    } else {
        // Error: Display an error message
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

// Close the connection
$conn->close();
?>

