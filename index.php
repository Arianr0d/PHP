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

   <div class="intro">
      <div class="video">
         <video class="video_media" src="css/images/A Smoky Mountains in Sao Vicente.mp4" autoplay muted loop></video>
      </div>
   </div>

   <form id="start_form" class="form" action="vendor/signup.php" method="POST" enctype="multipart/form-data">
      <h1 id="h1" class="hp">Форма регистрации</h1>
      <div class="group">
         <input type="login" class="inp inp_form" data-rule="login" name="login" placeholder="Логин">
      </div>
      <div class="group">
         <input type="password" class="inp inp_form" data-rule="password" name="password" placeholder="Пароль">
      </div>
      <?php
      if ($_SESSION['message']) {
         echo '<p class="msg">' . $_SESSION['message'] . '</p>';
      }
      unset($_SESSION['message']);
      ?>
      <div class="group">
         <button type="submit" class="btn">Зарегистрироваться</button>
      </div>
   </form>
</body>

</html>