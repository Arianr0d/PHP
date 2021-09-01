<?php
// подключение файлов
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

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

header('Content-type: application/json');
echo json_encode($response);
