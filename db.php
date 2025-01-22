<?php
$host = "pg3.sweb.ru"; 
$dbname = "kuzvladik1";
$user = "kuzvladik1";
$password = "WY7*CYGBSDnLCEHK";

try {
    // Создаем объект PDO для подключения к базе данных
    $pdo = new PDO("pgsql:host=$host;dbname=$dbname", $user, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Ошибка подключения к базе данных: " . $e->getMessage());
}
?>