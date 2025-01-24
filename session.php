<?php
session_start();

// Проверяем, авторизован ли пользователь
function checkAuthorization() {
    if (!isset($_SESSION['user_id'])) {
        header("Location: login.php");
        exit;
    }
}

// Функция для завершения сессии
function logout() {
    session_unset();
    session_destroy();
    header("Location: login.php");
    exit;
}

// Обработка действия выхода, если передан параметр logout
if (isset($_GET['action']) && $_GET['action'] === 'logout') {
    logout();
}

// Получение текущего ID пользователя из сессии
function getCurrentUserId() {
    return $_SESSION['user_id'] ?? null;
}