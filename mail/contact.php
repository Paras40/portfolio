<?php
if (empty($_POST['name']) || empty($_POST['subject']) || empty($_POST['message']) || !filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
  http_response_code(500);
  exit();
}

require_once './phpmailer/Exception.php';
require_once './phpmailer/PHPMailer.php';
require_once './phpmailer/SMTP.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

$mail = new PHPMailer(true);

$name = strip_tags(htmlspecialchars($_POST['name']));
$email = strip_tags(htmlspecialchars($_POST['email']));
$m_subject = strip_tags(htmlspecialchars($_POST['subject']));
$message = strip_tags(htmlspecialchars($_POST['message']));

$to = "parastewari122@gmail.com"; // Change this email to your //
$subject = "$m_subject:  $name";
$body = "You have received a new message from your portfolio contact form.<br/><br />" . "Here are the details:<br /><br />Name: $name<br />Email: $email<br />Subject: $m_subject<br />Message: $message";

$from = "tiwariparas705@gmail.com";
$password = "kbdw jnng wuym kvld";

try {
  //Server settings
  $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
  $mail->isSMTP();                                            //Send using SMTP
  $mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
  $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
  $mail->Username   = $from;                     //SMTP username
  $mail->Password   = $password;                               //SMTP password
  $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
  $mail->Port       = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

  //Recipients
  $mail->setFrom($from);
  $mail->addAddress($to);

  //Content
  $mail->isHTML(true);
  $mail->Subject = $subject;
  $mail->Body    = $body;

  if ($mail->send()) {
    http_response_code(200);
  } else {
    http_response_code(500);
    // echo $mail->ErrorInfo;
  }
} catch (Exception $e) {
  http_response_code(500);
}
