<?php

// Use Composer autoloader for PSR-4 compliance
require __DIR__ . '../../vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();




$command = 'curl -X POST http://apiemail.onvi.com.br/send '
    . '-H "Content-Type: application/json" '
    . '-d \'{
   "from": "contato@onvi.com.br",
   "to": "mathtml.1105@gmail.com",
   "subject": "Teste",
   "text": "testestes"
 }\'';
$interval = "* * * * *";

// RESOLVER O POR QUE ESSE COMANDO EM ESPECIFICO N ESTA FUNCIONANDO!!!!


if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $resend = Resend::client($_ENV['API_KEY']);
    $data = json_decode(file_get_contents('php://input'), true);

    $from = $data['from'];
    $to = $data['to'];
    $subject = $data['subject'];
    $html = $data['text'];


    exec('(crontab -l ; echo "' . $interval . ' ' . $command . '") | sort - | uniq - | crontab -');
} else {
    echo json_encode(['message' => 'Este script deve ser executado em uma requisição HTTP POST.']);
}
