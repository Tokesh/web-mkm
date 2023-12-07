<?php
// Подключение к базе данных (замените значения на свои)
$host = 'localhost'; // Your database host
$dbname = 'testendterm'; // Your database name
$username = 'root'; // Your database username
$password = ''; // Your database password

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", 'root', '');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Ошибка подключения к базе данных: " . $e->getMessage());
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Получите значения из сессии и формы
    session_start();
    $userId = $_SESSION["user_id"];
    $title = $_POST["post"];
    
    // Установите значения по умолчанию для остальных полей
    $likesNumber = 0;
    $liked = 0;
    $retweetsNumber = 0;
    $imageUrl = "";
    
    // Установите posted_date в текущую дату
    $postedDate = date("Y-m-d H:i:s");
    
    // Установите topic_id в 1
    $topicId = 1;

    // SQL-запрос для вставки данных поста в базу данных
    $sql = "INSERT INTO postslist (title, user_id, likes_number, liked, retweets_number, image_url, posted_date, topic_id) VALUES (:title, :user_id, :likes_number, :liked, :retweets_number, :image_url, :posted_date, :topic_id)";
    
    try {
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(":title", $title);
        $stmt->bindParam(":user_id", $userId);
        $stmt->bindParam(":likes_number", $likesNumber);
        $stmt->bindParam(":liked", $liked);
        $stmt->bindParam(":retweets_number", $retweetsNumber);
        $stmt->bindParam(":image_url", $imageUrl);
        $stmt->bindParam(":posted_date", $postedDate);
        $stmt->bindParam(":topic_id", $topicId);

        $stmt->execute();
    } catch (PDOException $e) {
        die("Ошибка при выполнении SQL-запроса: " . $e->getMessage());
    }

    // После успешного сохранения данных перенаправьте пользователя на нужную страницу
    header("Location: home.html");
}
?>
