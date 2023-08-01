<?php
session_start();

$servername = "127.0.0.1";
$username = "root";
$password = "";
$dbname = "freelance";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Ошибка подключения к базе данных: " . $conn->connect_error);
}

$userId = $_POST['userId'];
$taskId = $_POST['taskId'];
$status = $_POST['status'];

// Обновление таблицы "orders"
$sql = "UPDATE orders SET id_executor = '$userId', status = '$status' WHERE id = '$taskId'";
if ($conn->query($sql) === TRUE) {
    echo "Запрос успешно выполнен";
} else {
    echo "Ошибка выполнения запроса: " . $conn->error;
}

$conn->close();
?>