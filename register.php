<?php
// Подключение к базе данных
$db = mysqli_connect('127.0.0.1', 'root', '', 'freelance');

// Проверка соединения
if (mysqli_connect_errno()) {
    die('Ошибка подключения к базе данных: ' . mysqli_connect_error());
}

// Получение данных из формы
$username = $_POST['username'];
$login = $_POST['login'];
$password = $_POST['password'];
$userRole = $_POST['user_role'];

// Проверка, не существует ли уже пользователь с таким же логином
$query = "SELECT * FROM users WHERE login = '$login'";
$result = mysqli_query($db, $query);
if (mysqli_num_rows($result) > 0) {
    echo '<script>alert("Пользователь с таким логином уже существует"); window.location.href = "index.php";</script>';
    exit;
}

// Проверка, не существует ли уже пользователь с таким же именем
$query = "SELECT * FROM users WHERE username = '$username'";
$result = mysqli_query($db, $query);
if (mysqli_num_rows($result) > 0) {
    echo '<script>alert("Пользователь с таким именем уже существует"); window.location.href = "index.php";</script>';
    exit;
}

// Хэширование пароля
$hashedPassword = password_hash($password, PASSWORD_DEFAULT);

// Добавление нового пользователя в базу данных
$query = "INSERT INTO users (username, login, `password`, user_role) VALUES ('$username', '$login', '$hashedPassword', '$userRole')";
mysqli_query($db, $query);

// Закрытие соединения с базой данных
mysqli_close($db);

echo '<script>alert("Регистрация прошла успешно"); window.location.href = "index.php";</script>';
?>