<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Поиск велопарковки</title>
    <link rel="stylesheet" href="style.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#search').on('input', function() {
                var query = $(this).val(); // Получаем значение из поля ввода
                if (query.length >= 3) { // Запуск поиска только если длина строки >= 3
                    $.ajax({
                        url: 'search_parking.php',  // Скрипт для поиска
                        type: 'GET',
                        data: { query: query },
                        success: function(data) {
                            $('#suggestions').html(data); // Отображаем результаты
                        }
                    });
                } else {
                    $('#suggestions').html(''); // Очищаем подсказки, если строка поиска короткая
                }
            });
        });
    </script>
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
            <h1>Поиск велопарковки</h1>

            <form id="searchForm" class="form-container">
                <input 
                    type="text"
                    class="search-street-input"
                    id="search" 
                    placeholder="Введите название улицы..." 
                    autocomplete="off"
                >
                <div id="suggestions" class="suggestions-list"></div>
            </form>

            <div id="parkingInfo" class="parking-info">
               
            </div>
        </div>

        <footer>
            <p>© 2025 Bike Parking. Все права защищены.</p>
        </footer>
    </div>
</body>
</html>