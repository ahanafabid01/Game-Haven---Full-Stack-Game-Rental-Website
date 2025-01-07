<?php 
@include 'config.php';

if(isset($_POST['submit'])){
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $pass = md5($_POST['password']);
    $cpass = md5($_POST['cpassword']);
    $user_type = $_POST['user_type'];
    $terms_accepted = isset($_POST['terms_accepted']) ? 1 : 0; // Check if terms are accepted
    $address = mysqli_real_escape_string($conn, $_POST['address']);
    $birthdate = mysqli_real_escape_string($conn, $_POST['birthdate']);
    #$bio = mysqli_real_escape_string($conn, $_POST['bio']);
    $contact_number = mysqli_real_escape_string($conn, $_POST['contact_number']);
  
    // Handle profile picture upload
    $target_file = '';
    if (!empty($_FILES['profile_pic']['name'])) {
        $target_dir = "uploads/";
        $target_file = $target_dir . basename($_FILES['profile_pic']['name']);
        move_uploaded_file($_FILES['profile_pic']['tmp_name'], $target_file);
    }

   // Check if user already exists
   $select = "SELECT * FROM user_form WHERE email = '$email'";
   $result = mysqli_query($conn, $select);

   if(mysqli_num_rows($result) > 0){
      $error[] = 'User already exists, Change email!';
   } else {
      // Check if passwords match
      if($pass != $cpass){
         $error[] = 'Passwords do not match!';
      } else {
         // Check if terms are accepted
         if($terms_accepted != 1) {
            $error[] = 'You must accept the Terms and Conditions to register.';
         } else {
            // Insert the new user into the database
            $insert = "INSERT INTO user_form(name, email, password, user_type, terms_accepted, address, birthdate, contact_number, profile_pic) 
                       VALUES('$name','$email','$pass','$user_type', 1, '$address', '$birthdate', '$contact_number', '$target_file')";
            mysqli_query($conn, $insert);
            header('location:login_form.php');
         }
      }
   }
};

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Register Form</title>

   <style>
/* General Reset */
/* Basic Reset and Body Styles */
* {
  margin: 0;
  padding: 0;
  box-sizing: border-box;
}

body {
  font-family: Arial, sans-serif;
  background-color: #f4f7fc;
  color: #333;
  display: flex;
  justify-content: center;
  align-items: center;
  height: 100vh;
  margin: 0;
}

.register-body {
  background-color: #f4f7fc;
  display: flex;
  justify-content: center;
  align-items: center;
  height: 100vh;
}

.form-container {
  background-color: #fff;
  padding: 30px;
  border-radius: 10px;
  box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
  width: 100%;
  max-width: 450px;
}

h3 {
  text-align: center;
  margin-bottom: 20px;
  color: #333;
}

input, select, textarea {
  width: 100%;
  padding: 10px;
  margin: 10px 0;
  border: 1px solid #ccc;
  border-radius: 5px;
  font-size: 14px;
}

input[type="file"] {
  padding: 8px;
}

input[type="checkbox"] {
  margin-right: 10px;
}

.terms-condition {
  font-size: 12px;
  margin-top: 10px;
}

.terms-condition a {
  color: #007BFF;
  text-decoration: none;
}

.terms-condition a:hover {
  text-decoration: underline;
}

.form-btn {
  background-color: #007BFF;
  color: white;
  border: none;
  padding: 12px;
  width: 100%;
  border-radius: 5px;
  cursor: pointer;
  font-size: 16px;
}

.form-btn:hover {
  background-color: #0056b3;
}

.error-msg {
  color: red;
  font-size: 12px;
  display: block;
  margin-top: 10px;
  text-align: center;
}

p {
  text-align: center;
  font-size: 14px;
}

p a {
  color: #007BFF;
  text-decoration: none;
}

p a:hover {
  text-decoration: underline;
}

/* Media Queries for Responsiveness */
@media (max-width: 768px) {
  .form-container {
    padding: 20px;
  }

  input, select, .form-btn {
    font-size: 14px;
  }

  h3 {
    font-size: 18px;
  }
}

@media (max-width: 480px) {
  .form-container {
    width: 90%;
    padding: 15px;
  }

  h3 {
    font-size: 16px;
  }

  input, select, .form-btn {
    font-size: 14px;
  }

  .form-btn {
    padding: 10px;
  }
}

   </style>
</head>
<body class="register-body">
   
<div class="form-container">

   <form action="" method="post" enctype="multipart/form-data">
      <h3>Register Now</h3>
      <?php
      if(isset($error)){
         foreach($error as $error){
            echo '<span class="error-msg">'.$error.'</span>';
         };
      };
      ?>
      <input type="text" name="name" required placeholder="Enter your name">
      <input type="email" name="email" required placeholder="Enter your email">
      <input type="password" name="password" required placeholder="Enter your password">
      <input type="password" name="cpassword" required placeholder="Confirm your password">
      <input type="text" name="address" required placeholder="Enter your address">
      <input type="tel" name="contact_number" required placeholder="Enter your contact number">
      <p>Enter Date Of Birth </p>
      <input type="date" name="birthdate" required placeholder="Enter your birth date">
      <!-- <textarea name="bio" required placeholder="Write a short bio"></textarea> -->
      <p>Enter Profile Picture </p>
      <input type="file" name="profile_pic" accept="image/*">
      
      <select name="user_type">
         <option value="user">User</option>
      </select>

      <!-- Terms and Conditions Checkbox -->
<div class="terms-condition">
   <input type="checkbox" name="terms_accepted" required> I agree to the <a href="terms_and_conditions_popup.php?show_terms=1" target="_blank">Terms and Conditions</a> and <a href="privacy_policy_popup.php?show_policy=1" target="_blank">Privacy Policy</a>
</div>


      <input type="submit" name="submit" value="Register Now" class="form-btn">
      <p>Already have an account? <a href="login_form.php">Login now</a></p>
   </form>

</div>
<script>
// Example: Check if passwords match on submit
document.querySelector('form').addEventListener('submit', function(event) {
  var password = document.querySelector('input[name="password"]').value;
  var confirmPassword = document.querySelector('input[name="cpassword"]').value;

  if (password !== confirmPassword) {
    alert('Passwords do not match!');
    event.preventDefault(); // Prevent form submission
  }
});
</script>

</body>
</html>
