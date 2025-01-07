<?php
@include 'config.php';

session_start();

// Fetch terms and conditions content from the database
$sql = "SELECT content FROM terms_conditions WHERE id = 1";
$result = $conn->query($sql);
$terms_content = "";
if ($result && $result->num_rows > 0) {
    $terms_content = $result->fetch_assoc()['content'];
}

// Determine if the terms and conditions pop-up should be shown
$show_popup = isset($_GET['show_terms']) && $_GET['show_terms'] == '1';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Terms and Conditions</title>
    <link href="https://fonts.googleapis.com/css2?family=Hind:wght@400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }
        .popup-container {
            display: <?= $show_popup ? 'flex' : 'none'; ?>;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.7);
            justify-content: center;
            align-items: center;
            z-index: 1000;
        }
        .popup {
            background: white;
            padding: 20px;
            border-radius: 10px;
            width: 80%;
            max-width: 600px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }
        .popup-header {
            background-color: #007bff;
            color: white;
            padding: 10px 15px;
            border-radius: 10px 10px 0 0;
            text-align: center;
        }
        .popup-content {
            padding: 15px;
            overflow-y: auto;
            max-height: 400px;
            color: #333;
        }
        .popup-footer {
            text-align: center;
            margin-top: 15px;
        }
        .btn {
            background-color: #007bff;
            color: white;
            padding: 10px 20px;
            text-decoration: none;
            border-radius: 5px;
            transition: background-color 0.3s ease;
        }
        .btn:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <div class="popup-container">
        <div class="popup">
            <div class="popup-header">
                <h2>Terms and Conditions</h2>
            </div>
            <div class="popup-content">
                <p><?= nl2br(htmlspecialchars($terms_content)); ?></p>
            </div>
            <div class="popup-footer">
                <a href="homepage.php" class="btn">Close</a>
            </div>
        </div>
    </div>
</body>
</html>
