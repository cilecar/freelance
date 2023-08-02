<?php
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
$mail = $_POST['mail'];

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

// Проверка, не существует ли уже пользователь с такой же почтой
$query = "SELECT * FROM users WHERE mail = '$mail'";
$result = mysqli_query($db, $query);
if (mysqli_num_rows($result) > 0) {
    echo '<script>alert("Пользователь с такой почтой уже существует"); window.location.href = "index.php";</script>';
    exit;
}

// Хэширование пароля
$hashedPassword = password_hash($password, PASSWORD_DEFAULT);

// Получение значения поля для повторного ввода пароля
$passwordConfirm = $_POST['password_confirm'];

// Проверка, что значения пароля и пароля для подтверждения совпадают
if ($password !== $passwordConfirm) {
    echo '<script>alert("Пароли не совпадают"); window.location.href = "register.php";</script>';
    exit;
}

// Перед отправкой запроса, подготовим данные
$stmt = $db->prepare("INSERT INTO users (username, login, password, mail, user_role) VALUES (?, ?, ?, ?, ?)");
$stmt->bind_param("sssss", $username, $login, $hashedPassword, $mail, $userRole);

// Выполнение подготовленного запроса
if ($stmt->execute()) {
    // Закрытие соединения с базой данных
    mysqli_close($db);
    echo '<script>alert("Регистрация прошла успешно"); window.location.href = "index.php";</script>';
} else {
    echo '<script>window.location.href = "index.php";</script>';
}
?>