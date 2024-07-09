<?php
try {
    // Connect to the database
    $conn = new mysqli("localhost", "root", "", "ccwebsite");

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Retrieve user input from the form and sanitize it (to prevent SQL injection)
    $first_name = isset($_POST["first_name"]) ? mysqli_real_escape_string($conn, $_POST["first_name"]) : "";
    $last_name = isset($_POST["last_name"]) ? mysqli_real_escape_string($conn, $_POST["last_name"]) : "";
    $address = isset($_POST["address"]) ? mysqli_real_escape_string($conn, $_POST["address"]) : "";
    $town_city = isset($_POST["town_city"]) ? mysqli_real_escape_string($conn, $_POST["town_city"]) : "";
    $state_country = isset($_POST["state_country"]) ? mysqli_real_escape_string($conn, $_POST["state_country"]) : "";
    $postcode_zip = isset($_POST["postcode_zip"]) ? mysqli_real_escape_string($conn, $_POST["postcode_zip"]) : "";
    $email_address = isset($_POST["email"]) ? mysqli_real_escape_string($conn, $_POST["email"]) : "";
    $phone = isset($_POST["phone"]) ? mysqli_real_escape_string($conn, $_POST["phone"]) : "";
    $order_notes = isset($_POST["order_notes"]) ? mysqli_real_escape_string($conn, $_POST["order_notes"]) : "";

    // Create the SQL query to insert the billing information into the database
    $sql = "INSERT INTO customers (FirstName, LastName, Address, TownCity, StateCountry, PostCodeZip, EmailAddress, Phone, OrderNotes)
VALUES ('$first_name', '$last_name', '$address', '$town_city', '$state_country', '$postcode_zip', '$email_address', '$phone', '$order_notes')";

    // Execute the SQL query
    $result = $conn->query($sql);

    // Check if the query was successful
    if ($result === TRUE) {
        echo 'Billing information inserted successfully!';
    } else {
        echo 'Error inserting billing information: ' . $conn->error;
    }

    // Close the database connection
    $conn->close();
} catch (Exception $e) {
    echo 'Error: ' . $e->getMessage();
}
?>
