<?php
session_start();
error_reporting(0);

// Database configuration
$host = 'localhost';
$dbUsername = 'root';
$dbPassword = '';
$dbName = 'ccwebsite';

// Create database connection
$conn = new mysqli($host, $dbUsername, $dbPassword, $dbName);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if the form is submitted
if (isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Validate the username and password (you can add more validation)
    if ($username === 'admin' && $password === 'admin123') {
        $_SESSION['admin'] = $username;
        header("location: my-account.php");
        exit();
    } else {
        $_SESSION['error'] = "Invalid username or password";
        header("location: login.php");
        exit();
    }
}

// Check if there is an error message in the session
$error = isset($_SESSION['error']) ? $_SESSION['error'] : '';

// Unset the error message to clear it
unset($_SESSION['error']);
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
</head>

<body>
    <div class="container" id="container">

        <!-- sign in form section start-->
        <div class="form sign_in" id="login">
            <form method="post">
                <img src="logo.png" alt="" style="padding-bottom: 15%;">
                <!-- heading -->
                <h1>Admin Login</h1>
                <?php if (!empty($error)) { ?>
                    <p class="error"><?php echo $error; ?></p>
                <?php } ?>
                <!-- input fields start -->
                <input type="text" class="username" name="username" placeholder="Enter Your Username">
                <input type="password" class="password" name="password" placeholder="Enter Your Password" style="margin-bottom: 2px;">
                <button name="login" class="btn" type="submit">Login</button>
                <!-- input fields end -->
            </form>
        </div>
        <!-- sign in form section end-->
    </div>
</body>

</html>