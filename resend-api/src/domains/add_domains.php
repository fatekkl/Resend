<?php

// Include Composer autoload file to load Resend SDK classes...
require __DIR__ . '../../vendor/autoload.php';


$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../');

$dotenv->load();

if (isset($_GET['name'])) {
    // Captura o valor do parâmetro
    $nameValue = $_GET['name'];
    $resend = Resend::client($_ENV["API_KEY"]);

    $resend->domains->create([
        'name' => $nameValue
    ]);

    echo "Dominio $name criado com sucesso!";
} else {
    // Caso o parâmetro não seja fornecido
    echo "Parâmetro 'name' não foi fornecido na URL.";
}

?>