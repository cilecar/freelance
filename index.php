<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="style.css">
    <title>FreeLance</title>
</head>
<body>
    <Header class="header">
        <div class="header-1">
            <a href="/"><img class="logo" src="img\logo.png" alt=""></a>
            <h3 class="header-1-text">
                FreeLance
            </h3>
            <a target="_blank" href="https://telegram.org/">
                <img class="w-10" src="../img/telegram-alt-svgrepo-com.png" alt="">
            </a>
            <a href="https://vk.com">
                <img class="w-10" src="../img/vk-fill-svgrepo-com.png" alt="">
            </a>
        </div>

        <div class="header-2">
            <button id="button" class="header-2-btn"> 
                Создать объявление
            </button>
        </div>
    </Header>


    <div id="div1" style="display: none; opacity: 0;">
        <form class="form" method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
            <label for="title">Название объявления:</label>
            <input class="text-field__input" type="text" name="title" id="title" required><br><br>

            <label for="description">Описание объявления:</label>
            <textarea style="height: 200px; resize: none" class="text-field__input scroll-bar" name="description" id="description" required></textarea><br><br>

            <label for="industry">Навыки:</label>
            <input class="text-field__input" type="text" name="industry" id="industry" required><br><br>

            <label for="budget">Бюджет в рублях:</label>
            <input class="text-field__input" type="number" name="budget" id="budget" required><br><br>

            <input style="width: 100%" class="header-2-btn" type="submit" value="Отправить">
        </form>
    </div>

    <div id="div2" style="display: block; opacity: 1;">
        <h1 class="tasks-main-headtext">Список объявлений</h1>
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
                            echo "<div class='task-title-budget'>";
                                echo "<p class='task-title'>" . $row['title'] . "</p>";
                                echo "<p class='task-budget'>" . $row['budget'] . " руб.</p>";
                            echo "</div>";

                                echo "<p class='task-description scroll-bar'>" . $row['description'] . "</p>";
                                
                                echo "<div class='industry-main-div'>";
                                    $industry = $row['industry']; // получение значения из базы данных или другого источника данных
                                        $words = explode(" ", $industry); // разбиваем строку на массив слов

                                        foreach ($words as $word) {
                                        echo "<p class='task-industry'>" . $word . "</p>";
                                    }
                                echo "</div>";
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

    if (div1.style.opacity === "0") {
        div1.style.opacity = "1";
        div2.style.opacity = "0";
    } else {
        div1.style.opacity = "0";
        div2.style.opacity = "1";
    }

    // Установите задержку перед изменением display
    setTimeout(function() {
        if (div1.style.opacity === "0") {
            div1.style.display = "none";
            div2.style.display = "block";
        } else {
            div1.style.display = "block";
            div2.style.display = "none";
        }
    }, 550);
});
</script>


<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Получение данных из формы
    $title = $_POST['title'];
    $description = $_POST['description'];
    $industry = $_POST['industry'];
    $budget = $_POST['budget'];

    // Подключение к базе данных MySQL
    $servername = "127.0.0.1";
    $username = "root";
    $password = "";
    $dbname = "freelance";

    $conn = new mysqli($servername, $username, $password, $dbname);
    if ($conn->connect_error) {
        die("Ошибка подключения к базе данных: " . $conn->connect_error);
    }

    // Вставка данных в базу данных
    $sql = "INSERT INTO orders (title, description, industry, budget)
            VALUES ('$title', '$description', '$industry', '$budget')";

    if ($conn->query($sql) === TRUE) {
        echo "
        <script type='text/javascript'>
            alert('Объявление успешно добавлено.');
            window.location.href = 'index.php';
        </script>";
    } else {
        echo "
        <script type='text/javascript'>
            alert('Ошибка: Объявление не было добавлено.');
            window.location.href = 'index.php';
        </script>";
    }

    $conn->close();
}
?>