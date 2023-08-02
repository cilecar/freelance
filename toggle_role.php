<?php
// Подключение к базе данных
$servername = "127.0.0.1"; // Адрес сервера базы данных
$username = "root"; // Имя пользователя базы данных
$password = ""; // Пароль базы данных
$dbname = "freelance"; // Имя базы данных

// Создание подключения
$conn = new mysqli($servername, $username, $password, $dbname);

// Проверка подключения
if ($conn->connect_error) {
    die("Ошибка подключения к базе данных: " . $conn->connect_error);
}

// Получение текущего значения роли пользователя из куки
$user_role = isset($_COOKIE['user_role']) ? $_COOKIE['user_role'] : '';

// Производим переключение роли пользователя
$new_user_role = ($user_role == 'Заказчик') ? 'Исполнитель' : 'Заказчик';

// Получаем имя пользователя из куки
$username = isset($_COOKIE['username']) ? $_COOKIE['username'] : '';

// Обновляем значение роли пользователя в базе данных
$stmt = $conn->prepare("UPDATE users SET user_role = ? WHERE username = ?");
$stmt->bind_param("ss", $new_user_role, $username);
$stmt->execute();
$stmt->close();

// Устанавливаем новое значение роли пользователя в куки
setcookie('user_role', $new_user_role, time() + (86400 * 30), "/"); // Установка куки на 30 дней

// Закрываем подключение к базе данных
$conn->close();

// Возвращаем успешный статус
http_response_code(200);
?>