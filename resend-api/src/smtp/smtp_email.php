<?php
require '/var/www/html/resend-api/vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require __DIR__ . '../../vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $mail = new PHPMailer(true);

    $json = file_get_contents('php://input');
    $data = json_decode($json, true);

    if (
        !empty($data['from']) && !empty($data['from_name']) &&
        !empty($data['to']) && !empty($data['to_name']) &&
        !empty($data['subject']) && !empty($data['body'])
    ) {
        try {
            $mail->isSMTP();
            $mail->Host = $_ENV['MAIL_HOST'];
            $mail->SMTPAuth = true;
            $mail->Username = $_ENV['MAIL_USERNAME'];
            $mail->Password = $_ENV['API_KEY'];
            $mail->SMTPSecure = $_ENV['MAIL_ENCRYPTION'];
            $mail->Port = $_ENV['MAIL_PORT'];

            $mail->setFrom($data['from'], $data['from_name']);
            $mail->addAddress($data['to'], $data['to_name']);
            $mail->Subject = $data['subject'];
            $mail->isHTML(true);
            $mail->Body = $data['body'];
            

            $mail->send();
            echo json_encode(['message' => 'Email enviado com sucesso.']);
        } catch (Exception $e) {
            echo json_encode(['message' => 'Erro ao enviar email: ' . $mail->ErrorInfo]);
        }
    } else {
        echo json_encode(['message' => 'Dados insuficientes para enviar email.']);
    }
} else {
    echo json_encode(['message' => 'Este script deve ser executado em uma requisicao HTTP POST.']);
}
?>
