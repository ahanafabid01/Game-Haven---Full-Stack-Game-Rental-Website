<?php 
@include 'config.php';

session_start();

// Check if form is submitted
if(isset($_POST['submit'])){

   $email = mysqli_real_escape_string($conn, $_POST['email']);
   $pass = md5($_POST['password']);
   $remember = isset($_POST['remember']);
   $terms_accepted = isset($_POST['terms_accepted']) ? 1 : 0; // Check if terms are accepted

   // Validate terms and conditions
      // Proceed with login if terms accepted
      $select = " SELECT * FROM user_form WHERE email = '$email' AND password = '$pass' ";
      $result = mysqli_query($conn, $select);

      if(mysqli_num_rows($result) > 0){
         $row = mysqli_fetch_array($result);

         // Check if user type is admin or user
         if($row['user_type'] == 'admin'){
            $_SESSION['admin_name'] = $row['name'];
            if ($remember) {
               setcookie("email", $email, time() + (86400 * 30), "/");
               setcookie("password", $pass, time() + (86400 * 30), "/");
            }
            header('location:admin_dash.php');
         } elseif($row['user_type'] == 'user'){
            $_SESSION['user_name'] = $row['name'];
            $_SESSION['user_id'] = $row['id'];
            if ($remember) {
               setcookie("email", $email, time() + (86400 * 30), "/");
               setcookie("password", $pass, time() + (86400 * 30), "/");
            }
            // Update the terms_accepted flag if necessary
            $update_terms = "UPDATE user_form SET terms_accepted = 1 WHERE id = '".$row['id']."'";
            mysqli_query($conn, $update_terms);

            header('location:homepage.php');
         }
      } else {
         $error[] = 'Incorrect email or password!';
      }
   
}

// Prefill email and password if cookies are set
$email_cookie = isset($_COOKIE['email']) ? $_COOKIE['email'] : '';
$password_cookie = isset($_COOKIE['password']) ? $_COOKIE['password'] : '';

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Login Form</title>
<!-- #region -->
   <style>
      /* General Reset */
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

/* Form Container */
.form-container {
    background:rgb(18, 19, 19);
    padding: 40px 60px;
    border-radius: 10px;
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.3);
    width: 100%;
    max-width: 450px;
    text-align: center;
}

/* Form Title */
h3 {
    font-size: 24px;
    margin-bottom: 20px;
    font-weight: 600;
    color: #ecf0f1;
}

/* Input Fields */
input[type="email"],
input[type="password"] {
    width: 100%;
    padding: 12px;
    margin: 12px 0;
    border: none;
    border-radius: 5px;
    background-color: #ecf0f1;
    color: #333;
    font-size: 16px;
}

input[type="email"]:focus,
input[type="password"]:focus {
    outline: none;
    border: 2px solid #2980b9;
}

/* Terms and Conditions Checkbox */
.terms-condition {
    display: flex;
    justify-content: flex-start;
    align-items: center;
    color: #bdc3c7;
    margin-bottom: 15px;
}

.terms-condition input {
    margin-right: 8px;
}

.terms-condition a {
    color: #3498db;
    text-decoration: none;
}

.terms-condition a:hover {
    text-decoration: underline;
}

/* Remember Me Checkbox */
.remember {
    display: flex;
    justify-content: flex-start;
    align-items: center;
    color: #bdc3c7;
    margin-bottom: 20px;
}

.remember input {
    margin-right: 10px;
}

/* Submit Button */
.form-btn {
    width: 100%;
    padding: 12px;
    background-color: #3498db;
    border: none;
    border-radius: 5px;
    font-size: 18px;
    color: #fff;
    cursor: pointer;
    transition: background-color 0.3s;
}

.form-btn:hover {
    background-color: #2980b9;
}

/* Error Message */
.error-msg {
    display: block;
    color: #e74c3c;
    font-size: 14px;
    margin-bottom: 15px;
}

/* Links */
p a {
    color: #3498db;
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
<body class="login-body">
   
<div class="form-container">

   <form action="" method="post">
      <h3>Login Now</h3>
      <?php
      if(isset($error)){
         foreach($error as $error){
            echo '<span class="error-msg">'.$error.'</span>';
         };
      };
      ?>
      <input type="email" name="email" required placeholder="Enter your email" value="<?php echo $email_cookie; ?>">
      <input type="password" name="password" required placeholder="Enter your password" value="<?php echo $password_cookie; ?>">
      <div class="remember">
         <input type="checkbox" name="remember" <?php if($email_cookie) echo "checked"; ?>> Remember Me
      </div>

      <input type="submit" name="submit" value="Login Now" class="form-btn">
      <p><a href="forgot_password.php">Forgot your password?</a></p>
      <p>Don't have an account? <a href="register_form.php">Register now</a></p>
   </form>

</div>

</body>
</html> 

</body>
</html> 



