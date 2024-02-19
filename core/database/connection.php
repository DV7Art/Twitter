<?php
$dsn = 'mysql:host=mysql; dbname=tweety';
$user = 'roots';
$pass = 'root';

try {
    $pdo = new PDO($dsn,$user, $pass);  
    echo 'Connected to the database successfully!';
} catch(PDOException $e) {
    echo 'Connection error: ' . $e -> getMessage();
}