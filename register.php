<?php
include('db.php');

// Проверяем, была ли отправлена форма
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Проверяем, существует ли уже пользователь с таким именем или email
    $query = "SELECT * FROM users WHERE username = ? OR email = ?";
    $stmt = $pdo->prepare($query);
    $stmt->execute([$username, $email]);
    $user = $stmt->fetch();

    if ($user) {
        // Если пользователь найден, выводим ошибку
        $error_message = "Пользователь с таким именем или email уже существует!";
    } else {
        // Хешируем пароль перед сохранением в базе данных
        $hashed_password = password_hash($password, PASSWORD_BCRYPT);

        // Вставляем данные в базу данных
        $insert_query = "INSERT INTO users (username, email, password) VALUES (?, ?, ?)";
        $insert_stmt = $pdo->prepare($insert_query);
        $insert_stmt->execute([$username, $email, $hashed_password]);

        header('Location: login.php');
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Регистрация</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

    <div class="container">
        <header>
            <div class="logo">Bike Parking</div>
            <nav>
                <a href="login.php">Вход</a>
            </nav>
        </header>

        <div class="register-page">
            <div class="form-container">
                <h1>Регистрация</h1>

                <?php
                if (isset($error_message)) {
                    echo "<p class='error-message'>$error_message</p>";
                }
                ?>

                <form action="register.php" method="post">
                    <div class="form-group">
                        <label for="username">Имя пользователя:</label>
                        <input type="text" id="username" name="username" required>
                    </div>

                    <div class="form-group">
                        <label for="email">Электронная почта:</label>
                        <input type="email" id="email" name="email" required>
                    </div>

                    <div class="form-group">
                        <label for="password">Пароль:</label>
                        <input type="password" id="password" name="password" required>
                    </div>

                    <button type="submit" class="btn">Зарегистрироваться</button>
                </form>
            </div>
        </div>

        <footer>
            <p>© 2025 Bike Parking. Все права защищены.</p>
        </footer>

    </div>

</body>
</html>