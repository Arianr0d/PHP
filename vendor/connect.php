<?php

// подключение к бд
$connect = mysqli_connect('localhost', 'root', 'root', 'test_security');
// проверка успешности подключения к бд
if (!$connect) {
   die('Error connect to DataBase');
}