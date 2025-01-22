<?php
include('db.php');

session_start();

// Проверяем, авторизован ли пользователь
if (!isset($_SESSION['user_id'])) {
    // Если пользователь не авторизован, перенаправляем его на страницу входа
    header("Location: login.php");
    exit();
}

// Получаем ID пользователя из сессии
$user_id = $_SESSION['user_id'];

// Проверяем, была ли отправлена форма
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Получаем данные из формы
    $admarea = $_POST['admarea'];
    $address = $_POST['address'];
    $capacity = $_POST['capacity'];

    // Проверка, существует ли уже парковка с таким адресом в нужном районе
    $stmt = $pdo->prepare("SELECT * FROM pendingparking WHERE address = :address AND admarea = :admarea");
    $stmt->bindParam(':address', $address);
    $stmt->bindParam(':admarea', $admarea);
    $stmt->execute();

    // Если такая парковка уже существует, выводим сообщение
    if ($stmt->rowCount() > 0) {
        $message = "Парковка с таким адресом и районом уже существует в базе данных.";
        $message_type = "error";
    } else {
        // Если такой парковки нет, вставляем новые данные в базу
        $stmt = $pdo->prepare("INSERT INTO pendingparking (admarea, address, capacity, user_id) VALUES (:admarea, :address, :capacity, :user_id)");
        $stmt->bindParam(':admarea', $admarea);
        $stmt->bindParam(':address', $address);
        $stmt->bindParam(':capacity', $capacity);
        $stmt->bindParam(':user_id', $user_id);
        $stmt->execute();

        $message = "Велопарковка будет добавлена после проверки!";
        $message_type = "success";
    }
}
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Результат добавления парковки</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
    <header>
        <div class="logo">Bike Parking</div>
        <nav>
            <a href="dashboard.php">На главную</a>
        </nav>
    </header>

    <div class="main-content">
        <div class="result-container">
            <h1>Результат операции</h1>

            <?php if (isset($message)): ?>
                <div class="message <?php echo $message_type; ?>">
                    <?php echo $message; ?>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <footer>
        <p>© 2025 Bike Parking. Все права защищены.</p>
    </footer>

</body>
</html>