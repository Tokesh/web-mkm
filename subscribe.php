<?php
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

if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
    $data = json_decode(file_get_contents('php://input'), true); // Получаем данные, отправленные из JavaScript

    if (isset($data['userId'])) {
        $follower_id = $data['userId'];

        // Здесь выполните SQL-запрос для добавления записи в таблицу followers
        // Например:
        $sql = "INSERT INTO followers (user1, user2) VALUES ($user_id, $follower_id)";
        // Выполните запрос, обработайте ошибки, если они есть
        
        $result = $conn->query($sql);
        // Верните успешный ответ клиенту
        $response = array('success' => true);
    } else {
        $response = array('success' => false, 'message' => 'Не удалось получить данные о пользователе.');
    }
} else {
    $response = array('success' => false, 'message' => 'Пользователь не авторизован.');
}

header('Content-Type: application/json');
echo json_encode($response);
?>
