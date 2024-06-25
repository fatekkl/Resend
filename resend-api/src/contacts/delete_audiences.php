<?php

// Include Composer autoload file to load Resend SDK classes...
require __DIR__ . '../../vendor/autoload.php';


$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../');

$dotenv-> load();

$resend = Resend::client($_ENV["API_KEY"]);

if ($_SERVER['REQUEST_METHOD'] === 'POST' & !empty($_GET['id'])) {

    $resend->audiences->remove($_GET['id']);

    
    echo json_encode(['message' => 'Audiencia deletada!']);
} else {
    echo json_encode(['message' => 'Este script deve ser executado em uma requisicao HTTP DELETE.']);
}
