<?php
require '/var/www/html/resend-api/vendor/autoload.php';


use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require __DIR__ . '../../vendor/autoload.php';


$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../');

$dotenv-> load();

$mail = new PHPMailer(true);



try {
    $mail->isSMTP();
    $mail->Host = $_ENV['MAIL_HOST'];
    $mail->SMTPAuth = true;
    $mail->Username = $_ENV['MAIL_USERNAME'];
    $mail->Password = $_ENV['API_KEY'];
    $mail->SMTPSecure = $_ENV['MAIL_ENCRYPTION'];
    $mail->Port = $_ENV['MAIL_PORT'];

    $mail->setFrom('contato@onvi.com.br', 'Onvi');
    $mail->addAddress('mathtml.1105@gmail.com', 'Matheus');
    $mail->Subject = 'Teste de Envio de E-mail com PHPMailer';
    $mail->Body = 'Este é um e-mail de teste enviado com PHPMailer';

    $mail->send();
} catch (Exception $e) {
    echo 'Erro ao enviar e-mail: ' . $e->getMessage();
}
?>
