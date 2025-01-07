<?php
@include 'config.php';

session_start();

if (!isset($_SESSION['user_id'])) {
    header('location:login_form.php');
    exit();
}

$user_id = $_SESSION['user_id'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Help Page</title>
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

/* Main Content */
#help {
    padding: 40px 20px;
    background-color: #1e1e1e;
}

h2.section-title, h3.faq-title, h3.contact-title {
    font-size: 2rem;
    color: #28a745;
    margin-bottom: 20px;
}

.faq-item {
    margin-bottom: 15px;
}

.faq-question {
    font-size: 1.2rem;
    color: #f1f1f1;
    font-weight: 600;
}

.faq-answer {
    font-size: 1rem;
    color: #bbb;
    margin-left: 20px;
}

/* Query Section */
.container form {
    background-color: #1e1e1e;
    padding: 20px;
    border-radius: 8px;
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.3);
    margin-top: 30px;
}

.container form label {
    font-size: 1.1rem;
    color: #ddd;
    margin-bottom: 10px;
    margin-top: 20px;
}

.container form input,
.container form textarea {
    width: 100%;
    padding: 12px;
    font-size: 1rem;
    border: 1px solid #333;
    border-radius: 5px;
    background-color: #333;
    color: #f1f1f1;
    margin-bottom: 20px;
    transition: border-color 0.3s ease;
}

.container form input:focus,
.container form textarea:focus {
    border-color: #28a745;
    outline: none;
}

.container form button[type="submit"] {
    background-color: #28a745;
    color: #fff;
    padding: 12px 20px;
    font-size: 1.2rem;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    transition: background-color 0.3s ease;
    text-align: center;
    width: 100%;
}

.container form button[type="submit"]:hover {
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
    color: #bbb;
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
    color: #bbb;
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
    color: #bbb;
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

    .container form {
        width: 100%;
        padding: 15px;
    }

    .container form button[type="submit"] {
        font-size: 1.1rem;
        padding: 10px;
    }
}

    </style>
</head>
<body>
<?php
    if (isset($_SESSION['submission_success'])) {
        echo "<script>showAlert('Your request has been submitted successfully!');</script>";
        unset($_SESSION['submission_success']);
    }
    ?>
<header class="header">
    <div class="container">
        <h1 class="logo">GameHaven</h1>
        <nav>
            <ul class="nav-links">
                <li><a href="homepage.php">Home</a></li>
                <li><a href="my_profile.php">My Profile</a></li>
                <li><a href="my_requests.php">My Requests</a></li> <!-- New link added -->
            </ul>
        </nav>
    </div>
</header>
    <!-- Help Section -->
    <section id="help" class="help-section">
        <div class="container">
            <h2 class="section-title">How Can We Help You?</h2>

            <!-- FAQ Section -->
            <div class="faq-section">
                <h3 class="faq-title">Frequently Asked Questions</h3>
                <div class="faq-item">
                    <h4 class="faq-question">1. How do I rent a game or console?</h4>
                    <p class="faq-answer">Simply browse our collection of consoles and games, choose the ones you want to rent, list them on your chart and follow the checkout process.</p>
                </div>
                <div class="faq-item">
                    <h4 class="faq-question">2. How can I list my gaming gear?</h4>
                    <p class="faq-answer">Go to the "Share & Earn" section and follow the instructions to list your items for rent.</p>
                </div>
                <!-- Additional FAQs -->
            </div>

            <!-- Contact Support Section -->
            <div class="contact-support-section">
                <h3 class="contact-title">Need Further Assistance?</h3>
                <p>Contact our support team directly if you need help.</p>
                <p>Email: <a href="mailto:support@gamehaven.com">support@gamehaven.com</a></p>
                <p>Phone: +1 800 123 4567</p>
            </div>
        </div>
    </section>

    <!-- Query Submission Section -->
    <div class="container">
        <h1>Query Section</h1>
        <p>If you have any questions, feel free to ask below!</p>
        <form action="process_help.php" method="POST">
            <label for="subject">Subject:</label>
            <input type="text" id="subject" name="subject" required>

            <label for="message">Message:</label>
            <textarea id="message" name="message" rows="6" required></textarea>

            <button type="submit">Submit</button>
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


