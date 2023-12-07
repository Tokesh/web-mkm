<?php
// Start the session
session_start();

// Database connection parameters
$host = 'localhost'; // Your database host
$dbname = 'testendterm'; // Your database name
$username = 'root'; // Your database username
$password = ''; // Your database password

// Create a connection
$conn = new mysqli($host, $username, $password, $dbname);

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Assuming you have stored user_id in the session
if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];

    // SQL query to select user information based on user_id
    $sql = "SELECT username, firstname, lastname FROM users WHERE id = $user_id";
    $result = $conn->query($sql);

    // Fetch user data as an associative array
    $user = $result->fetch_assoc();

    // Close the database connection
    $conn->close();

    // Return user data as JSON
    header('Content-Type: application/json');
    echo json_encode($user);
} else {
    echo json_encode(array()); // Return an empty JSON object if user_id is not set
}
?>
