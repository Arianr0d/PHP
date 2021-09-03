<?php
session_start();
// подключение php-скрипта с подключением к бд
require_once 'connect.php';

// добавление в переменные логина и пароля запоненной формы
$login = $_POST['login'];
$password = $_POST['password'];
// хэширование пароля
$password = md5($password);

// запрос на добавление в бд нового пользователя
$result = mysqli_query($connect, "INSERT INTO `users` (`ID`, `Login`, `Password`) VALUES (NULL, '$login', '$password')");

// присвоение сессии (глабальной переменной) для вывода сообщения на форме
$_SESSION['message'] = 'Регистрация прошла успешно!';

$response = array();
$response['status'] = "ok";

//header('Location: ../index.php');
header('Content-type: application/json');
echo json_encode($response);
