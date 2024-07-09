<?php
session_start();

// Simulate login status
$loggedIn = isset($_SESSION['name']);

// Return JSON response
header('Content-Type: application/json');
echo json_encode(['loggedIn' => $loggedIn]);
?>
