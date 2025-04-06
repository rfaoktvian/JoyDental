<?php
// Database configuration
$db_host = "localhost";
$db_name = "appointdoc_db";
$db_user = "root";
$db_pass = "";

// Create database connection
try {
    $conn = new PDO("mysql:host=$db_host;dbname=$db_name", $db_user, $db_pass);
    // Set the PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    // Set fetch mode to associative array
    $conn->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
} catch(PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}

// Function to handle database errors
function handleDatabaseError($e, $returnUrl = 'profile.php') {
    $_SESSION['message'] = "Database error: " . $e->getMessage();
    $_SESSION['message_type'] = "danger";
    header("Location: $returnUrl");
    exit();
}