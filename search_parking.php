<?php
include 'db.php';

if (isset($_GET['query'])) {
    $query = $_GET['query']; // Получаем запрос из поля ввода

    try {
        // Запрос для поиска парковок в двух таблицах
        $sql = "
            SELECT admarea, address, capacity, type FROM bikeparking WHERE address LIKE :query
            UNION
            SELECT admarea, address, capacity, type FROM privateparking WHERE address LIKE :query
        ";
        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(':query', $query . '%', PDO::PARAM_STR); // Подстановка введенной строки
        $stmt->execute();

        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if (!empty($results)) {
            foreach ($results as $parking) {
                echo "<div class='suggestion' onclick='showDetails(\"{$parking['admarea']}\", \"{$parking['address']}\", \"{$parking['capacity']}\", \"{$parking['type']}\")'>";
                echo htmlspecialchars($parking['address']); // Показываем только адрес в подсказках
                echo "</div>";
            }
        } else {
            echo "Нет результатов.";
        }
    } catch (PDOException $e) {
        die("Ошибка выполнения запроса: " . $e->getMessage());
    }
}
?>

<script>
    function showDetails(admarea, address, capacity, type) {
        document.getElementById('parkingInfo').innerHTML = 
            "<h2>Район: " + admarea + "</h2><p>Адрес: " + address + "</p><p>Количество мест: " + capacity + "</p><p>Тип: " + type;
        document.getElementById('suggestions').innerHTML = '';
    }
</script>