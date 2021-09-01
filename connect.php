<?php

// подключение к бд
$connecting = mysqli_connect('localhost', 'root', 'root', 'test_security');
// проверка успешности подключения к бд
if (!$connecting) {
   die('Error connect to DataBase');
}
