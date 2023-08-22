<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'phpmailer/src/Exception.php';
require 'phpmailer/src/PHPMailer.php';

$mail = new PHPMailer(true);
$mail->CharSet = 'UTF-8';
$mail->setLanguage('en', 'phpmailer/language');
$mail->isHTML(true);

//від кого лист:
$mail->setFrom('izumseti@ukr.net', 'Валентин');
//кому надіслати:
$mail->addAddress('0660196025@ukr.net');
//тема листа:
$mail->Subject = 'Привіт!'

//рука:
$hand = "Правша";
if ($_POST['hand']=="left") {
   $hand ="Лівша";
}

//тіло листа:
$body = '<h1>Зустрічайте супер-лист!!!</h1>';

if (trim(!empty($_POST["name"]))) {
   $body.='<p><strong>Імя:</strong> '.$_POST['name'].'</p>';
}
if (trim(!empty($_POST["email"]))) {
$body.='<p><strong>E-Mail:</strong> '.$_POST['e-mail'].'</p>';
}
if (trim(!empty($_POST["hand"]))) {
$body.='<p><strong>Рука:</strong> '.$_hand.'</p>';
}
if (trim(!empty($_POST["message"]))) {
   $body .= '<p><strong>Повідомлення:</strong> '.$_POST['message'].'</p>';
}
if (trim(!empty($_POST["age"]))) {
   $body .= '<p><strong>Вік:</strong> '.$_POST['age'].'</p>';
}

//прикріпити файл:
if (!empty($_FILES['image']['tmp_name'])) {
   //шлях завантаження файлу:
   $filePath = __DIR__ . "/files/" . $_FILES['image']['tmp_name'];
   //вантажимо файл:
   if (copy($_FILES['image']['tmp_name'], $filePath)) {
      $fileAttach = $filePath;
      $body.='<p><strong>Фото у вкладенні</strong></p>';
      $mail->addAttachment($fileAttach);
   }
}

$mail->Body = $body;

//відправляємо:
if (!$mail->send()) {
   $message = 'Error';
} else{
   $message = 'Дані відправлено!';
}

$response ['message' => $message];

header('Content-type: application/json');
echo json_encode($response);
?>