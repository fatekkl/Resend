<?php

// Use Composer autoloader for PSR-4 compliance
require __DIR__ . '../../vendor/autoload.php';

use Dotenv\Dotenv;

$dotenv = Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $filePath = __DIR__ . '/emails_to_send.json';

    // Obter os dados JSON da requisição
    $jsonData = json_decode(file_get_contents('php://input'), true);

    if (!$jsonData) {
        http_response_code(400);
        die('Erro ao obter os dados JSON da requisição.');
    }

    $from = $jsonData['from'];
    $to = $jsonData['to'];
    $subject = $jsonData['subject'];
    $html = $jsonData['text'];
    $at = strtotime($jsonData['at']);

    $newEmail = [
        'from' => $from,
        'to' => $to,
        'subject' => $subject,
        'html' => $html,
        'at' => $at,
    ];

    // Obter os emails existentes do arquivo JSON
    $existingEmails = json_decode(file_get_contents($filePath), true);
    if (!$existingEmails) {
        $existingEmails = [];
    }

    // Adicionar o novo email ao array existente
    $existingEmails[] = $newEmail;

    // Codificar de volta para JSON e salvar no arquivo
    $jsonData = json_encode($existingEmails, JSON_PRETTY_PRINT);
    if (file_put_contents($filePath, $jsonData) === false) {
        $error = error_get_last();
        http_response_code(500);
        die('Erro ao salvar os dados no arquivo: ' . $error['message']);
    }
    

    echo "Email Agendado!!!";
}
