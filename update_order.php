<?php
   $db = mysqli_connect('127.0.0.1', 'root', '', 'freelance');
   
   if (mysqli_connect_errno()) {
       die('Ошибка подключения к базе данных: ' . mysqli_connect_error());
   }
   
   // Получение идентификатора задания и значений идентификатора исполнителя и статуса
   $taskId = $_POST['taskId'];
   $executorId = null;
   $status = null;
   
   // Обновление значений в базе данных
   $query = "UPDATE orders SET id_executor = ?, status = ? WHERE id = ?";
   $statement = mysqli_prepare($db, $query);
   mysqli_stmt_bind_param($statement, 'iss', $executorId, $status, $taskId);
   mysqli_stmt_execute($statement);
   
   mysqli_close($db);
   ?>