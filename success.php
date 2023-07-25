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
        echo "Объявление успешно добавлено.";
    } else {
        echo "Ошибка: " . $sql . "<br>" . $conn->error;
    }

    $conn->close();
} else {
    echo "Ошибка: Объявление не было добавлено.";
}
?>