<?php
include('db.php');

// Проверяем, была ли отправлена форма
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $query = "SELECT * FROM users WHERE username = ?";
    $stmt = $pdo->prepare($query);
    $stmt->execute([$username]);
    $user = $stmt->fetch(); 
    
    if ($user && password_verify($password, $user['password'])) {
        session_start();
        
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];
        
        header('Location: dashboard.php');
        exit();
    } else {
        $error_message = "Неверное имя пользователя или пароль!";
    }
}
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Вход</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <header>
            <div class="logo">Bike Parking</div>
            <nav>
                <a href="register.php">Зарегистрироваться</a>
            </nav>
        </header>
        <div class="login-page">
            <div class="form-container">
                <h1>Вход</h1>

                <?php
                if (isset($error_message)) {
                    echo "<p class='error-message'>$error_message</p>";
                }
                ?>

                <form action="login.php" method="post">
                    <div class="form-group">
                        <label for="username">Имя пользователя:</label>
                        <input type="text" id="username" name="username" required>
                    </div>

                    <div class="form-group">
                        <label for="password">Пароль:</label>
                        <input type="password" id="password" name="password" required>
                    </div>

                    <button type="submit" class="btn">Войти</button>
                </form>

                <div class="register-link">
                    <p>Еще нет аккаунта? <a href="register.php">Зарегистрироваться</a></p>
                </div>
            </div>

            <div class="site-description custom-description">
                <h2>О сайте Bike Parking</h2>
                <p>Bike Parking - это платформа для велосипедистов, которая позволяет легко находить доступные парковки для велосипедов в городе Москва. 
                После авторизации вы сможете добавлять новые парковки, просматривать доступные варианты и использовать поиск, чтобы найти подробную информацию о парковке.
                Сайт создан для того, чтобы сделать жизнь велосипедистов удобнее.</p>
            </div>
        </div>

        <footer>
            <p>© 2025 Bike Parking. Все права защищены.</p>
        </footer>
    </div>
</body>
</html>