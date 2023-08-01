<?php
// Подключение к базе данных
$db = mysqli_connect('127.0.0.1', 'root', '', 'freelance');

// Проверка соединения
if (mysqli_connect_errno()) {
    die('Ошибка подключения к базе данных: ' . mysqli_connect_error());
}

// Получение данных из формы
$login = $_POST['login'];
$password = $_POST['password'];

// Поиск пользователя в базе данных по логину
$query = "SELECT * FROM users WHERE login = '$login'";
$result = mysqli_query($db, $query);
$user = mysqli_fetch_assoc($result);

if (password_verify($password, $user['password'])) {
    setcookie('user_id', $user['id'], time() + 3600); // 1 час
    echo '<script>alert("Авторизация успешна"); window.location.href = "index.php";</script>';
} else {
    echo '<script>alert("Неправильный логин или пароль"); window.location.href = "index.php";</script>';
}

// Закрытие соединения с базой данных
mysqli_close($db);
?>