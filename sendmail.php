<?php
// подключение файлов
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// подключение php-скрипта с подключением к бд
require_once 'connect.php';

require 'phpmailer/src/PHPMailer.php';
require 'phpmailer/src/Exception.php';
require 'phpmailer/src/SMTP.php';

// объявление PHPMailer
$mail = new PHPMailer(true);
// указание кодировки
$mail->CharSet = 'UTF-8';
// подключение языковой папки
$mail->setLanguage('ru', 'phpmailer/language/');
// возможность использования html -тэгов в письме
$mail->IsHTML(true);
$mail->isSMTP();
$mail->SMTPAuth   = true;
$mail->Debugoutput = function ($str, $level) {
   $GLOBALS['status'][] = $str;
};

// Настройки вашей почты
$mail->Host = 'smtp.yandex.ru';
$mail->Port = 465;
$mail->Username = 'PHP-TEST-MAILER@yandex.ru';
$mail->Password = 'jkkyfjcvknrkiubm';
$mail->SMTPSecure = 'ssl';

// от кого письмо
$mail->setFrom('PHP-TEST-MAILER@yandex.ru', 'Форма обратной связи');
// адресат
$mail->addAddress('tatyana.comolyh@gmail.com');
// Тема письма
$mail->Subject = 'Форма обратной связи';

$body = '';
// содержимое письма
if (trim(!empty($_POST['surname']))) {
   $body .= '<p><strong>Фамилия:</strong> ' . $_POST['surname'] . '</p>';
}
if (trim(!empty($_POST['name']))) {
   $body .= '<p><strong>Имя:</strong> ' . $_POST['name'] . '</p>';
}
if (trim(!empty($_POST['middleName']))) {
   $body .= '<p><strong>Отчество:</strong> ' . $_POST['middleName'] . '</p>';
}
if (trim(!empty($_POST['email']))) {
   $body .= '<p><strong>E-mail:</strong> ' . $_POST['email'] . '</p>';
}
if (trim(!empty($_POST['numberPhone']))) {
   $body .= '<p><strong>Номер телефона:</strong> ' . $_POST['numberPhone'] . '</p>';
}
if (trim(!empty($_POST['comment']))) {
   $body .= '<p><strong>Комментарий:</strong> ' . $_POST['comment'] . '</p>';
}

$mail->Body = $body;

// обработчик отправки письма
if (!$mail->send()) {
   $message = 'При отправке произошла ошибка!';
} else {
   $message = 'Данные отправлены успешно!';
}

//формирование json-файла
$response = array();
$response['message'] = $message;
$response['name'] = $_POST['name'];
$response['surname'] = $_POST['surname'];
$response['middleName'] = $_POST['middleName'];
$response['email'] = $_POST['email'];
$response['numberPhone'] = $_POST['numberPhone'];
$response['comment'] = $_POST['comment'];

$name = $_POST['name'];
$surname = $_POST['surname'];
$middlename = $_POST['middleName'];
$email = $_POST['email'];
$numberphone = $_POST['numberPhone'];
$connect = $_POST['comment'];
$datasend = date("Y-m-d H:i:s");

$check_user = mysqli_query($connecting, "SELECT `DateSend`,  TIMEDIFF('01:30:00',TIMEDIFF('$datasend', `DateSend`)) AS wait FROM `formsend`
WHERE `EmailUser` LIKE '$email' and `DateSend` >= DATE_SUB('$datasend', INTERVAL 90 MINUTE) ORDER BY `DateSend` DESC");

$arr_date = array();
while ($row = mysqli_fetch_assoc($check_user)) {
   $arr_date[] = $row;
}

if (sizeof($arr_date) == 0) {
   // запрос на добавление в бд нового пользователя
   mysqli_query($connecting, "INSERT INTO `formsend` (`IdUser`, `NameUser`, `SurnameUser`, `MiddlenameUser`, `EmailUser`, `NumberPhoneUser`, `CommentUser`, `DateSend`) VALUES (NULL, '$name', '$surname', '$middlename', '$email', '$numberphone', '$connect', '$datasend')");

   $response['result'] = 'success';
   $response['status'] = 'nice';
} else {
   $response['status'] = $arr_date[0]['wait'];
   $response['result'] = 'wait';
}

header('Content-type: application/json');
echo json_encode($response);
