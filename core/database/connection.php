<?php
$dsn = 'mysql:host=localhost; dbname=test';
$user = 'root';
$pass = 'root';

try {
    $pdo = new PDO($dsn,$user, $pass);  
} catch(PDOException $e) {
    echo 'Connection error: ' . $e -> getMessage();
}