<?php
include 'config.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    header('location:login_form.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user_id = $_SESSION['user_id'];
    $subject = mysqli_real_escape_string($conn, $_POST['subject']);
    $message = mysqli_real_escape_string($conn, $_POST['message']);

    $query = "INSERT INTO user_queries (user_id, subject, message) VALUES ('$user_id', '$subject', '$message')";
    if (mysqli_query($conn, $query)) {
        $_SESSION['submission_success'] = true;
        header('Location: help.php');
        exit();
    } else {
        echo "Error: " . $query . "<br>" . mysqli_error($conn);
    }
}
?>

