<?php
include 'db.php';

try {
    $sql = "SELECT id, name FROM administrative_districts";
    $stmt = $pdo->query($sql);
    $districts = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Ошибка выполнения запроса: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Добавить велопарковку</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <header>
            <div class="logo">Bike Parking</div>
            <nav>
                <a href="dashboard.php">Назад</a>
            </nav>
        </header>

        <div class="form-container">
            <h1>Добавить велопарковку</h1>
            <form action="add_parking.php" method="post">
                <div class="form-group">
                    <label for="admarea">Административный округ:</label>
                    <select id="admarea" name="admarea" required>
                        <option value="">Выберите административный округ</option>
                        <?php foreach ($districts as $district): ?>
                            <option value="<?= htmlspecialchars($district['name']) ?>"><?= htmlspecialchars($district['name']) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="form-group">
                    <label for="address">Адресный ориентир:</label>
                    <input type="text" id="address" name="address" required>
                </div>

                <div class="form-group">
                    <label for="capacity">Количество мест:</label>
                    <input type="number" id="capacity" name="capacity" required>
                </div>

                <button type="submit" class="btn">Добавить парковку</button>
            </form>
        </div>

        <footer>
            <p>© 2025 Bike Parking. Все права защищены.</p>
        </footer>
    </div>
</body>
</html>