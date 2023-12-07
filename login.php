<?php
// Start a session
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $host = 'localhost'; // Your database host
    $dbname = 'testendterm'; // Your database name
    $username = 'root'; // Your database username
    $password = ''; // Your database password

    // Handle the login form data
    $loginEmail = $_POST['loginEmail'];
    $loginPassword = $_POST['loginPassword']; // You should hash the password when storing it in the database

    try {
        $pdo = new PDO("mysql:host=$host;dbname=$dbname", 'root', '');
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Fetch user data from the database based on the email (replace 'users' with your actual table name)
        $query = "SELECT * FROM users WHERE email = :email";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':email', $loginEmail);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($loginPassword, $user['password'])) {
            // Login successful, set up a session for the user
            $_SESSION['user_id'] = $user['id'];
            // You can store other user-related information in the session as needed

            // Redirect the user to their profile or another page
            header('Location: home.html');
            exit();
        } else {
            // Login failed
            echo 'Login failed. Please check your email and password.';
        }

        $pdo = null;
    } catch (PDOException $e) {
        echo 'Error: ' . $e->getMessage();
    }
}
?>