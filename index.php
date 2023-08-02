<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="style.css">
    <title>FreeLance</title>
</head>
<body>
    <!-- Шапка -->
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
        <?php
            // Получение значения имени пользователя из куки, если оно установлено
            $username = isset($_COOKIE['username']) ? $_COOKIE['username'] : '';

            // Получение значения роли пользователя из куки, если оно установлено
            $user_role = isset($_COOKIE['user_role']) ? $_COOKIE['user_role'] : '';

            // Проверка, авторизован ли пользователь
            if (!empty($username)) {
                // Вывод кнопки "Создать объявление" для авторизованного пользователя
                echo '<button id="createAdButton" class="header-2-btn">
                        Создать объявление
                    </button>';
            } else {
                // Вывод кнопки "Войти" для неавторизованного пользователя
                echo '<button id="loginButton" class="header-2-btn">
                        Войти
                    </button>';
            }

            // Вывод имени пользователя и роли, если он авторизован
            if (!empty($username)) {
                echo '<div class="div-user">';

                echo '<img src="/img/user-alt-1-svgrepo-com.png" class="user-logo" id="userProfile">';
                    echo '<p>' . $username;
                    echo '<p>' . $user_role;
                echo '</div>';

                echo '<form method="post">';
                echo '<button type="submit" name="clear_cookies" class="btn-exit" title="Выйти из аккаунта"></button>';
                echo '</form>';
            }
        ?>
</div>

<?php
    if (isset($_POST["clear_cookies"])) {
        $past = time() - 3600; // задаем прошедшее время (1 час назад)
        foreach ($_COOKIE as $cookie_name => $cookie_value) {
            setcookie($cookie_name, $cookie_value, $past);
        }
    }
?>
    </Header>

    <!-- Форма для нового объявления -->
    <div id="div1" style="display: none">
        <form class="form" method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
            <label for="title">Название объявления:</label>
            <input class="text-field__input" type="text" name="title" id="title" minlength="5" required><br><br>

            <label for="description">Описание объявления:</label>
            <textarea style="height: 200px; resize: none" class="text-field__input scroll-bar" name="description" id="description" required></textarea><br><br>

            <label for="industry">Навыки:</label>
            <input class="text-field__input" type="text" name="industry" id="industry" required><br><br>

            <label for="budget">Бюджет в рублях:</label>
            <input class="text-field__input" type="number" name="budget" id="budget" required><br><br>

            <input style="width: 100%" class="header-2-btn" type="submit" value="Отправить">
        </form>
    </div>
    <!-- Список объявлений -->
<div id="div2">
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
                $counter = 0;

                while ($row = $result->fetch_assoc()) {
                    if ($row['status'] == 'Выполняется') {
                        continue; // Пропустить объявление, если статус равен "Выполняется"
                    }

                    $counter++;

                    echo "<div class='task-div' data-task-id='" . $row['id'] . "'>";
                        echo "<div class='task-title-budget'>";
                            echo "<p class='task-title'>" . $row['title'] . "</p>";
                            echo "<p class='task-budget'>" . $row['budget'] . " руб.</p>";
                        echo "</div>";

                        echo "<p class='task-description scroll-bar'>" . $row['description'] . "</p>";

                        echo "<div class='industry-main-div'>";
                            $industry = $row['industry']; // получение значения из базы данных или другого источника данных
                            $words = explode(" ", $industry); // разбиваем строку на массив слов
                            echo '<div class="task-div-main scroll-bar">';
                                foreach ($words as $word) {
                                    echo "<p class='task-industry'>" . $word . "</p>";
                                }
                            echo '</div>';
                            echo "<button class='btn-order'>Откликнуться</button>";
                        echo "</div>";
                    echo "</div>";
                }

                if ($counter == 0) {
                    echo "<p class='alert-orders'>Нет доступных заказов.</p>";
                }
            }

            $conn->close();
        ?>
    </div>
