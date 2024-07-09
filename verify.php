<?php
// Start the session (add this at the beginning)
session_start();

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

// Extract verification token from URL
if (isset($_GET['token'])) {
  $token = $_GET['token'];

  // Query to find user by verification token
  $query = "SELECT * FROM users WHERE verification_token = '$token'";
  $result = $conn->query($query);

  if ($result->num_rows == 1) {
    // User found, update verified status
    $updateQuery = "UPDATE users SET verified = 1 WHERE verification_token = '$token'";
    if ($conn->query($updateQuery) === TRUE) {
      // Email verification successful
      $_SESSION['verification_success'] = true;
      header("Location: login.php"); // Redirect to login page or any other page
      exit();
    } else {
      // Error updating database
      $_SESSION['verification_error'] = "Error updating database.";
    }
  } else {
    // User not found with the given token
    $_SESSION['verification_error'] = "Invalid verification token.";
  }
} else {
  // No token provided in URL
  $_SESSION['verification_error'] = "No verification token provided.";
}

// Redirect to login page with error message
header("Location: login.php"); // Redirect to login page or any other page
exit();
?>
