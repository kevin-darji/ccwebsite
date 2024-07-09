<?php
// Start the session (add this at the beginning)
session_start();
$_SESSION['userLoggedIn'] = true;

// Database configuration
$host = 'localhost';
$dbUsername = 'root';
$dbPassword = '';
$dbName = 'ccwebsite';

// Create database connection
$conn = new mysqli("localhost", "root", "", "ccwebsite");

// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

// Function to sanitize input data
function sanitizeData($data)
{
  global $conn;
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return mysqli_real_escape_string($conn, $data);
}

// Login Form Submission
if (isset($_POST['login'])) {
  $email = sanitizeData($_POST['email']);
  $password = sanitizeData($_POST['password']);

  // Validate input data
  if (empty($email) || empty($password)) {
    $error = "Please enter both email and password";
  } else {
    // Perform database query to validate user credentials
    $query = "SELECT * FROM users WHERE email='$email' AND BINARY password='$password'";
    $result = $conn->query($query);

    if ($result->num_rows == 1) {
      // Login successful
      $row = $result->fetch_assoc();

      // Store user information in session variables
      $_SESSION['id'] = $row['id'];
      $_SESSION['name'] = $row['name'];
      $_SESSION['email'] = $row['email'];

      // Set a cookie to remember the user's login status
      setcookie('user_logged_in', true, time() + (86400 * 30), '/'); // Cookie lasts for 30 days
      
      // Redirect to the home page
      header("Location: home.php");
      exit();
    } else {
      // Invalid credentials
      $error = "Invalid email or password";
    }
  }
}

// Include Swift Mailer library
require_once 'swiftmailer/lib/swift_required.php';

// Signup Form Submission
if (isset($_POST['signup'])) {
  $name = sanitizeData($_POST['name']);
  $email = sanitizeData($_POST['email']);
  $password = sanitizeData($_POST['password']);
  $confirmPassword = sanitizeData($_POST['confirm_password']);

  // Validate input data
  $error = null;
  $emailError = null;

  // Check if email already exists in the database
  $query = "SELECT * FROM users WHERE email='$email'";
  $result = $conn->query($query);

  if ($result->num_rows > 0) {
    $emailError = "Email already exists.";
  } elseif ($password !== $confirmPassword) {
    $error = "Passwords do not match.";
  } else {
    // Insert new user into the database
    $insertQuery = "INSERT INTO users (name, email, password) VALUES ('$name', '$email', '$password')";
    if ($conn->query($insertQuery) === TRUE) {
      // Registration successful
      // Store user information in session variables
      $_SESSION['user_id'] = $conn->insert_id;
      $_SESSION['name'] = $name;
      $_SESSION['email'] = $email;

      // Send verification email using Node.js script
      exec('node VerifyEmail.js ' . escapeshellarg($email), $output, $return);

      // Check if email was sent successfully
      if ($return === 0) {
        // Email sent successfully
      } else {
        // Error occurred while sending email
        $error = "Error sending email.";
      }
    } else {
      $error = "Error: " . $insertQuery . "<br>" . $conn->error;
    }
  }
}
?>
<!DOCTYPE html>
<html>

<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Login page</title>
  <link rel="stylesheet" href="login.css" />
  <script src="https://kit.fontawesome.com/7b39153ed3.js" crossorigin="anonymous"></script>
  <script src="sendEmailClient.js"></script>
  <style>
    /* Add your CSS styles for the password rules here */
    .password-rules {
      position: absolute;
      top: 38px;
      left: -30px;
      width: 255px;
      background-color: #fff;
      border: 1px solid #ccc;
      border-radius: 4px;
      box-shadow: 0 2px 5px rgba(0, 0, 0, 0.15);
      display: none;
      /* Override the display property to always show the rules */
      z-index: 2;
      height: 165px;
      font-size: 0.6rem;
      font-weight: bolder !important;
    }
  </style>
</head>

