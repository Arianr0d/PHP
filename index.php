<?php
ini_set('display_errors', 0);
ini_set('display_startup_errors', 0);
error_reporting(E_ALL);
session_start();
?>

<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="UTF-8">
   <title>security</title>
   <link rel="stylesheet" href="css/style.css">
</head>

<body>
   <style>
      .valid {
         border: 1px solid green;
      }

      .invalid {
         border: 1px solid red;
      }
   </style>

   <div class="form_wrapper">
      <form id="start_form" class="form_1" method="POST">
         <h1 id="h1" class="hp">Форма с валидацией</h1>
         <div class="group">
            <input type="login" class="inp inp_form _req1 _login" data-rule="login" name="login" placeholder="Логин" value="wfweif">
         </div>
         <div class="group">
            <input class="inp inp_form _req1 _password" data-rule="password" name="password" placeholder="Пароль">
         </div>
         <div class="group">
            <p></p>
         </div>
         <div class="group">
            <button class="btn" id="btn1">Войти</button>
         </div>
      </form>

      <form id="second_form" class="form_2" method="POST">
         <h1 id="h1_" class="hp">Форма без валидации</h1>
         <div class="group">
            <input type="login" class="inp inp_form _req2" data-rule="login" name="login" placeholder="Логин" value="123' or 'a'='a">
         </div>
         <div class="group">
            <input class="inp inp_form _req2" data-rule="password" name="password" placeholder="Пароль" value="ewfifjwe">
         </div>
         <div class="group">
            <p></p>
         </div>
         <div class="group">
            <button class="btn" id="btn2">Войти</button>
         </div>
      </form>

      <div class="intro">
         <div class="video">
            <video class="video_media" src="css/images/A Smoky Mountains in Sao Vicente.mp4" autoplay muted loop></video>
         </div>
      </div>
   </div>

   <script src="/validate.js"></script>
</body>

</html>