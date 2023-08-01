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
    // Нахождение имени пользователя по его идентификатору
    $user_id = $user['id'];
    $username_query = "SELECT username FROM users WHERE id = '$user_id'";
    $username_result = mysqli_query($db, $username_query);
    $username = mysqli_fetch_assoc($username_result)['username'];
    
    // Нахождение роли пользователя по его идентификатору
    $user_role_query = "SELECT user_role FROM users WHERE id = '$user_id'";
    $user_role_result = mysqli_query($db, $user_role_query);
    $user_role = mysqli_fetch_assoc($user_role_result)['user_role'];

    // Запись идентификатора, имени пользователя и роли в куки
    setcookie('user_id', $user['id'], time() + 3600); // 1 час
    setcookie('username', $username, time() + 3600); // 1 час
    setcookie('user_role', $user_role, time() + 3600); // 1 час

    echo '<script>alert("Авторизация успешна"); window.location.href = "index.php";</script>';
} else {
    echo '<script>alert("Неправильный логин или пароль"); window.location.href = "index.php";</script>';
}

// Закрытие соединения с базой данных
mysqli_close($db);
?>