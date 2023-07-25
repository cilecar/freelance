

<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="style.css">
    <title>FreeLance</title>
</head>
<body>
    <Header class="header">
        <div class="header-1">
            <img class="logo" src="img\logo.png" alt="">
            <h3 class="header-1-text">
                FreeLance
            </h3>
            <a target="_blank" href="https://telegram.org/">
                <img class="w-10" src="../img/telegram-alt-svgrepo-com.png" alt="">
            </a>
            <a href="https://vk.com">
                <img class="w-10" src="../img/vk-svgrepo-com.png" alt="">
            </a>
        </div>

        <div class="header-2">
            <button id="button" class="header-2-btn"> 
                Создать объявление
            </button>
        </div>
    </Header>


    <div id="div1" style="display: none;">
        <form class="form" method="POST" action="success.php">
            <label for="title">Название заказа:</label>
            <input class="text-field__input" type="text" name="title" id="title" required><br><br>

            <label for="description">Описание заказа:</label>
            <input class="text-field__input" name="description" id="description" required></input><br><br>

            <label for="industry">Сфера деятельности:</label>
            <input class="text-field__input" type="text" name="industry" id="industry" required><br><br>

            <label for="budget">Бюджет в рублях:</label>
            <input class="text-field__input" type="number" name="budget" id="budget" required><br><br>

            <input type="submit" value="Отправить">
        </form>
    </div>

    <div id="div2" class="tasks-main">
        <div class="tasks-main">
            <?php
                // Подключение к базе данных MySQL
                $servername = "127.0.0.1";
                $username = "root";
                $password = "";
                $dbname = "freelance";

                $conn = new mysqli($servername, $username, $password, $dbname);
                if ($conn->connect_error) {
                    die("Ошибка подключения к базе данных: " . $conn->connect_error);
                }

                // Выборка данных из базы данных, только если таблица не пустая
                $sql_check = "SELECT COUNT(*) as total FROM orders";
                $result_check = $conn->query($sql_check);
                $row_check = $result_check->fetch_assoc();

                if ($row_check['total'] > 0) {
                    // Выполнить запрос только если есть заказы
                    $sql = "SELECT * FROM orders";
                    $result = $conn->query($sql);

                    while ($row = $result->fetch_assoc()) {
                        echo "<div class='task-div'>";
                        echo "<p> 1" . $row['title'] . "</p>";
                        echo "<p> 2" . $row['industry'] . "</p>";
                        echo "<p> 3" . $row['description'] . "</p>";
                        echo "<p> 4" . $row['budget'] . "</p>";
                        echo "</div>";
                    }
                } else {
                    echo "<p>Нет доступных заказов.</p>";
                }

                $conn->close();
            ?>
        </div>
    </div>
</div>
</body>
</html>

<script>
    document.getElementById("button").addEventListener("click", function() {
            var div1 = document.getElementById("div1");
            var div2 = document.getElementById("div2");

            if (div1.style.display === "none") {
                div1.style.display = "block";
                div2.style.display = "none";
            } else {
                div1.style.display = "none";
                div2.style.display = "block";
            }
        });
</script>


