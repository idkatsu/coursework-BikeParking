<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

$username = $_SESSION['username'];
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Главная страница</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

    <div class="container">
        <header>
            <div class="logo">Bike Parking</div>
            <nav>
                <a href="session.php?action=logout">Выход</a>
            </nav>
        </header>

        <div class="main-content">
            <div class="welcome-message">
                <h1>Добро пожаловать, <?php echo htmlspecialchars($username); ?>!</h1>
                <p>Здесь вы можете добавлять и искать велопарковки в городе Москва.</p>
            </div>

            <div class="dashboard-buttons">
                <a href="index.html" class="btn">Добавить велопарковку</a>
                <a href="view_parking.php" class="btn">Посмотреть велопарковки</a>
                <a href="search_form.php" class="btn">Найти велопарковку</a>
            </div>
        </div>

        <footer>
            <p>© 2025 Bike Parking. Все права защищены.</p>
        </footer>
    </div>

</body>
</html>