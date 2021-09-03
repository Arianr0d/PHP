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
$result = mysqli_query($connect, "SELECT 'success' AS res FROM `users` WHERE `Password` = '$password' and `Login` = '$login' LIMIT 1");

// присвоение сессии (глабальной переменной) для вывода сообщения на форме
//$_SESSION['message'] = 'Регистрация прошла успешно!';

$arr_date = array();
while ($row = mysqli_fetch_assoc($result)) {
   $arr_date[] = $row;
}

if (count($arr_date) == 0) {
   $arr_date[0]['res'] = 'Введён неверный логин или пароль!';
}

$response = array();
$response['status'] = "ok";
$response['result'] = $arr_date[0];

//header('Location: ../index.php');
header('Content-type: application/json');
echo json_encode($response);
