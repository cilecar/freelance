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

// Проверка, не существует ли уже пользователь с таким же логином
$query = "SELECT * FROM users WHERE login = '$login'";
$result = mysqli_query($db, $query);
if (mysqli_num_rows($result) > 0) {
    die('Пользователь с таким логином уже существует');
}

// Хэширование пароля
$hashedPassword = password_hash($password, PASSWORD_DEFAULT);

// Добавление нового пользователя в базу данных
$query = "INSERT INTO users (login, password) VALUES ('$login', '$hashedPassword')";
mysqli_query($db, $query);

// Закрытие соединения с базой данных
mysqli_close($db);

echo 'Регистрация прошла успешно';
?>