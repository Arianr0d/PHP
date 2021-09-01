<?php

if($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $surname = $_POST['surname'];
    $middleName = $_POST['middleName'];
    $email = $_POST['email'];
    $numberPhone = $_POST['numberPhone'];
    $comment = $_POST['comment'];
    require_once('index.html');
}