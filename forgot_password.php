<?php

@include 'config.php';

if(isset($_POST['submit'])){

   $email = mysqli_real_escape_string($conn, $_POST['email']);

   // Check if email exists in the database
   $select = "SELECT * FROM user_form WHERE email = '$email'";
   $result = mysqli_query($conn, $select);

   if(mysqli_num_rows($result) > 0){
      // Normally, send a password reset email here
      $success = 'Password reset instructions have been sent to your email.';
   } else {
      $error[] = 'Email address not found!';
   }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Forgot Password</title>

   <style>
      /* Basic Reset */
      * {
         margin: 0;
         padding: 0;
         box-sizing: border-box;
      }

      /* Full-Height Background */
      body {
         font-family: 'Arial', sans-serif;
         background: black;
         display: flex;
         justify-content: center;
         align-items: center;
         height: 100vh;
         color: #fff;
      }

      .form-container {
         background: #2d3436;
         padding: 40px 60px;
         border-radius: 10px;
         box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
         width: 100%;
         max-width: 400px;
      }

      /* Form Title */
      h3 {
         text-align: center;
         margin-bottom: 20px;
         font-size: 24px;
         color: #fff;
         font-weight: 600;
      }

      /* Input Fields */
      input[type="email"] {
         width: 100%;
         padding: 12px;
         margin: 12px 0;
         border: none;
         border-radius: 5px;
         font-size: 16px;
         color: #333;
         background-color: #fff;
      }

      input[type="email"]:focus {
         outline: none;
         border: 2px solid #74b9ff;
      }

      /* Submit Button */
      .form-btn {
         width: 100%;
         padding: 12px;
         background-color: #0984e3;
         border: none;
         border-radius: 5px;
         font-size: 18px;
         color: #fff;
         cursor: pointer;
         transition: background-color 0.3s;
      }

      .form-btn:hover {
         background-color: #74b9ff;
      }

      /* Messages */
      .success-msg {
         color: #2ecc71;
         text-align: center;
         margin-bottom: 15px;
      }

      .error-msg {
         color: #e74c3c;
         text-align: center;
         margin-bottom: 15px;
      }

      /* Back to Login Link */
      p {
         text-align: center;
         color: #fff;
         font-size: 14px;
      }

      p a {
         color: #74b9ff;
         text-decoration: none;
      }

      p a:hover {
         text-decoration: underline;
      }

      /* Responsive Design */
      @media (max-width: 600px) {
         .form-container {
            padding: 30px 40px;
         }

         h3 {
            font-size: 20px;
         }

         .form-btn {
            font-size: 16px;
         }
      }
   </style>
</head>
<body>
   
<div class="form-container">

   <form action="" method="post">
      <h3>Forgot Password</h3>
      <?php
      if(isset($error)){
         foreach($error as $error){
            echo '<span class="error-msg">'.$error.'</span>';
         }
      }
      if(isset($success)){
         echo '<span class="success-msg">'.$success.'</span>';
      }
      ?>
      <input type="email" name="email" required placeholder="Enter your registered email">
      <input type="submit" name="submit" value="Reset Password" class="form-btn">
      <p><a href="login_form.php">Back to Login</a></p>
   </form>

</div>

</body>
</html>