</div>

        <!-- Регистрация -->
        <div id="div3" style="display: none">
            <form class="form" action="register.php" method="POST">

                <label for="reg-username">Имя пользователя:</label>
                <input class="text-field__input" type="text" name="username" id="reg-username" minlength="5" required>

                <br>
                <br>

                <label for="reg-login">Логин:</label>
                <input class="text-field__input" type="text" name="login" id="reg-login" minlength="5" required>

                <br>
                <br>

                <label for="reg-password">Пароль:</label>
                <input class="text-field__input" type="password" name="password" id="reg-password" minlength="7" required>

                <br>
                <br>

                <h1 class="text-choiseType">Выберите роль</h1>
                <div class="div-choiseType">
                    <article class="feature1">
                        <input type="radio" id="feature1" name="user_role" value="Исполнитель">
                        <div>
                            <span>
                                Исполнитель
                            </span>
                        </div>
                    </article>
                    <article class="feature2">
                        <input type="radio" id="feature2" name="user_role" value="Заказчик">
                        <div>
                            <span>
                                Заказчик
                            </span>
                        </div>
                    </article>
                </div>


                <div class="div-register">
                    <input class="register" type="submit" value="Зарегистрироваться">
                </div>

                <div class="div-btnLogin">
                    <button id="btnLogin">Уже есть аккаунт? Войти</button>
                </div>

            </form>
        </div>

        <!-- Авторизация -->
        <div class="authorization" id="div4" style="display: none">
            <form class="form" action="login.php" method="POST">

            <label for="login-login">Логин:</label>
            <input class="text-field__input" type="text" name="login" id="login-login" minlength="5" required>

            <br>
            <br>

            <label for="login-password">Пароль:</label>
            <input class="text-field__input" type="password" name="password" id="login-password" minlength="7" required>
            
            <div class="div-joinRegister">
                <input class="joinRegister" type="submit" value="Войти">
            </div>

            <div class="div-btnRegister">
                <button id="btnRegister">Еще нет аккаунта? Зарегистрироваться</button>
            </div>

            </form>
        </div>

        <div id="div5" style="display: none">
            <h1 class="tasks-main-headtext">Объявления с вашим участием</h1>
                <div class="tasks-main">
                    <?php
                        $db = mysqli_connect('127.0.0.1', 'root', '', 'freelance');

                        if (mysqli_connect_errno()) {
                            die('Ошибка подключения к базе данных: ' . mysqli_connect_error());
                        }

                        // Получение ID авторизованного пользователя из cookie
                        $user_id = $_COOKIE['user_id'];

                        $query = "SELECT o.* FROM orders o INNER JOIN users u ON o.id_executor = u.id WHERE u.id = '$user_id'";
                        $result = mysqli_query($db, $query);

                        // Проверка наличия объявлений с участием пользователя
                        if (mysqli_num_rows($result) > 0) {
                            while ($row = mysqli_fetch_assoc($result)) {
                                // Вывод объявлений, в которых пользователь участвует
                                echo "<div class='task-div' data-task-id='" . $row['id'] . "'>";
                                echo "<div class='task-title-budget'>";
                                    echo "<p class='task-title'>" . $row['title'] . "</p>";
                                    echo "<p class='task-budget'>" . $row['budget'] . " руб.</p>";
                                echo "</div>";

                                echo "<p class='task-description scroll-bar'>" . $row['description'] . "</p>";

                                echo "<div class='industry-main-div'>";
                                    $industry = $row['industry']; // получение значения из базы данных или другого источника данных
                                    $words = explode(" ", $industry); // разбиваем строку на массив слов
                                    echo '<div class="task-div-main scroll-bar">';
                                        foreach ($words as $word) {
                                            echo "<p class='task-industry'>" . $word . "</p>";
                                        }
                                    echo '</div>';
                                    echo "<button class='btn-order'>Отказаться</button>";
                                echo "</div>";
                            echo "</div>";
                            }
                        } else {
                            echo 'Нет объявлений с вашим участием.';
                        }

                        mysqli_close($db);
                    ?>
                </div>
        </div>
    </body>
</html>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script>
    document.addEventListener("DOMContentLoaded", function() {
    var createAdButton = document.getElementById("createAdButton");
    var loginButton = document.getElementById("loginButton");

    var div1 = document.getElementById("div1");
    var div2 = document.getElementById("div2");
    var div3 = document.getElementById("div3");
    var div4 = document.getElementById("div4");
    var div5 = document.getElementById("div5");

    var username = "<?php echo $username ?>";

    // Проверяем, существует ли кнопка "createAdButton" на странице
    if (createAdButton) {
        createAdButton.addEventListener("click", function() {
            div1.style.display = "block";
            div2.style.display = "none";
            div3.style.display = "none";
            div4.style.display = "none";
            div5.style.display = "none";
        });
    }

    // Проверяем, существует ли кнопка "loginButton" на странице
    if (loginButton) {
        loginButton.addEventListener("click", function() {
            div1.style.display = "none";
            div2.style.display = "none";
            div3.style.display = "none";
            div4.style.display = "block";
            div5.style.display = "none";
        });
    }
});

    document.getElementById("btnRegister").addEventListener("click", function() {
    var div1 = document.getElementById("div1");
    var div2 = document.getElementById("div2");
    var div3 = document.getElementById("div3");
    var div4 = document.getElementById("div4");
    var div5 = document.getElementById("div5");

    if (div4.style.display === "block") {
        div5.style.display = "none";
        div3.style.display = "block";
        div4.style.display = "none";
        div2.style.display = "none";
        div1.style.display = "none";
    }
    }); 

    document.getElementById("btnLogin").addEventListener("click", function() {
    var div1 = document.getElementById("div1");
    var div2 = document.getElementById("div2");
    var div3 = document.getElementById("div3");
    var div4 = document.getElementById("div4");
    var div5 = document.getElementById("div5");

    if (div3.style.display === "block") {
        div3.style.display = "none";
        div2.style.display = "none";
        div1.style.display = "none";
        div4.style.display = "block";
        div5.style.display = "none";
    }
    }); 

    document.addEventListener("DOMContentLoaded", function() {
    var userProfile = document.getElementById("userProfile");

    var div1 = document.getElementById("div1");
    var div2 = document.getElementById("div2");
    var div3 = document.getElementById("div3");
    var div4 = document.getElementById("div4");
    var div5 = document.getElementById("div5");

    // Проверяем, существует ли кнопка "createAdButton" на странице
    if (userProfile) {
        userProfile.addEventListener("click", function() {
            div1.style.display = "none";
            div2.style.display = "none";
            div3.style.display = "none";
            div4.style.display = "none";
            div5.style.display = "block";
        });
    }
});
    

    $('.btn-order').click(function() {
    var userId = <?php echo isset($_COOKIE['user_id']) ? $_COOKIE['user_id'] : 'null'; ?>;
    var taskId = $(this).closest('.task-div').data('task-id');
    var status = 'Выполняется';
    alert("Вы установили откликнулись на объявление!"); window.location.href = "index.php";

    if (userId === null) {
        alert('Пожалуйста, авторизуйтесь для выполнения запроса');
        return;
    }

    $.ajax({
        type: 'POST',
        url: 'requestProcessing.php',
        data: {userId: userId, taskId: taskId, status: status},
        success: function(response) {
        },
        error: function() {
            alert('Ошибка при выполнении запроса');
        }
    });
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