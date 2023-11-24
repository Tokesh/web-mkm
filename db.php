<?php
$host = 'localhost'; // or your database host
$user = 'root';
$pass = '';
$db = 'endterm';
$link = new mysqli($host, $user, $pass, $db);

if ($link->connect_error) {
    die("Connection failed: " . $link->connect_error);
}
?>
