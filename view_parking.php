<?php
include 'db.php';

$limit = 10;

// Получаем номер текущей страницы из параметров URL (по умолчанию 1)
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
if ($page < 1) {
    $page = 1;
}

$offset = ($page - 1) * $limit;

try {
    $sql = "SELECT admarea, address, capacity FROM bikeparking ORDER BY address LIMIT :limit OFFSET :offset";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
    $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
    $stmt->execute();

    $parkings = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Получаем общее количество записей для пагинации
    $sql_count = "SELECT COUNT(*) FROM bikeparking";
    $stmt_count = $pdo->query($sql_count);
    $total_parkings = $stmt_count->fetchColumn();

    $total_pages = ceil($total_parkings / $limit);

} catch (PDOException $e) {
    die("Ошибка выполнения запроса: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Список велопарковок</title>
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

        <div class="main-content">
            <h1>Список велопарковок</h1>

            <?php if (!empty($parkings)): ?>
                <table class="parking-table">
                    <tr>
                        <th>Район</th>
                        <th>Адрес</th>
                        <th>Количество мест</th>
                    </tr>
                    <?php foreach ($parkings as $parking): ?>
                        <tr>
                            <td><?= htmlspecialchars($parking['admarea']) ?></td>
                            <td><?= htmlspecialchars($parking['address']) ?></td>
                            <td><?= htmlspecialchars($parking['capacity']) ?></td>
                        </tr>
                    <?php endforeach; ?>
                </table>
                
                <div class="pagination">
                    <?php if ($page > 1): ?>
                        <a href="?page=<?= $page - 1 ?>">« Предыдущая</a>
                    <?php endif; ?>

                    <span>Страница <?= $page ?> из <?= $total_pages ?></span>

                    <?php if ($page < $total_pages): ?>
                        <a href="?page=<?= $page + 1 ?>">Следующая »</a>
                    <?php endif; ?>
                </div>

            <?php else: ?>
                <p>Нет доступных велопарковок.</p>
            <?php endif; ?>
        </div>

        <footer>
            <p>© 2025 Bike Parking. Все права защищены.</p>
        </footer>
    </div>
</body>
</html>