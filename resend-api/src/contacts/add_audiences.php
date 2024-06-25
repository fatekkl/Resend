<?php

// Include Composer autoload file to load Resend SDK classes...
require __DIR__ . '../../vendor/autoload.php';


$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../');

$dotenv-> load();

$resend = Resend::client($_ENV["API_KEY"]);

if ($_SERVER['REQUEST_METHOD'] === 'POST' & !empty($_GET['name'])) {

    $resend->audiences->create([
        'name' => $_GET['name']
      ]);

    
    echo json_encode(['message' => 'Audiencia criado com sucesso!']);
} else {
    echo json_encode(['message' => 'Este script deve ser executado em uma requisicao HTTP POST.']);
}





