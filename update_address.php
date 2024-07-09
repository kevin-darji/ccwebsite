<?php
session_start();

// Check if the user is logged in
$userLoggedIn = isset($_SESSION['name']);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if the user is logged in
    if (isset($_SESSION['name'])) {
        // Retrieve form data
        $name = $_POST['name'];
        $address = $_POST['address'];
        $city = $_POST['city'];
        $zipcode = $_POST['zipcode'];
        $phone = $_POST['phone'];

        // Database configuration
        $host = 'localhost';
        $dbUsername = 'root';
        $dbPassword = '';
        $dbName = 'ccwebsite';
        $conn = new mysqli($host, $dbUsername, $dbPassword, $dbName);

        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        // Check if the user already has an address
        $sql = "SELECT * FROM user_addresses WHERE name='$name'";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            // User already has an address, so update it
            $sql = "UPDATE user_addresses SET address='$address', city='$city', zipcode='$zipcode', phone='$phone' WHERE name='$name'";
        } else {
            // User doesn't have an address, so insert a new one
            $sql = "INSERT INTO user_addresses (name, address, city, zipcode, phone) VALUES ('$name', '$address', '$city', '$zipcode', '$phone')";
        }

        if ($conn->query($sql) === TRUE) {
            echo "Address inserted/updated successfully.";
            sleep(2); // Wait for 2 seconds
            header("Location: my-account.php");
            exit();
        } else {
            echo "Error inserting/updating address: " . $conn->error;
        }
        
        $conn->close();
    } else {
        // Redirect the user to the login page if not logged in
        header("Location: login.php");
        exit();
    }
} else {
    // Redirect the user to the edit address page if accessed directly
    header("Location: edit_address.php");
    exit();
}
?>