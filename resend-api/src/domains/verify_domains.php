<?php

// Include Composer autoload file to load Resend SDK classes...
require __DIR__ . '../../vendor/autoload.php';


$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../');

$dotenv-> load();

// Assign a new Resend Client instance to $resend variable, which is automatically autoloaded...
$resend = Resend::client($_ENV["API_KEY"]);

if (isset($_GET['id'])) {
    // Captura o valor do parâmetro
    $idValue = $_GET['id'];
    $resend = Resend::client($_ENV["API_KEY"]);
    
    $resend->domains->verify($idValue);
} else {
    // Caso o parâmetro não seja fornecido
    echo "Parâmetro 'id' não foi fornecido na URL.";
}

