<?php

// Use Composer autoloader for PSR-4 compliance
require __DIR__ . '../../vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();

$resend = Resend::client($_ENV['API_KEY']);

$id = $_GET['id'];

$mail = $resend->emails->get($id);

$response = [
    'status' => $mail->last_event
];


echo json_encode($response);