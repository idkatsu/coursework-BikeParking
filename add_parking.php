<?php
include('db.php');

session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $admarea = $_POST['admarea']; 
    $address = $_POST['address']; 
    $capacity = $_POST['capacity'];

    $stmt = $pdo->prepare("SELECT * FROM pendingparking WHERE address = :address");
    $stmt->bindParam(':address', $address);
    $stmt->execute();

    if ($stmt->rowCount() > 0) {
        $message = "Парковка с таким адресом уже существует в базе данных.";
        $message_type = "error";
    } else {
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