<body>
  <div class="container" id="container">
    <!-- sign Up form section start-->
    <div class="form sign_up">
      <form action="" method="POST">
        <!-- heading -->
        <img src="logo.png" alt="">
        <h1>Create An Account</h1>
        <?php if (isset($_SESSION['registration_success'])) { ?>
          <p>Registration successful. Please check your email to verify your account.</p>
          <?php unset($_SESSION['registration_success']); ?>
        <?php } ?>
        <?php if (isset($error)) { ?>
          <p style="color: red;"><?php echo $error; ?></p>
        <?php } ?>
        <div id="error-container">
          <p class="email-error" style="color: red;"></p>
        </div>
        <p class="password-mismatch-error" style="color: red; display: none;"></p>
        <!-- input fields start -->
        <input type="text" class="name" name="name" placeholder="Enter Your Name" required>
        <input type="email" class="email" name="email" placeholder="Enter Your Email" required>
        <div class="password-container">
          <input type="password" id="password" name="password" placeholder="Enter Your Password" oninput="validatePassword(this.value)" onfocus="showPasswordRules()" onblur="hidePasswordRules()" required>
          <div class="password-rules">
            <p>
              <i class="length-icon fas fa-check" style="color: green; display: none;"></i>
              <i class="length-icon-cross fas fa-times" style="color: red; display: none;"></i>
              At least 8 characters long
            </p>
            <p>
              <i class="numeric-icon fas fa-check" style="color: green; display: none;"></i>
              <i class="numeric-icon-cross fas fa-times" style="color: red;"></i>
              Contains at least 1 numeric digit
            </p>
            <p>
              <i class="uppercase-icon fas fa-check" style="color: green; display: none;"></i>
              <i class="uppercase-icon-cross fas fa-times" style="color: red;"></i>
              Contains at least 1 uppercase letter
            </p>
            <p>
              <i class="lowercase-icon fas fa-check" style="color: green; display: none;"></i>
              <i class="lowercase-icon-cross fas fa-times" style="color: red;"></i>
              Contains at least 1 lowercase letter
            </p>
            <p>
              <i class="special-char-icon fas fa-check" style="color: green; display: none;"></i>
              <i class="special-char-icon-cross fas fa-times" style="color: red;"></i>
              Contains at least 1 symbolic character
            </p>
          </div>
        </div>
        <input type="password" class="confirm_password" name="confirm_password" placeholder="Enter Your Confirm Password" onkeyup="checkPasswordMatch()" required>
        <button name="signup" id="#login" type="submit">Register</button>
        <!-- input fields end -->
      </form>
    </div>

    <!-- sign Up form section end-->

    <!-- sign in form section start-->
    <div class="form sign_in" id="login">
      <form action="" method="POST">
        <img src="logo.png" alt="">
        <!-- heading -->
        <h1>Login In</h1>
        <?php if (isset($error)) { ?>
          <p style="color: red;"><?php echo $error; ?></p>
        <?php } ?>
        <!-- input fields start -->
        <input type="email" class="email" name="email" placeholder="Enter Your Email" required>
        <input type="password" class="password" name="password" placeholder="Enter Your Password" style="margin-bottom: 2px;" required>
        
        <!--<span>Forgot your <span class="forgot">password?</span></span>-->

        <button name="login" name="submit" class="btn" type="submit">Login</button>
        <!-- input fields end -->
      </form>
    </div>
    <!-- sign in form section end-->

    <!-- overlay section start-->
    <div class="overlay-container">
      <div class="overlay">
        <div class="overlay-pannel overlay-left">
          <h1>Already have an account</h1>
          <p>Please Login</p>
          <button id="signIn" class="overBtn">Sign In</button>
        </div>
        <div class="overlay-pannel overlay-right">
          <h1>Create Account</h1>
          <p>Create Memories with Us</p>
          <button id="signUp" class="overBtn">Sign Up</button>
        </div>
      </div>
    </div>
    <!-- overlay section start-->
  </div>
  <script src="java.js"></script>
  <script>
    $(document).ready(function(c) {
      $('.alert-close').on('click', function(c) {
        $('.main-mockup').fadeOut('slow', function(c) {
          $('.main-mockup').remove();
        });
      });
    });
  </script>
  <script>
    // Function to hide error messages after a delay
    function hideErrorMessage(element) {
      setTimeout(function() {
        element.style.display = 'none';
      }, 3000); // 3000 milliseconds (3 seconds) delay
    }
  </script>
  <script>
    var passwordInput = document.getElementById('password');
    var rules = document.querySelector('.password-container .password-rules');

    function showPasswordRules() {
      rules.style.display = 'block';
    }

    function hidePasswordRules() {
      rules.style.display = 'none';
    }

    function hasSpecialCharacter(password) {
      return /[^a-zA-Z\d]/.test(password);
    }

    function validatePassword(password) {
      var lengthIcon = document.querySelector('.length-icon');
      var numericIcon = document.querySelector('.numeric-icon');
      var uppercaseIcon = document.querySelector('.uppercase-icon');
      var lowercaseIcon = document.querySelector('.lowercase-icon');
      var specialCharIcon = document.querySelector('.special-char-icon');

      var lengthIconCross = document.querySelector('.length-icon-cross');
      var numericIconCross = document.querySelector('.numeric-icon-cross');
      var uppercaseIconCross = document.querySelector('.uppercase-icon-cross');
      var lowercaseIconCross = document.querySelector('.lowercase-icon-cross');
      var specialCharIconCross = document.querySelector('.special-char-icon-cross');

      var isLengthValid = password.length >= 8;
      var hasNumeric = /\d/.test(password);
      var hasUppercase = /[A-Z]/.test(password);
      var hasLowercase = /[a-z]/.test(password);
      var hasSpecialChar = hasSpecialCharacter(password);

      lengthIcon.style.display = isLengthValid ? 'inline-block' : 'none';
      lengthIconCross.style.display = isLengthValid ? 'none' : 'inline-block';

      numericIcon.style.display = hasNumeric ? 'inline-block' : 'none';
      numericIconCross.style.display = hasNumeric ? 'none' : 'inline-block';

      uppercaseIcon.style.display = hasUppercase ? 'inline-block' : 'none';
      uppercaseIconCross.style.display = hasUppercase ? 'none' : 'inline-block';

      lowercaseIcon.style.display = hasLowercase ? 'inline-block' : 'none';
      lowercaseIconCross.style.display = hasLowercase ? 'none' : 'inline-block';

      specialCharIcon.style.display = hasSpecialChar ? 'inline-block' : 'none';
      specialCharIconCross.style.display = hasSpecialChar ? 'none' : 'inline-block';

      // Add event listener to hide password rules when clicking outside
      document.addEventListener('click', function(event) {
        if (event.target !== passwordInput) {
          hidePasswordRules();
        }
      });
    }
  </script>
  <script>
    function checkPasswordMatch() {
      var passwordInput = document.getElementById('password');
      var confirmPasswordInput = document.querySelector('.confirm_password');
      var passwordMismatchError = document.querySelector('.password-mismatch-error');

      if (passwordInput.value !== confirmPasswordInput.value) {
        passwordMismatchError.textContent = 'Passwords do not match';
        passwordMismatchError.style.color = 'red';
        passwordMismatchError.style.display = 'block'; // Show the error message
        confirmPasswordInput.setCustomValidity('Passwords do not match');
      } else {
        passwordMismatchError.style.display = 'none'; // Hide the error message
        confirmPasswordInput.setCustomValidity('');
      }
    }
  </script>
  <!-- Include jQuery library -->
  <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

  <script>
    $(document).ready(function() {
      var emailError = $('.email-error'); // Store the error message element
      var errorContainer = $('#error-container'); // Store the error container element

      function checkEmailAvailability(email) {
        // Send an AJAX request to a PHP script to check email availability
        $.ajax({
          type: 'POST',
          url: 'check_email.php', // Create this PHP script
          data: {
            email: email
          },
          success: function(response) {
            if (response === 'exists') {
              // Email exists, display an error message and show the error container
              emailError.text('Email already exists.');
              errorContainer.css('display', 'block');
            } else {
              // Email is available, remove the error message and hide the error container
              emailError.text('');
              errorContainer.css('display', 'none');
            }
          }
        });
      }

      // Listen to the input event on the email field
      $('.email').on('input', function() {
        var email = $(this).val();
        checkEmailAvailability(email);
      });
    });
  </script>
</body>

</html>