<?php
// Подключение к базе данных (замените данными для вашей базы данных)
$host = 'localhost'; // Your database host
$dbname = 'testendterm'; // Your database name
$username = 'root'; // Your database username
$password = ''; // Your database password

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", 'root', '');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Error: " . $e->getMessage());
}

// Получение введенного текста из GET-запроса
if (isset($_GET['search'])) {
    $searchText = $_GET['search'];
    
    // SQL-запрос для поиска пользователей (пример с оператором LIKE)
    $sql = "SELECT * FROM users WHERE username LIKE :searchText OR firstname LIKE :searchText OR lastname LIKE :searchText";

    // Подготовка запроса
    $stmt = $pdo->prepare($sql);

    // Привязка параметра
    $stmt->bindParam(':searchText', $searchText, PDO::PARAM_STR);

    // Выполнение запроса
    $stmt->execute();

    // Получение результатов
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Создание ассоциативного массива с результатами и найденным searchText
    $response = array(
        'searchText' => $searchText,
        'results' => $results
    );

    // Возвращение результатов в формате JSON
    header('Content-Type: application/json');
    echo json_encode($response);
} else {
    // Если параметр search не задан, верните пустой результат
    echo json_encode(array());
}
?>
