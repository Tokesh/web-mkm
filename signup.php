<?php
// Start a session
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $host = 'localhost'; // Your database host
    $dbname = 'testendterm'; // Your database name
    $username = 'root'; // Your database username
    $password = ''; // Your database password

    // Handle the signup form data
    $username = $_POST['name']; // Change 'name' to 'username'
    $email = $_POST['email'];
    $password = $_POST['password']; // You should hash the password before storing it in the database
    $confirmPassword = $_POST['confirm_password'];
    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];

    if ($password === $confirmPassword) {
        try {
            $pdo = new PDO("mysql:host=$host;dbname=$dbname", 'root', '');
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // Hash the password
            $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

            // Insert user data into the database (replace 'users' with your actual table name)
            $query = "INSERT INTO users (username, email, password, firstname, lastname) VALUES (:username, :email, :password, :firstname, :lastname)"; // Change 'name' to 'username'
            $stmt = $pdo->prepare($query);
            $stmt->bindParam(':username', $username); // Change 'name' to 'username'
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':password', $hashedPassword);
            $stmt->bindParam(':firstname', $firstname);
            $stmt->bindParam(':lastname', $lastname);
            $stmt->execute();

            // Registration successful, set up a session for the user
            $_SESSION['username'] = $username; // Change 'name' to 'username'
            // You can store other user-related information in the session as needed

            // Redirect the user to their profile or another page
            header('Location: home.html');
            exit();
        } catch (PDOException $e) {
            echo 'Error: ' . $e->getMessage();
        }
    } else {
        // Passwords do not match
        echo 'Passwords do not match. Please try again.';
    }
}
?>
