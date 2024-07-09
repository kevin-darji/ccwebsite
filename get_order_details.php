<?php
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

// Retrieve order ID from URL parameters
$orderId = $_GET['orderId'];

// Fetch order details based on order ID
$sql = "SELECT * FROM orders WHERE order_id = ?";
$stmt = $conn->prepare($sql);

// Bind parameters
$stmt->bind_param("s", $orderId);
$stmt->execute();

// Fetch the result
$result = $stmt->get_result();
$orderDetails = $result->fetch_assoc();

// Close connections
$stmt->close();
$conn->close();

// Return order details as JSON
echo json_encode($orderDetails);
?>
