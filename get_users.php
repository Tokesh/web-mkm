<?php
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

// SQL query to select users
$sql = "SELECT user_id, name, img, username, description FROM who_to_follow";
$result = $conn->query($sql);

// Fetch data and store it in an array
$users = array();
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $users[] = $row;
    }
}

// Close the database connection
$conn->close();

// Return user data as JSON
header('Content-Type: application/json');
echo json_encode($users);
?>
