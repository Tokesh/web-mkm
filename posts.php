<?php
// Database connection parameters
$host = 'localhost'; // Your database host
$dbname = 'testendterm'; // Your database name
$username = 'root'; // Your database username
$password = ''; // Your database password

try {
    // Create a PDO instance
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", 'root', '');
    
    // Set the PDO error mode to exception
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // Fetch posts data from the database
    $query = "SELECT * FROM postslist  left join users on postslist.user_id = users.id order by posted_date;"; // Замените 'posts' на 'postslist' для вашей таблицы
    $result = $pdo->query($query);
    
    $posts = array();
    
    while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
        $posts[] = $row;
    }
    
    // Return the posts data as JSON
    header('Content-Type: application/json');
    echo json_encode($posts);
} catch (PDOException $e) {
    die("Error: " . $e->getMessage());
}
?>